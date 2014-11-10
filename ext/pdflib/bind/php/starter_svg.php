<?php
/* $Id: starter_svg.php,v 1.4 2013/01/29 16:21:53 rp Exp $
 * Starter SVG:
 * Load SVG graphics and fit into a box
 *
 * Required software: PDFlib/PDFlib+PDI/PPS 9
 * Required data: SVG graphics
 */

$searchpath = "../data";
$outfile = "";

$graphicsfile = "PDFlib-logo.svg";
$x = 100; $y = 300;
$boxwidth = 400; $boxheight = 400;

try {
    $p = new pdflib();

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    /* This means we must check return values of load_graphics() etc. */
    $p->set_option("errorpolicy=return");

    /* all strings are expected as utf8*/
    $p->set_option("stringformat=utf8");

    if ($p->begin_document($outfile, "") == 0)
	throw new Exception("Error: " . $p->get_errmsg());

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_svg");

    /* Load the graphics */
    $graphics = $p->load_graphics("auto", $graphicsfile, "");
    if ($graphics == 0)
	throw new Exception("Error: " . $p->get_errmsg());

    $p->begin_page_ext(0, 0, "width=a4.width height=a4.height");

    /* ------------------------------------------------------
     * Fit the graphics into a box with proportional resizing
     * ------------------------------------------------------
     */

    /* The "boxsize" option defines a box with a given width and height 
     * and its lower left corner located at the reference point.
     * "position={center}" positions the graphics in the center of the
     * box.
     * "fitmethod=meet" resizes the graphics proportionally until its 
     * height or width completely fits into the box.
     * The "showborder" option is used to illustrate the borders of the 
     * box 
     */
    $optlist = "boxsize={ " . $boxwidth . " " . $boxheight . 
	      "} position={center} fitmethod=meet showborder";

    /* Before actually fitting the graphics we check whether fitting is
     * possible.
     */
    if ($p->info_graphics($graphics, "fittingpossible", $optlist) == 1)
    {
	$p->fit_graphics($graphics, $x, $y, $optlist);
    }
    else
    {
	throw new Exception("Cannot place graphics: " . $p->get_errmsg());
    }

    $p->end_page_ext("");

    $p->close_graphics($graphics);


    $p->end_document("");
    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_svg.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_svg sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
