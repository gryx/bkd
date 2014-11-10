<?php
/* $Id: starter_pdfx5g.php,v 1.9 2013/01/25 12:30:18 rp Exp $
 *
 * PDF/X-5g starter:
 * Create PDF/X-5g conforming output with a reference to an external page
 *
 * The external document from which a page is referenced must conform to
 * one of the following standards:
 * PDF/X-1a:2003, PDF/X-3:2002, PDF/X-4, PDF/X-4p, PDF/X-5g, or PDF/X-5pg
 *
 * In order to properly display and print the referenced target page with
 * Acrobat you must configure Acrobat appropriately (see PDFlib Tutorial),
 * and the target PDF must be available to Acrobat.
 *
 * Required software: PDFlib/PDFlib+PDI/PPS 9
 * Required data: font file, external PDF/X target, ICC output intent profile
 *                (see www.pdflib.com for ICC profiles)
 */

$searchpath = dirname(dirname(__FILE__)).'/data';
$targetname = "x5target.pdf";


$linewidth = 2;

try {
    $p = new pdflib();

    /* This means we must check return values of load_font() etc. */
    $p->set_option("errorpolicy=return");

    /* all strings are expected as utf8 */
    $p->set_option("stringformat=utf8");

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    if ($p->begin_document("", "pdfx=PDF/X-5g") == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_pdfx5g");

    /* Open the output intent profile */
    if ($p->load_iccprofile("ISOcoated.icc", "usage=outputintent") == 0) {
	print("Error: " . $p->get_errmsg() . "\n");
	print("Please install the ICC profile package from "
		. "www.pdflib.com to run the PDF/X starter sample.\n");
	$p->delete();
	return(2);
    }

    /* Font embedding is required for PDF/X */
    $font = $p->load_font("LuciduxSans-Oblique", "unicode", "embedding");

    if ($font == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    /*
     * Create a template which will serve as proxy. The referenced page
     * (the target) is attached to the proxy. The width and height
     * The template width and height will be determined automatically,
     * so we don't have to supply them.
     */
    $optlist = "reference={filename=" . $targetname . " pagenumber=1}";
    $proxy = $p->begin_template_ext(0, 0, $optlist);

    if ($proxy == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    $width  = $p->info_image($proxy, "imagewidth", "");
    $height = $p->info_image($proxy, "imageheight", "");

    /*
     * Draw a crossed-out rectangle to visualize the proxy. Attention:
     * if we use the exact corner points, one half of the linewidth
     * would end up outside the template, and therefore be clipped.
     */
    $p->setlinewidth($linewidth);
    $p->moveto($linewidth / 2, $linewidth / 2);
    $p->lineto($width - $linewidth / 2, $linewidth / 2);
    $p->lineto($width - $linewidth / 2, $height - $linewidth / 2);
    $p->lineto($linewidth / 2, $height - $linewidth / 2);
    $p->lineto($linewidth / 2, $linewidth / 2);
    $p->lineto($width - $linewidth / 2, $height - $linewidth / 2);

    $p->moveto($width - $linewidth / 2, $linewidth / 2);
    $p->lineto($linewidth / 2, $height - $linewidth / 2);
    $p->stroke();

    $p->setfont($font, 24);

    $optlist = "fitmethod=auto position=center boxsize={" . $width . " "
	    . $height . "}";
    $p->fit_textline("Proxy replaces target here", 0, 0, $optlist);

    $p->end_template_ext(0, 0);

    /* Create the page */
    $p->begin_page_ext(595, 842, "");

    $p->setfont($font, 18);

    $p->fit_textline(
	"PDF/X-5 starter sample with reference to an external page",
	50, 700, "");

    /* Place the proxy on the page */
    $p->fit_image($proxy, 50, 50, "boxsize={500 500} fitmethod=meet");

    $p->end_page_ext("");
    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_pdfx5g.pdf");
    print $buf;
}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_pdfx5g sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
