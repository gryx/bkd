<?php

/* $Id: starter_shaping.php,v 1.6 2013/01/25 12:30:18 rp Exp $
 * Starter sample for text shaping features
 * Demonstrate text shaping for Arabic, Hebrew, Devanagari, and Thai scripts
 * Right-to-left text is reordered according to the Bidi algorithm.
 *
 * Required software: PDFlib/PDFlib+PDI/PPS 9
 * Required data: suitable fonts for the scripts
 */

/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';
$outfile = "";

$llx = 50; $lly = 50; $urx = 800; $ury = 550;

$header = array(
	"Language", "Raw input", "Reordered and shaped output"
);
$MAXCOL = count($header);

class shaping {
    public function shaping($fontname, $optlist, $textflow, $language, $text) {
	$this->fontname = $fontname;
	$this->optlist = $optlist;
	$this->textflow = $textflow;
	$this->language = $language;
	$this->text = $text;
    }

    public $fontname;         /* name of the font for this script */
    public $optlist;          /* text options */
    public $textflow;          /* can't use Textflow for Bidi text */
    public $language;         /* language name */
    public $text;             /* sample text */
}

$shapingsamples = array(
/* Dummys to compensate for header row and +/-1 indexing in C */
new shaping( "", "", 0, "", "" /* dummy1 */ ),
new shaping( "", "", 0, "", "" /* dummy2 */ ),

/* -------------------------- Arabic -------------------------- */
new shaping( "ScheherazadeRegOT", "shaping script=arab", 0, "Arabic",
"&#x0627;&#x0644;&#x0639;&#x064E;&#x0631;&#x064E;&#x0628;&#x0650;" .
"&#x064A;&#x0629;" ),

new shaping( "ScheherazadeRegOT", "shaping script=arab", 0, "Arabic",
"&#x0645;&#x0631;&#x062D;&#x0628;&#x0627;! (Hello)"),

new shaping( "ScheherazadeRegOT", "shaping script=arab", 0, "Arabic",
"&#xFEFF;&#x0627;&#x0644;&#x0645;&#x0627;&#x062F;&#x0629;&#x0020;" .
"&#x0031;&#x0020;&#x064A;&#x0648;&#x0644;&#x062F;&#x0020;&#x062C;" .
"&#x0645;&#x064A;&#x0639;&#x0020;&#x0627;&#x0644;&#x0646;&#x0627;" .
"&#x0633;&#x0020;&#x0623;&#x062D;&#x0631;&#x0627;&#x0631;&#x064B;" .
"&#x0627;&#x0020;&#x0645;&#x062A;&#x0633;&#x0627;&#x0648;&#x064A;" .
"&#x0646;&#x0020;&#x0641;&#x064A;&#x0020;&#x0627;&#x0644;&#x0643;" .
"&#x0631;&#x0627;&#x0645;&#x0629;&#x0020;&#x0648;&#x0627;&#x0644;" .
"&#x062D;&#x0642;&#x0648;&#x0642;&#x002E;&#x0020;"),

new shaping( "ScheherazadeRegOT", "shaping script=arab", 0, "Arabic",
"&#x0648;&#x0642;&#x062F;&#x0020;&#x0648;&#x0647;&#x0628;&#x0648;" .
"&#x0627;&#x0020;&#x0639;&#x0642;&#x0644;&#x0627;&#x064B;&#x0020;" .
"&#x0648;&#x0636;&#x0645;&#x064A;&#x0631;&#x064B;&#x0627;&#x0020;" .
"&#x0648;&#x0639;&#x0644;&#x064A;&#x0647;&#x0645;&#x0020;&#x0623;" .
"&#x0646;&#x0020;&#x064A;&#x0639;&#x0627;&#x0645;&#x0644;&#x0020;" .
"&#x0628;&#x0639;&#x0636;&#x0647;&#x0645;&#x0020;&#x0628;&#x0639;" .
"&#x0636;&#x064B;&#x0627;&#x0020;&#x0628;&#x0631;&#x0648;&#x062D;" .
"&#x0020;&#x0627;&#x0644;&#x0625;&#x062E;&#x0627;&#x0621;&#x002E;"),

/* -------------------------- Hebrew -------------------------- */
new shaping( "SILEOT", "shaping script=hebr", 0, "Hebrew",
  "&#x05E2;&#x05B4;&#x05D1;&#x05B0;&#x05E8;&#x05B4;&#x05D9;&#x05EA;"),

new shaping( "SILEOT", "shaping script=hebr", 0, "Hebrew",
"&#x05E1;&#x05E2;&#x05D9;&#x05E3;&#x0020;&#x05D0;&#x002E;&#x0020;" .
"&#x05DB;&#x05DC;&#x0020;&#x05D1;&#x05E0;&#x05D9;&#x0020;&#x05D0;" .
"&#x05D3;&#x05DD;&#x0020;&#x05E0;&#x05D5;&#x05DC;&#x05D3;&#x05D5;" .
"&#x0020;&#x05D1;&#x05E0;&#x05D9;&#x0020;&#x05D7;&#x05D5;&#x05E8;" .
"&#x05D9;&#x05DF;&#x0020;&#x05D5;&#x05E9;&#x05D5;&#x05D5;&#x05D9;" .
"&#x05DD;&#x0020;&#x05D1;&#x05E2;&#x05E8;&#x05DB;&#x05DD;&#x0020;" .
"&#x05D5;&#x05D1;&#x05D6;&#x05DB;&#x05D5;&#x05D9;&#x05D5;&#x05EA;" .
"&#x05D9;&#x05D4;&#x05DD;&#x002E;&#x0020;"),

new shaping( "SILEOT", "shaping script=hebr", 0, "Hebrew",
"&#x05DB;&#x05D5;&#x05DC;&#x05DD;&#x0020;&#x05D7;&#x05D5;&#x05E0;" .
"&#x05E0;&#x05D5;&#x0020;&#x05D1;&#x05EA;&#x05D1;&#x05D5;&#x05E0;" .
"&#x05D4;&#x0020;&#x05D5;&#x05D1;&#x05DE;&#x05E6;&#x05E4;&#x05D5;" .
"&#x05DF;&#x002C;&#x0020;"),

new shaping( "SILEOT", "shaping script=hebr", 0, "Hebrew",
"&#x05DC;&#x05E4;&#x05D9;&#x05DB;&#x05DA;&#x0020;&#x05D7;&#x05D5;" .
"&#x05D1;&#x05D4;&#x0020;&#x05E2;&#x05DC;&#x05D9;&#x05D4;&#x05DD;" .
"&#x0020;&#x05DC;&#x05E0;&#x05D4;&#x05D5;&#x05D2;&#x0020;&#x05D0;" .
"&#x05D9;&#x05E9;&#x0020;&#x05D1;&#x05E8;&#x05E2;&#x05D4;&#x05D5;" .
"&#x0020;&#x05D1;&#x05E8;&#x05D5;&#x05D7;&#x0020;&#x05E9;&#x05DC;" .
"&#x0020;&#x05D0;&#x05D7;&#x05D5;&#x05D4;&#x002E;"),

/* -------------------------- Hindi -------------------------- */
new shaping( "raghu8", "shaping script=deva", 1, "Hindi",
  "&#x0939;&#x093F;&#x0928;&#x094D;&#x0926;&#x0940;"),

new shaping( "raghu8", "shaping script=deva advancedlinebreak", 1, "Hindi",
"&#x0905;&#x0928;&#x0941;&#x091A;&#x094D;&#x091B;&#x0947;&#x0926;" .
"&#x0020;&#x0967;&#x002E;&#x0020;&#x0938;&#x092D;&#x0940;&#x0020;" .
"&#x092E;&#x0928;&#x0941;&#x0937;&#x094D;&#x092F;&#x094B;&#x0902;" .
"&#x0020;&#x0915;&#x094B;&#x0020;&#x0917;&#x094C;&#x0930;&#x0935;" .
"&#x0020;&#x0914;&#x0930;&#x0020;&#x0905;&#x0927;&#x093F;&#x0915;" .
"&#x093E;&#x0930;&#x094B;&#x0902;&#x0020;&#x0915;&#x0947;&#x0020;" .
"&#x092E;&#x093E;&#x092E;&#x0932;&#x0947;&#x0020;&#x092E;&#x0947;" .
"&#x0902;&#x0020;&#x091C;&#x0928;&#x094D;&#x092E;&#x091C;&#x093E;" .
"&#x0924;&#x0020;&#x0938;&#x094D;&#x0935;&#x0924;&#x0928;&#x094D;" .
"&#x0924;&#x094D;&#x0930;&#x0924;&#x093E;&#x0020;&#x0914;&#x0930;" .
"&#x0020;&#x0938;&#x092E;&#x093E;&#x0928;&#x0924;&#x093E;&#x0020;" .
"&#x092A;&#x094D;&#x0930;&#x093E;&#x092A;&#x094D;&#x0924;&#x0020;" .
"&#x0939;&#x0948;&#x0020;&#x0964;&#x0020;&#x0909;&#x0928;&#x094D;" .
"&#x0939;&#x0947;&#x0902;&#x0020;&#x092C;&#x0941;&#x0926;&#x094D;" .
"&#x0918;&#x093F;&#x0020;&#x0914;&#x0930;&#x0020;&#x0905;&#x0928;" .
"&#x094D;&#x0924;&#x0930;&#x093E;&#x0924;&#x094D;&#x092E;&#x093E;" .
"&#x0020;&#x0915;&#x0940;&#x0020;&#x0926;&#x0947;&#x0928;&#x0020;" .
"&#x092A;&#x094D;&#x0930;&#x093E;&#x092A;&#x094D;&#x0924;&#x0020;" .
"&#x0939;&#x0948;&#x0020;&#x0914;&#x0930;&#x0020;&#x092A;&#x0930;" .
"&#x0938;&#x094D;&#x092A;&#x0930;&#x0020;&#x0909;&#x0928;&#x094D;" .
"&#x0939;&#x0947;&#x0902;&#x0020;&#x092D;&#x093E;&#x0908;&#x091A;" .
"&#x093E;&#x0930;&#x0947;&#x0020;&#x0915;&#x0947;&#x0020;&#x092D;" .
"&#x093E;&#x0935;&#x0020;&#x0938;&#x0947;&#x0020;&#x092C;&#x0930;" .
"&#x094D;&#x0924;&#x093E;&#x0935;&#x0020;&#x0915;&#x0930;&#x0928;" .
"&#x093E;&#x0020;&#x091A;&#x093E;&#x0939;&#x093F;&#x090F;&#x0020;" .
"&#x0964;"),

/* -------------------------- Sanskrit -------------------------- */
new shaping( "raghu8", "shaping script=deva", 1, "Sanskrit",
"&#x0938;&#x0902;&#x0938;&#x094D;&#x0915;&#x0943;&#x0924;&#x092E;" .
"&#x094D;"),

new shaping( "raghu8", "shaping script=deva", 1, "Sanskrit",
"&#x0905;&#x0928;&#x0941;&#x091A;&#x094D;&#x091B;&#x0947;&#x0926;" .
"&#x003A;&#x0020;&#x0031;&#x0020;&#x0938;&#x0930;&#x094D;&#x0935;" .
"&#x0947;&#x0020;&#x092E;&#x093E;&#x0928;&#x0935;&#x093E;&#x003A;" .
"&#x0020;&#x0938;&#x094D;&#x0935;&#x0924;&#x0928;&#x094D;&#x0924;" .
"&#x094D;&#x0930;&#x093E;&#x003A;&#x0020;&#x0938;&#x092E;&#x0941;" .
"&#x0924;&#x094D;&#x092A;&#x0928;&#x094D;&#x0928;&#x093E;&#x003A;" .
"&#x0020;&#x0935;&#x0930;&#x094D;&#x0924;&#x0928;&#x094D;&#x0924;" .
"&#x0947;&#x0020;&#x0905;&#x092A;&#x093F;&#x0020;&#x091A;&#x002C;" .
"&#x0020;&#x0917;&#x094C;&#x0930;&#x0935;&#x0926;&#x0943;&#x0936;" .
"&#x093E;&#x0020;&#x0905;&#x0927;&#x093F;&#x0915;&#x093E;&#x0930;" .
"&#x0926;&#x0943;&#x0936;&#x093E;&#x0020;&#x091A;&#x0020;&#x0938;" .
"&#x092E;&#x093E;&#x0928;&#x093E;&#x003A;&#x0020;&#x090F;&#x0935;" .
"&#x0020;&#x0935;&#x0930;&#x094D;&#x0924;&#x0928;&#x094D;&#x0924;" .
"&#x0947;&#x0964;&#x0020;&#x090F;&#x0924;&#x0947;&#x0020;&#x0938;" .
"&#x0930;&#x094D;&#x0935;&#x0947;&#x0020;&#x091A;&#x0947;&#x0924;" .
"&#x0928;&#x093E;&#x002D;&#x0924;&#x0930;&#x094D;&#x0915;&#x002D;" .
"&#x0936;&#x0915;&#x094D;&#x0924;&#x093F;&#x092D;&#x094D;&#x092F;" .
"&#x093E;&#x0902;&#x0020;&#x0938;&#x0941;&#x0938;&#x092E;&#x094D;" .
"&#x092A;&#x0928;&#x094D;&#x0928;&#x093E;&#x003A;&#x0020;&#x0938;" .
"&#x0928;&#x094D;&#x0924;&#x093F;&#x0964;&#x0020;&#x0905;&#x092A;" .
"&#x093F;&#x0020;&#x091A;&#x002C;&#x0020;&#x0938;&#x0930;&#x094D;" .
"&#x0935;&#x0947;&#x093D;&#x092A;&#x093F;&#x0020;&#x092C;&#x0928;" .
"&#x094D;&#x0927;&#x0941;&#x0924;&#x094D;&#x0935;&#x002D;&#x092D;" .
"&#x093E;&#x0935;&#x0928;&#x092F;&#x093E;&#x0020;&#x092A;&#x0930;" .
"&#x0938;&#x094D;&#x092A;&#x0930;&#x0902;&#x0020;&#x0935;&#x094D;" .
"&#x092F;&#x0935;&#x0939;&#x0930;&#x0928;&#x094D;&#x0924;&#x0941;" .
"&#x0964;"),

/* -------------------------- Thai -------------------------- */
new shaping( "Norasi", "shaping script=thai advancedlinebreak locale=THA", 1, "Thai",
  "&#x0E44;&#x0E17;&#x0E22;"),

new shaping( "Norasi", "shaping script=thai advancedlinebreak", 1, "Thai",
"&#x0E02;&#x0E49;&#x0E2D;&#x0020;&#x0031;&#x0020;&#x0E21;&#x0E19;" .
"&#x0E38;&#x0E29;&#x0E22;&#x0E4C;&#x0E17;&#x0E31;&#x0E49;&#x0E07;" .
"&#x0E2B;&#x0E25;&#x0E32;&#x0E22;&#x0E40;&#x0E01;&#x0E34;&#x0E14;" .
"&#x0E21;&#x0E32;&#x0E21;&#x0E35;&#x0E2D;&#x0E34;&#x0E2A;&#x0E23;" .
"&#x0E30;&#x0E41;&#x0E25;&#x0E30;&#x0E40;&#x0E2A;&#x0E21;&#x0E2D;" .
"&#x0E20;&#x0E32;&#x0E04;&#x0E01;&#x0E31;&#x0E19;&#x0E43;&#x0E19;" .
"&#x0E40;&#x0E01;&#x0E35;&#x0E22;&#x0E23;&#x0E15;&#x0E34;&#x0E28;" .
"&#x0E31;&#x0E01;&#x0E14;&#x005B;&#x0E40;&#x0E01;&#x0E35;&#x0E22;" .
"&#x0E23;&#x0E15;&#x0E34;&#x0E28;&#x0E31;&#x0E01;&#x0E14;&#x0E34;" .
"&#x0E4C;&#x005D;&#x0E41;&#x0E25;&#x0E30;&#x0E2A;&#x0E34;&#x0E17;" .
"&#x0E18;&#x0E34;&#x0020;&#x0E15;&#x0E48;&#x0E32;&#x0E07;&#x0E21;" .
"&#x0E35;&#x0E40;&#x0E2B;&#x0E15;&#x0E38;&#x0E1C;&#x0E25;&#x0E41;" .
"&#x0E25;&#x0E30;&#x0E21;&#x0E42;&#x0E19;&#x0E18;&#x0E23;&#x0E23;" .
"&#x0E21;&#x0020;&#x0E41;&#x0E25;&#x0E30;&#x0E04;&#x0E27;&#x0E23;" .
"&#x0E1B;&#x0E0F;&#x0E34;&#x0E1A;&#x0E31;&#x0E15;&#x0E34;&#x0E15;" .
"&#x0E48;&#x0E2D;&#x0E01;&#x0E31;&#x0E19;&#x0E14;&#x0E49;&#x0E27;" .
"&#x0E22;&#x0E40;&#x0E08;&#x0E15;&#x0E19;&#x0E32;&#x0E23;&#x0E21;" .
"&#x0E13;&#x0E4C;&#x0E41;&#x0E2B;&#x0E48;&#x0E07;&#x0E20;&#x0E23;" .
"&#x0E32;&#x0E14;&#x0E23;&#x0E20;&#x0E32;&#x0E1E;"),
);

$MAXROW = count($shapingsamples); 

try {
    $p = new pdflib();

    $p->set_option("SearchPath={{" . $searchpath . "}}");
    $p->set_option("charref=true");

    /* This means that formatting and other errors will raise an
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
    $p->set_info("Title", "starter_shaping");

    $table = 0;

    /* Create table header */
    for ($row=1, $col=1; $col <= $MAXCOL; $col++)
    {
	$optlist = sprintf(
       "fittextline={fontname=Helvetica-Bold encoding=unicode fontsize=14} " .
       "colwidth=%s", $col==1 ? "10%" : "45%" );
	$table = $p->add_table_cell($table, $col, $row, $header[$col-1],
		$optlist);
    }

    /* Create shaping samples */
    for ($row=2; $row < $MAXROW; $row++)
    {
	$col=1;

	/* Column 1: language name */
	$optlist = sprintf(
	    "fittextline={fontname=Helvetica encoding=unicode fontsize=12}");
	$table = $p->add_table_cell($table, $col++, $row,
	    $shapingsamples[$row]->language, $optlist);

	/* Column 2: raw text */
	$optlist = sprintf("fontname={%s} encoding=unicode fontsize=13 " .
	    "leading=150%% alignment=left", $shapingsamples[$row]->fontname);
	$tf = $p->create_textflow($shapingsamples[$row]->text, $optlist);
	$optlist = sprintf(
	    "margin=4 fittextflow={verticalalign=top} textflow=%d", $tf);
	$table = $p->add_table_cell($table, $col++, $row, NULL, $optlist);

	/* Column 3: shaped and reordered text (Textline or Textflow) */
	if ($shapingsamples[$row]->textflow)
	{
	    $optlist = sprintf("fontname={%s} encoding=unicode fontsize=13 %s ".
	       "leading=150%% alignment=left",
	       $shapingsamples[$row]->fontname, $shapingsamples[$row]->optlist);
	    $tf = $p->create_textflow($shapingsamples[$row]->text, $optlist);
	    $optlist = sprintf(
		"margin=4 fittextflow={verticalalign=top} textflow=%d", $tf);
	    $table = $p->add_table_cell($table, $col++, $row, NULL, $optlist);
	} else {
	    $optlist = sprintf( "fittextline={fontname={%s} encoding=unicode " .
	       "fontsize=13 %s}", $shapingsamples[$row]->fontname,
	       $shapingsamples[$row]->optlist);
	    $table = $p->add_table_cell($table, $col++, $row,
		     $shapingsamples[$row]->text, $optlist);
	}
    }

    /* ---------- Place the table on one or more pages ---------- */
    /*
     * Loop until all of the table is placed; create new pages
     * as long as more table instances need to be placed.
     */
    do {
	$p->begin_page_ext(0, 0, "width=a4.height height=a4.width");

	/* Shade every other row; draw lines for all table cells. */
	$optlist = sprintf( "header=1 fill={{area=rowodd " .
	    "fillcolor={gray 0.9}}} stroke={{line=other}} ");

	/* Place the table instance */
	$result = $p->fit_table($table, $llx, $lly, $urx, $ury, $optlist);

	if ($result  == "_error") {
	    throw new Exception("Error: " . $p->get_errmsg());
	}

	$p->end_page_ext("");

    } while ($result == "_boxfull");

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_shaping.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_shaping sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
