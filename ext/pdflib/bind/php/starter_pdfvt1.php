<?php

# $Id: starter_pdfvt1.php,v 1.10 2013/03/06 11:26:04 stm Exp $
#
# Starter sample for PDF/VT-1
# Create a large number of invoices in a single PDF and make use of
# the following PDF/VT-1 features:
# - create a document part (DPart) hierarchy
# - assign PDF/VT scope attributes to images and imported PDF pages
# - add document part metadata (DPM) to the DPart root node and all page nodes
#
# Required software: PDFlib+PDI/PPS 9
# Required data: PDF background, fonts, several raster images

class articledata_s {
    function articledata_s($name, $price) {
        $this->name = $name;
        $this->price = $price;
    }
};

class addressdata_s {
    function addressdata_s($firstname, $lastname, $flat, $street, $city) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->flat = $flat;
        $this->street = $street;
        $this->city = $city;
    }
};

define('MAXRECORD', 100);

$stationeryfilename = "stationery_pdfx4p.pdf";
$salesrepfilename = "sales_rep%d.jpg";
$fontname = "DejaVuSerif";

# This is where font/image/PDF input files live. Adjust as necessary.
$searchpath = "../data";
$outfile = "";

$left = 55;
$right = 530;
$bottom = 822;

$fontsize = 12;
$leading = $fontsize + 2;

$closingtext =
    "Terms of payment: <save fillcolor={cmyk 0 1 1 0}>30 days net<restore>. " .
    "90 days warranty starting at the day of sale. " .
    "This warranty covers defects in workmanship only. " .
    "Kraxi Systems, Inc. will, at its option, repair or replace the " .
    "product under the warranty. This warranty is not transferable. " .
    "No returns or exchanges will be accepted for wet products.";

$articledata = array(
    new articledata_s("Super Kite", 20),
    new articledata_s("Turbo Flyer", 40),
    new articledata_s("Giga Trash", 180),
    new articledata_s("Bare Bone Kit", 50),
    new articledata_s("Nitty Gritty", 20),
    new articledata_s("Pretty Dark Flyer", 75),
    new articledata_s("Large Hadron Glider", 85),
    new articledata_s("Flying Bat", 25),
    new articledata_s("Simple Dimple", 40),
    new articledata_s("Mega Sail", 95),
    new articledata_s("Tiny Tin", 25),
    new articledata_s("Monster Duck", 275),
    new articledata_s("Free Gift", 0)
);

$addressdata = array(
    new addressdata_s("Edith", "Poulard", "Suite C", "Main Street",
	    "New York"),
    new addressdata_s("Max", "Huber", "", "Lipton Avenue",
	    "Albuquerque"),
    new addressdata_s("Herbert", "Pakard", "App. 29", "Easel",
	    "Duckberg"),
    new addressdata_s("Charles", "Fever", "Office 3", "Scenic Drive",
	    "Los Angeles"),
    new addressdata_s("D.", "Milliband", "", "Old Harbour", "Westland"),
    new addressdata_s("Lizzy", "Tin", "Workshop", "Ford", "Detroit"),
    new addressdata_s("Patrick", "Black", "Backside",
	    "Woolworth Street", "Clover")
);


$salesrepnames = array(
    "Charles Ragner",
    "Hugo Baldwin",
    "Katie Blomock",
    "Ernie Bastel",
    "Lucy Irwin",
    "Bob Montagnier",
    "Chuck Hope",
    "Pierre Richard"
);

$headers = array(
	"ITEM", "DESCRIPTION", "QUANTITY", "PRICE", "AMOUNT"
);

$alignments = array(
	"right", "left", "right", "right", "right"
);

$dpm=0;

# Simulate a datamatrix barcode */

define('MATRIXROWS', 32);
$MATRIXDATASIZE      = (4*MATRIXROWS);

function create_datamatrix($record)
{
    $datastring = "";

    for ($i=0; $i<MATRIXROWS; $i++)
    {
	$data[$i][0] = ((0xA3 + 1*$record + 17*$i) % 0xFF);
	$data[$i][1] = ((0xA2 + 3*$record + 11*$i) % 0xFF);
	$data[$i][2] = ((0xA0 + 5*$record +  7*$i) % 0xFF);
	$data[$i][3] = ((0x71 + 7*$record +  9*$i) % 0xFF);
    }
    for ($i=0; $i<MATRIXROWS; $i++)
    {
	$data[$i][0] |= 0x80;
	$data[$i][2] |= 0x80;
	if ($i%2) {
	    $data[$i][3] |= 0x01;
	} else {
	    $data[$i][3] &= 0xFE;
	}
    }
    for ($i=0; $i<4; $i++)
    {
	$data[MATRIXROWS/2-1][$i] = 0xFF;
	$data[MATRIXROWS-1][$i] = 0xFF;
    }

    # pack the datamatrix into a string
    for ($i=0; $i<MATRIXROWS; $i++) {
	foreach ($data[$i] as $d) {
	    $datastring = $datastring.pack("C", $d);
	}
    }
    return $datastring;
}

# create a new PDFlib object
try {
    $p = new PDFlib();

    # This means we must check return values of load_font() etc.
    $p->set_option("errorpolicy=return");

    # all strings are expected as utf8
    $p->set_option("stringformat=utf8");

    if ($p->begin_document($outfile,
	    "pdfx=PDF/X-4 pdfvt=PDF/VT-1 usestransparency=false " .
	    "nodenamelist={root recipient} recordlevel=1") == 0)
    {
	die("Error: " . $p->get_errmsg());
    }

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_pdfvt1");

    $fontoptions = "fontname=" . $fontname . " fontsize=" . $fontsize
    			. " embedding encoding=unicode";
    
    # Define output intent profile */
    if ($p->load_iccprofile("ISOcoated.icc", "usage=outputintent") == 0)
    {
	printf("Error: %s\n", $p->get_errmsg());
	die("Please install the ICC profile package from " .
	       "www.pdflib.com to run the PDF/VT-1 starter sample.\n");
    }

    # -----------------------------------
    # Load company stationery as background (used on first page
    # for each recipient)
    # -----------------------------------
    $stationery = $p->open_pdi_document($stationeryfilename, "");
    if ($stationery == 0) {
	die("Error: " . $p->get_errmsg());
    }

    $page = $p->open_pdi_page($stationery, 1,
	    "pdfvt={scope=global environment={Kraxi Systems}}");
    if ($page == 0) {
	die("Error: " . $p->get_errmsg());
    }

    # -----------------------------------
    # Preload images of all local sales reps (used on first page
    # for each recipient). To get encapsulated image XObjects,
    # the renderingintent option is used.
    # -----------------------------------
    for ($i=0; $i < count($salesrepnames); $i++)
    {
	$buf = sprintf($salesrepfilename, $i);
	$salesrepimage[$i] = $p->load_image("auto", $buf,
                                "pdfvt={scope=file} renderingintent=Perceptual");

	if ($salesrepimage[$i] == 0) {
	    die("Error: " . $p->get_errmsg());
	}
    }

    # -----------------------------------
    # Construct DPM metadata for the DPart root node
    # -----------------------------------
    $cip4_metadata = $p->poca_new("containertype=dict usage=dpm");
    $p->poca_insert($cip4_metadata,
	    "type=string key=CIP4_Conformance value=base");
    $p->poca_insert($cip4_metadata,
	    "type=string key=CIP4_Creator value=starter_pdfvt1");
    $p->poca_insert($cip4_metadata,
	    "type=string key=CIP4_JobID value={Kraxi Systems invoice}");
	    
    $optlist = sprintf("containertype=dict usage=dpm " .
                        "type=dict key=CIP4_Metadata value=%d", $cip4_metadata);
    $cip4_root = $p->poca_new($optlist);
	    
    $optlist = sprintf("containertype=dict usage=dpm " .
                        "type=dict key=CIP4_Root value=%d", $cip4_root);
    $dpm = $p->poca_new($optlist);

    # Create root node in the DPart hierarchy and add DPM metadata  */
    $optlist = sprintf("dpm=%d", $dpm);
    $p->begin_dpart($optlist);

    $p->poca_delete($dpm, "recursive=true");

    for ($record=0; $record < MAXRECORD; $record++)
    {
	$pagecount = 0;

	$firstname = $addressdata[get_random(count($addressdata))]->firstname;
	$lastname = $addressdata[get_random(count($addressdata))]->lastname;

	# -----------------------------------
	# Construct DPM metadata for the next DPart node (i.e. the page)
	# -----------------------------------
	$dpm            = $p->poca_new("containertype=dict usage=dpm");
	$cip4_root      = $p->poca_new("containertype=dict usage=dpm");
	$cip4_recipient = $p->poca_new("containertype=dict usage=dpm");
	$cip4_contact   = $p->poca_new("containertype=dict usage=dpm");
	$cip4_person    = $p->poca_new("containertype=dict usage=dpm");

	$optlist = sprintf("type=dict key=CIP4_Root value=%d", $cip4_root);
	$p->poca_insert($dpm, $optlist);

	$optlist = sprintf("type=dict key=CIP4_Recipient value=%d",
						       $cip4_recipient);
	$p->poca_insert($cip4_root, $optlist);

	$optlist = sprintf("type=string key=CIP4_UniqueID value={ID_%d}",
			    $record);
	$p->poca_insert($cip4_recipient, $optlist);

	$optlist = sprintf("type=dict key=CIP4_Contact value=%d", $cip4_contact);
	$p->poca_insert($cip4_recipient, $optlist);

	$optlist = sprintf("type=dict key=CIP4_Person value=%d", $cip4_person);
	$p->poca_insert($cip4_contact, $optlist);

	$optlist = sprintf("type=string key=CIP4_Firstname value={%s}",
			    $firstname);
	$p->poca_insert($cip4_person, $optlist);

	$optlist = sprintf("type=string key=CIP4_Lastname value={%s}",
			    $lastname);
	$p->poca_insert($cip4_person, $optlist);

	# Create a new node in the document part hierarchy and
	# add DPM metadata
	$optlist = sprintf("dpm=%d", $dpm);
	$p->begin_dpart($optlist);

	$p->poca_delete($dpm, "recursive=true");

        # -----------------------------------
        # Create and place table with article list
        # -----------------------------------
        # 
        # ---------- Header row
        $row = 1;
        $tbl = 0;
    
        for ($col=1; $col <= count($headers); $col++)
        {
            $optlist = sprintf(
                "fittextline={position={%s center} %s} margin=2",
                $alignments[$col-1], $fontoptions);
            $tbl = $p->add_table_cell($tbl, $col, $row, $headers[$col-1],
                                        $optlist);
        }
        $row++;
    
        # ---------- Data rows: one for each article
        $total = 0;
    
        # -----------------------------------
        # Print variable-length article list
        # -----------------------------------
        for ($i = 0, $item = 0; $i < count($articledata); $i++) {
            $quantity = get_random(9) + 1;
    
            if (get_random(2) % 2) {
                continue;
            }
    
            $col = 1;
    
            $item++;
            $sum = $articledata[$i]->price * $quantity;
            
            # column 1: ITEM
            $buf = sprintf("%d", $item);
            $optlist = sprintf(
                "fittextline={position={%s center} %s} colwidth=5%% margin=2",
                $alignments[$col-1], $fontoptions);
            $tbl = $p->add_table_cell($tbl, $col++, $row, $buf, $optlist);
    
            # column 2: DESCRIPTION
            $optlist = sprintf(
                "fittextline={position={%s center} %s} colwidth=50%% " .
                "margin=2",
                $alignments[$col-1], $fontoptions);
            $tbl = $p->add_table_cell($tbl, $col++, $row,
                    $articledata[$i]->name, $optlist);
    
            # column 3: QUANTITY
            $buf = sprintf("%d", $quantity);
            $optlist = sprintf(
                "fittextline={position={%s center} %s} margin=2",
                $alignments[$col-1], $fontoptions);
            $tbl = $p->add_table_cell($tbl, $col++, $row, $buf, $optlist);
    
            # column 4: PRICE
            $buf = sprintf("%.2f", $articledata[$i]->price);
            $optlist = sprintf(
                "fittextline={position={%s center} %s} margin=2",
                $alignments[$col-1], $fontoptions);
            $tbl = $p->add_table_cell($tbl, $col++, $row, $buf, $optlist);
    
            # column 5: AMOUNT
            $buf = sprintf("%.2f", $sum);
            $optlist = sprintf(
                "fittextline={position={%s center} %s} margin=2",
                $alignments[$col-1], $fontoptions);
            $tbl = $p->add_table_cell($tbl, $col++, $row, $buf, $optlist);
    
            $total += $sum;
            $row++;
        }
    
        # ---------- Print total in the rightmost column
        $buf = sprintf("%.2f", $total);
        $optlist = sprintf(
            "fittextline={position={%s center} %s} margin=2",
            $alignments[count($alignments) - 1], $fontoptions);
        $tbl = $p->add_table_cell($tbl, count($headers), $row++, $buf,
                                    $optlist);
    
    
        # ---------- Footer row with terms of payment
        $optlist = sprintf("%s alignment=justify leading=120%%", $fontoptions);
        $tf = $p->create_textflow($closingtext, $optlist);
    
        $optlist = sprintf(
                "rowheight=1 margin=2 margintop=%f textflow=%d colspan=%d",
                2*$fontsize, $tf, count($headers));
        $tbl = $p->add_table_cell($tbl, 1, $row++, "", $optlist);
    
    
        # ----- Place the table instance(s), creating pages as required
        do {
            $p->begin_page_ext(0, 0,
                    "topdown=true width=a4.width height=a4.height");
    
            if (++$pagecount == 1)
            {
                # -----------------------------------
                # Place company stationery as background on first page
                # for each recipient
                # -----------------------------------
                $p->fit_pdi_page($page, 0, 842, "");
    
                # -----------------------------------
                # Place name and image of local sales rep on first page
                # for each recipient
                # -----------------------------------
                $y = 177;
                $x = 455;
    
                $optlist = sprintf(
                        "fontname=%s encoding=winansi embedding fontsize=9",
                        $fontname);
                $p->fit_textline("Local sales rep:", $x, $y, $optlist);
                $p->fit_textline($salesrepnames[$record % count($salesrepnames)],
                        $x, $y+9, $optlist);
    
                $y = 280;
                $p->fit_image($salesrepimage[$record % count($salesrepnames)],
                	$x, $y,
                        "boxsize={90 90} fitmethod=meet");
    
    
                # -----------------------------------
                # Address of recipient
                # -----------------------------------
                $y = 170;
    
                $optlist = sprintf(
                    "fontname=%s encoding=winansi embedding fontsize=%f",
                    $fontname, $fontsize);
                $buf = sprintf("%s %s", $firstname, $lastname);
                $p->fit_textline($buf, $left, $y, $optlist);
    
                $y += $leading;
                $p->fit_textline(
                        $addressdata[get_random(count($addressdata))]->flat,
                        $left, $y, $optlist);
    
                $y += $leading;
                $buf = sprintf("%d %s",
                        get_random(999),
                        $addressdata[get_random(count($addressdata))]->street);
                $p->fit_textline($buf, $left, $y, $optlist);
    
                $y += $leading;
                $buf = sprintf("%05d %s",
                        get_random(99999),
                        $addressdata[get_random(count($addressdata))]->city);
                $p->fit_textline($buf, $left, $y, $optlist);
    
    
                # -----------------------------------
                # Individual barcode image for each recipient. To get
                # encapsulated image XObjects the renderingintent option
                #  is used.
                # -----------------------------------
                $datamatrix = create_datamatrix($record);
                $p->create_pvf("barcode", $datamatrix, "");
    
                $barcodeimage = $p->load_image("raw", "barcode",
                    "bpc=1 components=1 width=32 height=32 invert " .
                    "pdfvt={scope=singleuse} renderingintent=Saturation");
                if ($barcodeimage == 0) {
                    die("Error: " . $p->get_errmsg());
                }
    
                $p->fit_image($barcodeimage, 280.0, 200.0, "scale=1.5");
                $p->close_image($barcodeimage);
                $p->delete_pvf("barcode");
    
    
                # -----------------------------------
                # Print header and date
                # -----------------------------------
                date_default_timezone_set('Europe/Berlin');
                $y = 300;
                $buf = sprintf("INVOICE %d-%d", date("Y"), $record+1);
                $optlist = sprintf(
                    "fontname=%s encoding=winansi embedding fontsize=%d",
                    $fontname, $fontsize);
                $p->fit_textline($buf, $left, $y, $optlist);
    
                # set timezone to avoid PHP warnings
                $buf = date("F j,Y");
                $optlist = sprintf(
			"fontname=%s encoding=unicode fontsize=%d embedding " .
			"position {100 0}", $fontname, $fontsize);
                $p->fit_textline($buf, $right, $y, $optlist);
                
                $top = $y + 2*$leading;
            }
            else
            {
                $top = 50;
            }
    
            # Place the table on the page.
            # Shade every other row, except the footer row.
            $result = $p->fit_table($tbl,
                    $left, $bottom, $right, $top,
                    "header=1 " .
                    "fill={{area=rowodd fillcolor={gray 0.9}} " .
                        "{area=rowlast fillcolor={gray 1}}} " .
                    "rowheightdefault=auto colwidthdefault=auto");
    
            if ($result == "_error")
            {
                die("Error when placing table: " . $p->get_errmsg());
            }
    
            $p->end_page_ext("");
        } while ($result == "_boxfull");
    
        $p->delete_table($tbl, "");

	# Close node in the document part hierarchy */
	$p->end_dpart("");
    }

    $p->close_pdi_page($page);
    $p->close_pdi_document($stationery);

    for ($i=0; $i<count($salesrepimage); $i++)
    {
	$p->close_image($salesrepimage[$i]);
    }

    # Close root node in the document part hierarchy */
    $p->end_dpart("");

    $p->end_document("");
    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_pdfvt1.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_pdfvt1 sample:\n" .
	"[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
	$e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;

/**
 * Get a pseudo random number between 0 and n-1
 */
function get_random($n) {
    return rand(0, $n-1);
}

?>
