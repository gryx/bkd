<?php
/* $Id: starter_geospatial.php,v 1.7 2013/01/25 10:36:36 rp Exp $
 * Starter for georeferenced PDF:
 * Import an image with a map and add geospatial reference information
 *
 * Sample map and coordinates:
 * We use a map from www.openstreetma$p->com; the geospatial coordinates of the
 * image edges were also provided by that Web site.
 * The coordinate system is WGS84 which is also used for GPS.
 *
 * Required software: PDFlib/PDFlib+PDI/PPS 9
 * Required data: image file and associated geospatial reference information
 */

/* This is where the data files are. Adjust if necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';
$outfile = "";

$imagefile = "munich.png";

/* WKT for plain latitude/longitude values in WGS84 */
$georef = "worldsystem={type=geographic wkt={"
    . "GEOGCS[\"WGS 84\","
    . "  DATUM[\"WGS_1984\", SPHEROID[\"WGS 84\", 6378137,298.257223563]],"
    . "  PRIMEM[\"Greenwich\", 0.0],"
    . "  UNIT[\"Degree\", 0.01745329251994328]]"
    . "}} linearunit=M areaunit=SQM angularunit=degree";

/* world coordinates of the image (in degrees) */
$worldpoints = array(
    48.145, /* latitude of top edge */
    11.565, /* longitude of left edge */
    11.59, /* longitude of right edge */
    48.13 /* latitude of bottom edge */
);

try {
    $p = new pdflib();

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    /* This means we must check return values of load_font() etc. */
    $p->set_option("errorpolicy=return");

    /* all strings are expected as utf8 */
    $p->set_option("stringformat=utf8");

    /* Start the document */
    if ($p->begin_document($outfile, "compatibility=1.7ext3") == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_geospatial");

    /* Generate georeference option list */
    /* Use the four corners as reference points; (0,0)=lower left etc. */
    $georefoptlist = "georeference={" . $georef
	    . " mappoints={0 0  1 0  1 1  0 1} ";

    $georefoptlist .= "worldpoints={";

    /* lower left corner */
    $georefoptlist .= $worldpoints[3] . " " . $worldpoints[1] . " ";
    /* lower right corner */
    $georefoptlist .= $worldpoints[3] . " " . $worldpoints[2] . " ";
    /* upper right corner */
    $georefoptlist .= $worldpoints[0] . " " . $worldpoints[2] . " ";
    /* upper left corner */
    $georefoptlist .= $worldpoints[0] . " " . $worldpoints[1] . " ";

    $georefoptlist .= "} }";

    /* Load the image with geospatial reference attached */
    $image = $p->load_image("auto", $imagefile, $georefoptlist);
    if ($image == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->begin_page_ext(0, 0, "width=a4.width height=a4.height");

    /* Create caption */
    $p->fit_textline("Map with geospatial reference information",
	50, 700,
	"fontname=LuciduxSans-Oblique encoding=unicode fontsize=18");

    /* Place the map on the page */
    $p->fit_image($image, 50, 50, "boxsize={500 600} fitmethod=meet");

    $p->end_page_ext("");

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_geospatial.pdf");
    print $buf;
}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_geospatial sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
