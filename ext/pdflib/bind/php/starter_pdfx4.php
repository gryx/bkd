<?php
/* $Id: starter_pdfx4.php,v 1.12 2013/01/25 12:11:10 rp Exp $
 *
 * PDF/X-4 starter:
 * Create PDF/X-4 conforming output with layers and transparency
 *
 * A low-level layer is created for each of several languages, as well
 * as an image layer. 
 *
 * The document contains transparent text which is allowed in
 * PDF/X-4, but not earlier PDF/X standards.
 *
 * Required software: PDFlib/PDFlib+PDI/PPS 9
 * Required data: font file, image file, ICC output intent profile
 *                (see www.pdflib.com for ICC profiles)
 */

/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';

$imagefile = "zebra.tif";


try {
    $p = new pdflib();

    /* This means we must check return values of load_font() etc. */
    $p->set_option("errorpolicy=return");

    /* all strings are expected as utf8 */
    $p->set_option("stringformat=utf8");

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    if ($p->begin_document("", "pdfx=PDF/X-4") == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_pdfx4");

    if ($p->load_iccprofile("ISOcoated.icc", "usage=outputintent") == 0) {
	print("Error: " . $p->get_errmsg() . "\n");
	print("Please install the ICC profile package from "
		. "www.pdflib.com to run the PDF/X starter sample.\n");
	$p->delete();
	return(2);
    }

    /*
     * Define the layers; "defaultstate" specifies whether or not
     * the layer is visible when the page is opened.
     */

    $layer_english = $p->define_layer("English text", "defaultstate=true");
    $layer_german = $p->define_layer("German text", "defaultstate=false");
    $layer_french = $p->define_layer("French text", "defaultstate=false");

    /* 
     * Define a radio button relationship for the language layers.
     */

    $optlist = "group={" . $layer_english . " " . $layer_german
		. " " . $layer_french . "}";
    $p->set_layer_dependency("Radiobtn", $optlist);

    $layer_image = $p->define_layer("Images", "defaultstate=true");
    
    $p->begin_page_ext(595, 842, "");

    /* Font embedding is required for PDF/X */
    $font = $p->load_font("LuciduxSans-Oblique", "unicode", "embedding");

    if ($font == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->setfont($font, 24);

    $p->begin_layer($layer_english);

    $p->fit_textline("PDF/X-4 starter sample with layers", 50, 700, "");

    $p->begin_layer($layer_german);
    $p->fit_textline("PDF/X-4 Starter-Beispiel mit Ebenen", 50, 700, "");

    $p->begin_layer($layer_french);
    $p->fit_textline("PDF/X-4 Starter exemple avec des calques", 50, 700,
	    "");

    $p->begin_layer($layer_image);

    $p->setfont($font, 48);

    /* The RGB image needs an ICC profile; we use sRGB. */
    $icc = $p->load_iccprofile("sRGB", "");
    $optlist = "iccprofile=" . $icc;
    $image = $p->load_image("auto", $imagefile, $optlist);

    if ($image == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    /* Place a diagonal stamp across the image area */
    $width = $p->info_image($image, "width", "");
    $height = $p->info_image($image, "height", "");

    $optlist = "boxsize={" . $width . " " . $height . "} stamp=ll2ur";
    $p->fit_textline("Zebra", 0, 0, $optlist);

    /* Set transparency in the graphics state */
    $gstate = $p->create_gstate("opacityfill=0.5");
    $p->set_gstate($gstate);

    /* Place the image on the page and close it */
    $p->fit_image($image, (double) 0.0, (double) 0.0, "");
    $p->close_image($image);

    /* Close all layers */
    $p->end_layer();

    $p->end_page_ext("");

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_pdfx4.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_pdfx4 sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
