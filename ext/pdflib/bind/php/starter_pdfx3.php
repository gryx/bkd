<?php
/* $Id: starter_pdfx3.php,v 1.7 2013/01/25 12:11:10 rp Exp $
 *
 * PDF/X-3 starter:
 * Create PDF/X-3 conforming output
 *
 * Required software: PDFlib/PDFlib+PDI/PPS 9
 * Required data: font file, image file, icc profile
 *                (see www.pdflib.com for ICC profiles)
 */

/* This is where the data files are. Adjust as necessary.*/
$searchpath = dirname(dirname(__FILE__)).'/data';
$imagefile = "nesrin.jpg";
$outfilename = "";

try {
    $p = new PDFlib();

    /* This means we must check return values of load_font() etc. */
    $p->set_option("errorpolicy=return");

    /* all strings are expected as utf8 */
    $p->set_option("stringformat=utf8");

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    if ($p->begin_document($outfilename, "pdfx=PDF/X-3:2003") == 0) {
	die("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_pdfx3");

    /*
     * You can use one of the Standard output intents (e.g. for SWOP
     * printing) which do not require an ICC profile:

    $p->load_iccprofile("CGATS TR 001", "usage=outputintent");

     * However, if you use ICC or Lab color you must load an ICC
     * profile as output intent:
     */
    if ($p->load_iccprofile("ISOcoated.icc", "usage=outputintent") == -1) {
	printf("Error: %s\n", $p->get_errmsg());
	printf("Please install the ICC profile package from " .
	    "www.pdflib.com to run the PDF/X starter sample.\n");
	$p->delete(p);
	return(2);
    }

    $p->begin_page_ext(595, 842, "");

    /* $font embedding is required for PDF/X */
    $font = $p->load_font("LuciduxSans-Oblique", "unicode", "embedding");
    if ($font == 0) {
	die("Error: " . $p->get_errmsg());
    }
    $p->setfont($font, 24);

    $spot = $p->makespotcolor("PANTONE 123 C");
    $p->setcolor("fill", "spot", $spot, 1.0, 0.0, 0.0);
    $p->fit_textline("PDF/X-3:2003 starter", 50, 700, "");

    /* The RGB $image below needs an $icc profile; we use sRGB. */
    $icc = $p->load_iccprofile("sRGB", "");
    $image = $p->load_image("auto", $imagefile, "iccprofile=" . $icc);

    if ($image == 0) {
	die("Error: " . $p->get_errmsg());
    }

    $p->fit_image($image, 0.0, 0.0, "scale=0.5");

    $p->end_page_ext("");

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_pdfx3.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_pdfx3 sample:\n" .
	"[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
	$e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
