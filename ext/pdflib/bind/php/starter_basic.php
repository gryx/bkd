<?php
/* $Id: starter_basic.php,v 1.14 2013/01/25 10:36:36 rp Exp $
 *
 * Basic starter:
 * Create some simple text, vector graphics and image output
 *
 * required software: PDFlib/PDFlib+PDI/PPS 9
 * required data: none
 *
 * important: this file must be encoded in UTF-8
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

    if ($p->begin_document($outfilename, "") == 0) {
	die("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_basic");

    /* We load the $image before the first page, and use it
     * on all pages
     */
    $image = $p->load_image("auto", $imagefile, "");

    if ($image == 0) {
	die("Error: " . $p->get_errmsg());
    }

    /* Page 1 */
    $p->begin_page_ext(595, 842, "");

    /* use DejaVuSerif font with text format UTF-8 for placing the text
     * and demonstrate various options how to pass the UTF-8 text to PDFlib
     */
    $optlist = "fontname={DejaVuSerif} embedding fontsize=24 " .
	    "encoding=unicode";

    /* using plain 7 bit ASCII text */
    $p->fit_textline("en: Hello!", 50, 700, $optlist);
    /* using PHPs hexadecimal notation */
    $p->fit_textline("\x67\x72\x3A\x20\xCE\x93\xCE\xB5\xCE\xB9\xCE\xAC\x21",
	    50, 650, $optlist);
    /* using plain UTF-8 text */
    $p->fit_textline("ru: Привет!", 50, 600, $optlist);
    /* using PDFlib's character references */
    $p->fit_textline("es: &#xA1;Hola!", 50, 550, $optlist . " charref=true");


    $p->fit_image($image, 0.0, 0.0, "scale=0.25");

    $p->end_page_ext("");

    /* Page 2 */
    $p->begin_page_ext(595, 842, "");

    /* red rectangle */
    $p->setcolor("fill", "rgb", 1.0, 0.0, 0.0, 0.0);
    $p->rect(200, 200, 250, 150);
    $p->fill();

    /* blue circle */
    $p->setcolor("fill", "rgb", 0.0, 0.0, 1.0, 0.0);
    $p->arc(400, 600, 100, 0, 360);
    $p->fill();

    /* thick gray line */
    $p->setcolor("stroke", "gray", 0.5, 0.0, 0.0, 0.0);
    $p->setlinewidth(10);
    $p->moveto(100, 500);
    $p->lineto(300, 700);
    $p->stroke();

    /* Using the same $image handle means the data will be copied
     * to the PDF only once, which saves space.
     */
    $p->fit_image($image, 150.0, 25.0, "scale=0.25");
    $p->end_page_ext("");

    /* Page 3 */
    $p->begin_page_ext(595, 842, "");

    /* Fit the image to a box of predefined size (without distortion) */
    $optlist = "boxsize={400 400} position={center} fitmethod=meet";
    $p->fit_image($image, 100, 200, $optlist);

    $p->end_page_ext("");

    $p->close_image($image);
    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_basic.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_basic sample:\n" .
	"[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
	$e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
