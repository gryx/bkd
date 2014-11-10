<?php
/* $Id: starter_portfolio.php,v 1.6 2013/01/25 12:30:18 rp Exp $
 *
 * PDF portfolio starter:
 * Package multiple PDF and other documents into a PDF portfolio
 * The generated PDF portfolio requires Acrobat 9 for proper
 * viewing. The documents in the Portfolio will be assigned predefined
 * and custom metadata fields; for the custom fields a schema description
 * is created.
 *
 * Acrobat 8 will only display a "PDF package" with a flat list of documents
 * without any folder structure.
 *
 * Required software: PDFlib/PDFlib+PDI/PPS 9
 * Required data: PDF and other input documents
 */

/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';

class document {
    public function document($filename, $description, $status, $id) {
	$this->filename = $filename;
	$this->description = $description;
	$this->status = $status;
	$this->id = $id;
    }

    public $filename;
    public $description;
    public $status;
    public $id;
}

/* The documents for the Portfolio along with description and metadata */
$root_folder_docs = array(
    new document("TIR_____.AFM", "Metrics for Times-Roman", "internal",
	    200),
    new document("nesrin.jpg", "Zabrisky point", "archived", 300) );

$datasheet_docs = array(
    new document("PDFlib-real-world.pdf", "PDFlib in the real world",
	    "published", 100),
    new document("PDFlib-datasheet.pdf", "Generate PDF on the fly",
	    "published", 101),
    new document("TET-datasheet.pdf",
	    "Extract text and images from PDF", "published", 102),
    new document("PLOP-datasheet.pdf",
	    "PDF Linearization, Optimization, Protection", "published",
	    103),
    new document("pCOS-datasheet.pdf",
	    "PDF Information Retrieval Tool", "published", 104) );

try {
    $p = new pdflib();
    $p->set_option("SearchPath={{" . $searchpath . "}}");

    /* This means we must check return values of load_font() etc. */
    $p->set_option("errorpolicy=return");

    /* all strings are expected as utf8 */
    $p->set_option("stringformat=utf8");

    if ($p->begin_document("", "compatibility=1.7ext3") == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_portfolio");

    /*
     * Insert all files for the root folder along with their description
     * and the following custom fields: status string describing the
     * document status id numerical identifier, prefixed with "PHX"
     */
    for ($i = 0; $i < count($root_folder_docs); $i++) {
	$optlist = "description={" . $root_folder_docs[$i]->description
		. "} " . "fieldlist={ {key=status value="
		. $root_folder_docs[$i]->status . "} {key=id value="
		. $root_folder_docs[$i]->id . " prefix=PHX type=text} }";

	/* 0 means root folder */
	$p->add_portfolio_file(0, $root_folder_docs[$i]->filename, $optlist);
    }

    /* Create the "datasheets" folder in the root folder */
    $folder = $p->add_portfolio_folder(0, "datasheets", "");

    /*
     * Insert documents in the "datasheets" folder along with
     * description and custom fields
     */
    for ($i = 0; $i < count($datasheet_docs); $i++) {
	$optlist = "description={" . $datasheet_docs[$i]->description
		. "} fieldlist={ {key=status value="
		. $datasheet_docs[$i]->status . "} {key=id value="
		. $datasheet_docs[$i]->id . " prefix=PHX type=text} }";

	/* Add the file to the "datasheets" $folder */
	$p->add_portfolio_file($folder, $datasheet_docs[$i]->filename,
		$optlist);
    }

    /* Create a single-page document as cover sheet */
    $p->begin_page_ext(0, 0, "width=a4.width height=a4.height");

    $font = $p->load_font("Helvetica", "unicode", "");
    if ($font == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->setfont($font, 24);
    $p->fit_textline("Welcome to the PDFlib Portfolio sample!", 50, 700, "");

    $p->end_page_ext("");

    /* Set options for Portfolio display */
    $optlist = "portfolio={initialview=detail ";

    /* Add schema definition for Portfolio metadata */
    $optlist .= 
	"schema={ "
	
	/* Some predefined fields are included here to make them visible. */
	. "{order=1 label=Name key=_filename visible editable} "
	. "{order=2 label=Description key=_description visible} "
	. "{order=3 label=Size key=_size visible} "
	. "{order=4 label={Last edited} key=_moddate visible} "

	/* User-defined fields */
	. "{order=5 label=Status key=status type=text editable} "
	. "{order=6 label=ID key=id type=text editable} ";

    $optlist .= "}}";

    $p->end_document($optlist);

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_portfolio.pdf");
    print $buf;
}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_portfolio sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
