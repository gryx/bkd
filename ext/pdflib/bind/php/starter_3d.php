<?php
/* $Id: starter_3d.php,v 1.12 2013/01/29 10:22:03 rp Exp $
 * 3D Starter:
 * Load a 3D model and create a 3D annotation from it.
 *
 * Define a 3D view and load some 3D data with the view defined. Then create
 * an annotation containing the loaded 3D data with the defined 3D view as the
 * initial view.
 *
 * Required software: PDFlib/PDFlib+PDI/PPS 9
 * Required data: PRC data file
 */

# This is where the data files are. Adjust if necessary.
$searchpath = dirname(dirname(__FILE__)).'/data';
$outfile = "";


try {
    $p = new PDFlib();
    /*
     * Set errorpoliy to return, this means we must check return
     * values of begin_document() etc.
     * Set the search path for 3D data files
     */
    $p->set_option("errorpolicy=return SearchPath={{" . $searchpath . "}}");


    # all strings are expected as utf8
    $p->set_option("stringformat=utf8");

    # Start the document
    if ($p->begin_document($outfile, "compatibility=1.7ext3") == 0) {
	die("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib Cookbook");
    $p->set_info("Title", "starter_3d");

    $p->begin_page_ext(0, 0, "width=a4.width height=a4.height");

    # Define a 3D view which shows the model from the top
    $optlist = "type=PRC name=FirstView background={fillcolor=Lavender} " .
		"camera2world={-1 0 0 0 1 0 0 0 -1 0.5 0 300}";
    if (($view = $p->create_3dview("First view", $optlist)) == 0) {
	die("Error: " . $p->get_errmsg());
    }

    # Load some 3D data with the view defined above
    $buf = "type=PRC views={$view}";
    if (($data = $p->load_3ddata("riemann.prc", $buf)) == 0) {
	die("Error: " . $p->get_errmsg());
    }

    # Create an annotation containing the loaded 3D data with the
    # defined 3D view as the initial view
    #
    $buf = "name=annot usercoordinates contents=PRC 3Ddata=$data 3Dactivate={enable=open} 3Dinitialview=$view";
    $p->create_annotation(116, 200, 447, 580, "3D", $buf);

    $p->end_page_ext("");

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_3d.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_3d sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
