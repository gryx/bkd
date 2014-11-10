<?php

/* $Id: starter_block.php,v 1.11 2013/01/25 10:36:36 rp Exp $
 *
 * Block starter:
 * Import a PDF page containing blocks and fill text and image
 * blocks with some data. For each addressee of the simulated
 * mailing a separate page with personalized information is
 * generated.
 * A real-world application would of course fill the blocks with data
 * retrieved from some external data source.
 *
 * Required software: PPS 9
 * Required data: input PDF, image
 */

/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';
$outfile = "";
$infile = "block_template.pdf";
$imagefile = "new.jpg";

/* Names of the person-related blocks contained on the imported page */
$addressblocks = array(
    "name", "street", "city"
);

/* number of address blocks */
$nblocks = count($addressblocks);

/* Data related to various persons used for personalization */
$persons = array(
    array("Mr Maurizio Moroni", "Strada Provinciale 124", "Reggio Emilia"),
    array("Ms Dominique Perrier", "25, rue Lauriston", "Paris"),
    array("Mr Liu Wong", "55 Grizzly Peak Rd.", "Butte")
);

$npersons = count($persons);

/* Static text simulates database-driven variable contents */
$intro = "Dear";
$goodbye = "Yours sincerely,\nVictor Kraxi";
$announcement =
    "Our <fillcolor=red>BEST PRICE OFFER<fillcolor=black> includes today:" .
    "\n\n" .
    "Long Distance Glider\nWith this paper rocket you can send all your " .
    "messages even when sitting in a hall or in the cinema pretty near " .
    "the back.\n\n" .
    "Giant Wing\nAn unbelievable sailplane! It is amazingly robust and " .
    "can even do aerobatics. But it is best suited to gliding.\n\n" .
    "Cone Head Rocket\nThis paper arrow can be thrown with big swing. " .
    "We launched it from the roof of a hotel. It stayed in the air a " .
    "long time and covered a considerable distance.\n\n" .
    "Super Dart\nThe super dart can fly giant loops with a radius of 4 " .
    "or 5 meters and cover very long distances. Its heavy cone point is " .
    "slightly bowed upwards to get the lift required for loops.\n\n" .
    "Visit us on our Web site at www.kraxi.com!";

try {
    $p = new pdflib();

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    /* This means we must check return values of load_font() etc. */
    $p->set_option("errorpolicy=return");

    /* all strings are expected as utf8 */
    $p->set_option("stringformat=utf8");


    if ($p->begin_document($outfile,
	    "destination={type=fitwindow} pagelayout=singlepage") == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_block");

    /* Open the Block template which contains PDFlib Blocks */
    $indoc = $p->open_pdi_document($infile, "");
    if ($indoc == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    /* Open the first page and clone the page size */
    $inpage = $p->open_pdi_page($indoc, 1, "cloneboxes");
    if ($inpage == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    $image = $p->load_image("auto", $imagefile, "");

    if ($image == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    /* Based on the imported page generate several pages with the blocks
     * being filled with data related to different persons
     */
    for ($i = 0; $i < $npersons; $i++)
    {
	/* Start the output page with a dummy size */
	$p->begin_page_ext(10, 10, "");

	/* Place the imported page on the output page, and clone all
	 * page boxes which are present in the input page; this will
	 * override the dummy size used in begin_page_ext().
	 */
	$p->fit_pdi_page($inpage, 0, 0, "cloneboxes");

	/* Option list for text blocks */
	$optlist = "encoding=unicode embedding";

	/* Loop over all person-related blocks. Fill the j-th block with the
	 * corresponding entry of the persons array.
	 */
	for ($j = 0; $j < $nblocks; $j++) {
	    if ($p->fill_textblock($inpage, $addressblocks[$j],
		    $persons[$i][$j], $optlist) == 0)
		printf("Warning: %s\n", $p->get_errmsg());
	}

	/* Fill the "intro" block */
	$buf = sprintf( "%s %s,", $intro, $persons[$i][0]);
	if ($p->fill_textblock($inpage, "intro", $buf, $optlist) == 0)
	    printf("Warning: %s\n", $p->get_errmsg());

	/* Fill the "announcement" block */
	if ($p->fill_textblock($inpage, "announcement", $announcement,
		$optlist) == 0)
	    printf("Warning: %s\n", $p->get_errmsg());

	/* Fill the "goodbye" block */
	if ($p->fill_textblock($inpage, "goodbye", $goodbye,
		$optlist) == 0)
	    printf("Warning: %s\n", $p->get_errmsg());

	/* Fill the image block */
	$optlist = "";
	if ($p->fill_imageblock($inpage, "icon", $image, $optlist) == 0)
	    printf("Warning: %s\n", $p->get_errmsg());

	$p->end_page_ext("");
    }

    $p->close_pdi_page($inpage);
    $p->close_pdi_document($indoc);
    $p->close_image($image);

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_block.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_block sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
