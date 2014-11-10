<?php
/* $Id: starter_pdfa2b.php,v 1.3 2013/01/25 12:11:10 rp Exp $
 *
 * PDF/A-2b starter:
 * Create PDF/A-2b conforming output with layers, transparency and
 * PDF/A attachments.
 *
 * Required software: PDFlib/PDFlib+PDI/PPS 9
 * Required data: font file, image file, ICC output intent profile
 *                (see www.pdflib.com for ICC profiles)
 */

/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';

$imagefile = "zebra.tif";
$attachments = array( "lionel.pdf", "nesrin.pdf" );

try {
    $p = new pdflib();

    /* This means we must check return values of load_font() etc. */
    $p->set_option("errorpolicy=return");

    /* all strings are expected as utf8 */
    $p->set_option("stringformat=utf8");

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    /* Initially display the layer panel and show the full page */
    if ($p->begin_document("",
                "openmode=layers viewerpreferences={fitwindow=true} " .
                "pdfa=PDF/A-2b") == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_pdfa2b");

    if ($p->load_iccprofile("ISOcoated.icc", "usage=outputintent") == 0) {
	print("Error: " . $p->get_errmsg() . "\n");
	print("Please install the ICC profile package from "
		. "www.pdflib.com to run the PDF/A-2b starter sample.\n");
	$p->delete();
	return(2);
    }

    /* Define the layers, with only English and image layers switched on. */
    $layer_english = $p->define_layer("English text", "");
    $layer_german = $p->define_layer("German text", "defaultstate=false");
    $layer_french = $p->define_layer("French text", "defaultstate=false");
    $layer_image = $p->define_layer("Images", "");

    /* Define a radio button relationship for the language layers, so only
     * one language can be switched on at a time.
     */
    $optlist = "group={" . $layer_english . " " . $layer_german
		. " " . $layer_french . "}";
    $p->set_layer_dependency("Radiobtn", $optlist);

    $p->begin_page_ext(595, 842, "");

    /* Font embedding is required for PDF/A */
    $font = $p->load_font("LuciduxSans-Oblique", "unicode", "embedding");

    if ($font == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    $optlist = sprintf("font=%d fontsize=24", $font);
    
    $p->begin_layer($layer_english);
    $textflow = $p->create_textflow(
                "PDF/A-2b starter sample with layers, transparency " .
                "and attachments", $optlist);
    $p->fit_textflow($textflow, 50, 650, 550, 700, "");
    $p->delete_textflow($textflow);

    $p->begin_layer($layer_german);
    $textflow = $p->create_textflow(
                "PDF/A-2b Starter-Beispiel mit Ebenen, Transparenz " .
                "und Anlagen", $optlist);
    $p->fit_textflow($textflow, 50, 650, 550, 700, "");
    $p->delete_textflow($textflow);

    $p->begin_layer($layer_french);
    $textflow = $p->create_textflow(
                "PDF/A-2b starter exemple avec des calques, " .
                "de la transparence et des annexes", $optlist);
    $p->fit_textflow($textflow, 50, 650, 550, 700, "");
    $p->delete_textflow($textflow);

    $p->begin_layer($layer_image);

    $p->setfont($font, 48);

    /* The RGB image needs an ICC profile; we use sRGB. */
    $icc = $p->load_iccprofile("sRGB", "");
    $optlist = "iccprofile=" . $icc;
    $image = $p->load_image("auto", $imagefile, $optlist);

    if ($image == 0) {
	throw new Exception("Error: " . $p->get_errmsg());
    }

    $width = $p->info_image($image, "width", "");
    $height = $p->info_image($image, "height", "");

    /* Place the image on the page and close it */
    $p->fit_image($image, 0.0, 0.0, "");
    $p->close_image($image);

    /* Set transparency in the graphics state */
    $gstate = $p->create_gstate("opacityfill=0.5");
    $p->set_gstate($gstate);

    /* Place a transparent diagonal stamp across the image area, in
     * different colors
     */
    $optlist = "boxsize={" . $width . " " . $height . "} stamp=ll2ur";
    
    $p->begin_layer($layer_english);
    $p->setcolor("fill", "Lab", 100, 28, 75, 0);
    $p->fit_textline("Transparent text", 0, 0, $optlist);

    $p->begin_layer($layer_german);
    $p->setcolor("fill", "Lab", 33.725, 5, -52, 0);
    $p->fit_textline("Transparenter Text", 0, 0, $optlist);

    $p->begin_layer($layer_french);
    $p->setcolor("fill", "Lab", 0, 0, 0, 0);
    $p->fit_textline("Texte transparent", 0, 0, $optlist);
    
    /* Close all layers */
    $p->end_layer();

    $p->end_page_ext("");

    /* Construct option list with attachment handles. The attachments must
     * be PDF/A-1 or PDF/A-2 files.
     */
    $optlist = "attachments={";
    foreach ($attachments as $attachment) {
        $attachment_handle =
                $p->load_asset("Attachment", $attachment,
                            "description={This is a PDF/A attachment}");

        if ($attachment_handle == 0) {
            throw new Exception("Error loading attachment: " . $p->get_errmsg());
        }

        $optlist .= " " . $attachment_handle;
    }
    $optlist .= "}";
    
    $p->end_document($optlist);

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_pdfa2b.pdf");
    print $buf;
}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_pdfa2b sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
