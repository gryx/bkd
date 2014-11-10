<?php
/* $Id: businesscard.php,v 1.25 2013/01/24 16:58:59 rp Exp $
 *
 * PDFlib client: businesscard example in PHP
 */

$infile = "boilerplate.pdf";

/* This is where font/image/PDF input files live. Adjust as necessary.
 *
 * Note that this directory must also contain the LuciduxSans font outline
 * and metrics files.
 */
$searchpath = dirname(dirname(__FILE__)).'/data';

$data = array(  "name"				=> "Victor Kraxi",
		"business.title"		=> "Chief Paper Officer",
		"business.address.line1" 	=> "17, Aviation Road",
		"business.address.city"		=> "Paperfield",
		"business.telephone.voice"	=> "phone +1 234 567-89",
		"business.telephone.fax"	=> "fax +1 234 567-98",
		"business.email"		=> "victor@kraxi.com",
		"business.homepage"		=> "www.kraxi.com"
	);

try {
    $p = new PDFlib();

    # This means we must check return values of load_font() etc.
    $p->set_option("errorpolicy=return");

    /* Set the search path for fonts and PDF files */
    $p->set_option("SearchPath={{" . $searchpath . "}}");

    /* all strings are expected as utf8 */
    $p->set_option("stringformat=utf8");

    /*  open new PDF file; insert a file name to create the PDF on disk */
    if ($p->begin_document("", "") == 0) {
	die("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "businesscard.php");
    $p->set_info("Author", "Thomas Merz");
    $p->set_info("Title", "PDFlib block processing sample (PHP)");

    $blockcontainer = $p->open_pdi_document($infile, "");
    if ($blockcontainer == 0){
	die ("Error: " . $p->get_errmsg());
    }

    $page = $p->open_pdi_page($blockcontainer, 1, "");
    if ($page == 0){
	die ("Error: " . $p->get_errmsg());
    }

    $p->begin_page_ext(20, 20, "");		/* dummy page size */

    /* This will adjust the page size to the block container's size. */
    $p->fit_pdi_page($page, 0, 0, "adjustpage");

    /* Fill all text blocks with dynamic data */
    foreach ($data as $key => $value){
	if ($p->fill_textblock($page, $key, $value,
	    "embedding encoding=unicode") == 0) {
	    printf("Warning: %s\n ", $p->get_errmsg());
	}
    }

    $p->end_page_ext("");
    $p->close_pdi_page($page);

    $p->end_document("");
    $p->close_pdi_document($blockcontainer);

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=businesscard.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in businesscard sample:\n" .
	"[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
	$e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
