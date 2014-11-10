<?php
/* $Id: starter_fallback.php,v 1.10 2013/01/25 14:14:54 rp Exp $
 * Starter sample for fallback fonts
 *
 * Required software: PDFlib/PDFlib+PDI/PPS 9
 * Required data: suitable fonts, Japanese CMaps
 */
/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';
$outfile = "";

$llx = 50; $lly = 50; $urx = 800; $ury = 550;

$headers = array( "Use case",
    "Option list for the 'fallbackfonts' option", "Base font",
    "With fallback font" );

class testcase {
    public function testcase($usecase, $fontname, $encoding,
	    $fallbackoptions, $text) {
	$this->usecase = $usecase;
	$this->fontname = $fontname;
	$this->encoding = $encoding;
	$this->fallbackoptions = $fallbackoptions;
	$this->text = $text;
    }

    public $usecase;
    public $fontname;
    public $encoding;
    public $fallbackoptions;
    public $text;
}

$testcases = array(
    /* Add Euro glyph to an encoding which doesn't support it */
    new testcase(
	"Extend 8-bit encoding", "Helvetica", "iso8859-1",
	"{fontname=Helvetica encoding=unicode forcechars=euro}",
	/*
	 * Reference Euro glyph by name (since it is missing from
	 * the encoding)
	 */
	"123&euro;"),
    new testcase(
	"Use Euro glyph from another font",
	"Courier",
	"winansi",
	"{fontname=Helvetica encoding=unicode forcechars=euro textrise=-5%}",
	"123&euro;"),
    new testcase("Enlarge all glyphs in a font", "Times-Italic",
	"winansi",
	/*
	 * Enlarge all glyphs to better match other fonts of the
	 * same point size
	 */
	"{fontname=Times-Italic encoding=unicode forcechars={U+0020-U+00FF} "
	. "fontsize=120%}", "font size"),

    new testcase(
	"Add enlarged pictogram", "Times-Roman", "unicode",
	/* pointing hand pictogram */
	"{fontname=ZapfDingbats encoding=unicode forcechars=.a12 fontsize=150% "
		. "textrise=-15%}", "Bullet symbol: &.a12;"),

    new testcase(
	"Add enlarged symbol glyph",
	"Times-Roman",
	"unicode",
	"{fontname=Symbol encoding=unicode forcechars=U+2663 fontsize=125%}",
	"Club symbol: &#x2663;"),
    /*
     * Greek characters missing in the font will be pulled from Symbol
     * font
     */
    new testcase(
	"Add Greek characters to Latin font", "Times-Roman",
	"unicode", "{fontname=Symbol encoding=unicode}",
	"Greek text: &#x039B;&#x039F;&#x0393;&#x039F;&#x03A3;"),
	    
    /* Font with end-user defined character (EUDC) */
    new testcase(
	"Gaiji with EUDC font", "KozMinProVI-Regular",
	"unicode",
	"{fontname=EUDC encoding=unicode forcechars=U+E000 fontsize=140% "
		. "textrise=-20%}", "Gaiji: &#xE000;"),

    /* SING fontlet containing a single gaiji character */
    new testcase(
	"Gaiji with SING font", "KozMinProVI-Regular",
	"unicode",
	"{fontname=PDFlibWing encoding=unicode forcechars=gaiji}",
	"Gaiji: &#xE000;"),

    new testcase(
	"Replace Latin characters in CJK font",
	"KozMinProVI-Regular",
	"unicode",
	"{fontname=Courier-Bold encoding=unicode forcechars={U+0020-U+007E}}",
	"Latin and &#x65E5;&#x672C;&#x8A9E;"),

    /* Requires "Unicode BMP Fallback SIL" font in fallback.ttf */
    /* Identify missing glyphs caused by workflow problems */
    new testcase(
	"Identify missing glyphs", "Times-Roman", "unicode",
	"{fontname=fallback encoding=unicode}",
	/*
	 * deliberately use characters which are not available in
	 * the base font
	 */
	"Missing glyphs: &#x1234; &#x672C; &#x8A9E;")
);

try {
    $p = new pdflib();

    $p->set_option("SearchPath={{" . $searchpath . "}}");
    $p->set_option("charref=true");
    $p->set_option("glyphcheck=replace");

    /*
     * This means that formatting and other errors will raise an
     * exception. This simplifies our sample code, but is not
     * recommended for production code.
     */
    $p->set_option("errorpolicy=exception");

    /* all strings are expected as utf8 */
    $p->set_option("stringformat=utf8");

    /* Set an output path according to the name of the topic */
    if ($p->begin_document($outfile, "") == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_fallback");

    /* Start Page */
    $p->begin_page_ext(0, 0, "width=a4.height height=a4.width");

    $table = 0;

    /* Table header */
    for ($i = 0; $i < count($headers); $i++) {
	$col = $i + 1;

	$optlist = "fittextline={fontname=Helvetica-Bold encoding=unicode fontsize=11} "
		. "margin=4";
	$table = $p->add_table_cell($table, $col, 1, $headers[$i], $optlist);
    }

    /* Create fallback samples, one use case per row */
    for ($i = 0; $i < count($testcases); $i++) {
	$row = $i + 2;
	$testcase = $testcases[$i];
	$col = 1;

	/* Column 1: description of the use case */
	$optlist = "fittextline={fontname=Helvetica encoding=unicode fontsize=11} "
		. "margin=4";
	$table = $p->add_table_cell($table, $col++, $row, $testcase->usecase,
		$optlist);

	/* Column 2: reproduce option list literally */
	$optlist = "fittextline={fontname=Helvetica encoding=unicode fontsize=10} "
		. "margin=4";
	$table = $p->add_table_cell($table, $col++, $row,
		$testcase->fallbackoptions, $optlist);

	/* Column 3: text with base font */
	$optlist = "fittextline={fontname=" . $testcase->fontname
		. " encoding=" . $testcase->encoding
		. " fontsize=11 replacementchar=? } margin=4";
	$table = $p->add_table_cell($table, $col++, $row, $testcase->text,
		$optlist);

	/* Column 4: text with base font and fallback fonts */
	$optlist = "fittextline={fontname=" . $testcase->fontname
		. " encoding=" . $testcase->encoding
		. " fontsize=11 fallbackfonts={"
		. $testcase->fallbackoptions . "}} margin=4";
	$table = $p->add_table_cell($table, $col++, $row, $testcase->text,
		$optlist);
    }

    /* Place the table */
    $optlist = "header=1 fill={{area=rowodd "
	    . "fillcolor={gray 0.9}}} stroke={{line=other}} ";
    $result = $p->fit_table($table, $llx, $lly, $urx, $ury, $optlist);

    if ($result == "_error") {
	throw new Exception("Couldn't place table: " . $p->get_errmsg());
    }

    $p->end_page_ext("");
    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_fallback.pdf");
    print $buf;
}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_fallback sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
