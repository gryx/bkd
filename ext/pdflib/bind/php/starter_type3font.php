<?php
# $Id: starter_type3font.php,v 1.12 2013/01/25 12:30:18 rp Exp $
# Type 3 font starter:
# Create a simple Type 3 font from vector data
#
# Define a type 3 font with the glyphs "l" and "space" and output text with
# that font. In addition the glyph ".notdef" is defined which any undefined
# character will be mapped to.
#
# Required software: PDFlib/PDFlib+PDI/PPS 9
# Required data: none


# This is where the data files are. Adjust as necessary.
$searchpath = dirname(dirname(__FILE__)).'/data';

try {
    # create a new PDFlib object
    $p = new PDFlib();

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    # This means we must check return values of load_font() etc.
    $p->set_option("errorpolicy=return");

    # all strings are expected as utf8 
    $p->set_option("stringformat=utf8");

    if ($p->begin_document("", "") == 0) {
	die("Error: " .  $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib Cookbook");
    $p->set_info("Title", "Starter Type 3 Font");

    # Create the font "SimpleFont" containing the glyph "l",
    # the glyph "space" for spaces and the glyph ".notdef" for any
    # undefined character

    $p->begin_font("SimpleFont",
		0.001, 0.0, 0.0, 0.001, 0.0, 0.0, "");
    /* glyph for .notdef */
    $p->begin_glyph_ext(0x0000, "width=266 boundingbox={0 0 0 0}");
    $p->end_glyph();

    /* glyph for U+0020 space */
    $p->begin_glyph_ext(0x0020, "width=266 boundingbox={0 0 0 0}");
    $p->end_glyph();

    /* glyph for U+006C "l" */
    $p->begin_glyph_ext(0x006C, "width=266 boundingbox={0 0 266 570}");
    $p->setlinewidth(20);
    $x = 197;
    $y = 10;
    $p->moveto($x, $y);
    $y += 530;
    $p->lineto($x, $y);
    $x -= 64;
    $p->lineto($x, $y);
    $y -= 530;
    $p->moveto($x, $y);
    $x += 128;
    $p->lineto($x, $y);

    $p->stroke();
    $p->end_glyph();

    $p->end_font();

    # Start page
    $p->begin_page_ext(0, 0, "width=300 height=200");

    # Load the new "SimpleFont" font
    $font = $p->load_font("SimpleFont", "unicode", "");

    if ($font == 0) {
	die("Error: " .  $p->get_errmsg());
    }

    # Output the characters "l" and "space" of the "SimpleFont" font.
    # The character "x" is undefined and will be mapped to ".notdef"

    $buf = " font=" . $font . " fontsize=40";
    $p->fit_textline("lll lllxlll", 100, 100, $buf);

    $p->end_page_ext("");

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_type3font.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_type3font sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;

?>
