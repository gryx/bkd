<?php
/* $Id: starter_pdfa1b.php,v 1.8 2013/01/25 12:11:10 rp Exp $
 *
 * PDF/A-1b starter:
 * Create PDF/A-1b conforming output
 *
 * Required software: PDFlib/PDFlib+PDI/PPS 9
 * Required data: font file, image file
 */

/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';
$imagefile = "nesrin.jpg";
$outfilename = "";

try {
    $p = new PDFlib();


    # This means we must check return values of load_font() etc.
    $p->set_option("errorpolicy=return");

    # all strings are expected as utf8
    $p->set_option("stringformat=utf8");

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    /* PDF/A-1a requires Tagged PDF */
    if ($p->begin_document($outfilename, "pdfa=PDF/A-1b:2005") == 0) {
	die("Error: " . $p->get_errmsg());
    }

    /*
     * We use sRGB as output intent since it allows the color
     * spaces CIELab, ICC-based, grayscale, and RGB.
     *
     * If you need CMYK color you must use a CMYK output profile.
     */

    $p->load_iccprofile("sRGB", "usage=outputintent");

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_pdfa1b");

    $p->begin_page_ext(595, 842, "");

    /* $font embedding is required for PDF/A */
    $font = $p->load_font("LuciduxSans-Oblique", "unicode", "embedding");
    if ($font == 0) {
	die("Error: " . $p->get_errmsg());
    }
    $p->setfont($font, 24);

    $p->fit_textline("PDF/A-1b:2005 starter", 50, 700, "");

    /* We can use an RGB $image since we already supplied an
     * output intent profile.
     */
    $image = $p->load_image("auto", $imagefile, "");

    if ($image == 0) {
	die("Error: " . $p->get_errmsg());
    }

    /* Place the $image at the bottom of the page */
    $p->fit_image($image, 0.0, 0.0, "scale=0.5");

    $p->end_page_ext("");
    $p->close_image($image);

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_pdfa1b.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_pdfa1b sample:\n" .
	"[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
	$e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
