<?php

/* $Id: starter_opentype.php,v 1.8 2013/01/25 12:11:10 rp Exp $
 * Starter sample for OpenType font features
 *
 * Demonstrate various typographic OpenType features after checking
 * whether a particular feature is supported in a font.
 *
 * Required software: PDFlib/PDFlib+PDI/PPS 9
 * Required data: suitable fonts with OpenType feature tables
 *
 * This sample uses a default font which includes a few features.
 * For better results you should replace the default font with a suitable
 * commercial font. Depending on the implementation of the features you
 * may also have to replace the sample text below.
 *
 * Some ideas for suitable test fonts:
 * Palatino Linotype: standard Windows font with many OpenType features
 */


/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';
$outfile = "";

$llx = 50;
$lly = 50;
$urx = 800;
$ury = 550;

/* This font will be used unless another one is specified in the table */
$defaulttestfont = "DejaVuSerif";

$header = array(
    "OpenType feature",
    "Option list",
    "Font name",
    "Raw input (feature disabled)",
    "Feature enabled"
);
$MAXCOL = 5;

$testcases = array(
array(
  "description"=>"ligatures",
  "fontname"=>"",
  "feature"=>"liga",
   "text"=>"ff fi fl ffi ffl"
),
array(
  "description"=>"discretionary ligatures",
  "fontname"=>"",
  "feature"=>"dlig",
   "text"=>"st c/o"
),
array(
  "description"=>"historical ligatures",
  "fontname"=>"",
  "feature"=>"hlig",
   "text"=>"&.longs;b &.longs;t"
),
array(
  "description"=>"small capitals",
  "fontname"=>"",
  "feature"=>"smcp",
   "text"=>"PostScript"
),
array(
  "description"=>"ordinals",
  "fontname"=>"",
  "feature"=>"ordn",
   "text"=>"1o 2a 3o"
),
array(
  "description"=>"fractions",
  "fontname"=>"",
  "feature"=>"frac",
   "text"=>"1/2 1/4 3/4"
),
array(
  "description"=>"alternate fractions",
  "fontname"=>"",
  "feature"=>"afrc",
   "text"=>"1/2 1/4 3/4"
),
array(
  "description"=>"slashed zero",
  "fontname"=>"",
  "feature"=>"zero",
   "text"=>"0"
),
array(
  "description"=>"historical forms",
  "fontname"=>"",
  "feature"=>"hist",
   "text"=>"s"
),
array(
  "description"=>"proportional figures",
  "fontname"=>"",
  "feature"=>"pnum",
   "text"=>"0123456789"
),
array(
  "description"=>"old-style figures",
  "fontname"=>"",
  "feature"=>"onum",
   "text"=>"0123456789"
),
array(
  "description"=>"lining figures",
  "fontname"=>"",
  "feature"=>"lnum",
   "text"=>"0123456789"
),
array(
  "description"=>"superscript",
  "fontname"=>"",
  "feature"=>"sups",
   "text"=>"0123456789"
)
);
$n_testcases = 13;

try {
    $p = new PDFlib();

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
    if ($p->begin_document($outfile, "") == -1) {
	die("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_opentype");

    /* Start Page */
    $p->begin_page_ext(0, 0, "width=a4.height height=a4.width");

    $table = 0;

    /* Table header */
    for ($row=1, $col=1; $col <= $MAXCOL; $col++)
    {
	$optlist = sprintf(
       "fittextline={fontname=Helvetica-Bold encoding=unicode fontsize=12} " .
       "margin=4"
       );
	$table = $p->add_table_cell($table, $col, $row, $header[$col-1],
		$optlist);
    }

    /* Create a table with feature samples, one feature per table row */
    for ($row=2, $test=0; $test < $n_testcases; $row++, $test++)
    {
	/* Use the entry in the test table if available, and the
	 * default test font otherwise. This way we can easily check
	 * a font for all features, as well as insert suitable fonts
	 * for individual features.
	 */
	if ($testcases[$test]["fontname"] != "")
	    $testfont = $testcases[$test]["fontname"];
	else
	    $testfont = $defaulttestfont;

	$col=1;

	/* Common option list for columns 1-3 */
	$optlist = sprintf(
	"fittextline={fontname=Helvetica encoding=unicode fontsize=12} " .
	"margin=4");

	/* Column 1: feature description */
	$table = $p->add_table_cell($table, $col++, $row,
	    $testcases[$test]["description"], $optlist);

	/* Column 2: option list */
	$buf = sprintf( "features={%s}", $testcases[$test]["feature"]);
	$table = $p->add_table_cell($table, $col++, $row, $buf, $optlist);

	/* Column 3: font name */
	$table = $p->add_table_cell($table, $col++, $row, $testfont,
		$optlist);

	/* Column 4: raw input text with  feature disabled */
	$optlist = sprintf(
	     "fittextline={fontname={%s} encoding=unicode fontsize=12 " .
	     "embedding} margin=4", $testfont);
	$table = $p->add_table_cell($table, $col++, $row,
		$testcases[$test]["text"], $optlist);

	/* Column 5: text with enabled feature, or warning if the
	 * feature is not available in the font
	 */
	$font = $p->load_font($testfont, "unicode", "embedding");

	/* Check whether font contains the required feature table */
	$optlist = sprintf( "name=%s", $testcases[$test]["feature"]);
	if ($p->info_font($font, "feature", $optlist) == 1)
	{
	    /* feature is available: apply it to the text */
	    $optlist = sprintf(
		 "fittextline={fontname={%s} encoding=unicode fontsize=12 " .
		 "embedding features={%s}} margin=4",
		 $testfont, $testcases[$test]["feature"]);
	    $table = $p->add_table_cell($table, $col++, $row,
	       $testcases[$test]["text"], $optlist);
	}
	else
	{
	    /* feature is not available: emit a warning */
	    $optlist = sprintf(
		 "fittextline={fontname=Helvetica encoding=unicode " .
		 "fontsize=12 fillcolor=red} margin=4");
	    $table = $p->add_table_cell($table, $col++, $row,
		    "(feature not available in this font)", $optlist);
	}

    }

    /* Place the table */
    $optlist = sprintf( "header=1 fill={{area=rowodd " .
	"fillcolor={gray 0.9}}} stroke={{line=other}} ");
    $result = $p->fit_table($table, $llx, $lly, $urx, $ury, $optlist);

    if ($result == "_error")
    {
	die("Error: " . $p->get_errmsg());
    }

    $p->end_page_ext("");
    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_opentype.pdf");
    print $buf;
}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_opentype sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
