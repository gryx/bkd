<?php
/* 
 * $Id: starter_flash.php,v 1.7.2.2 2013/06/20 13:22:20 stm Exp $
 *
 * Starter Flash: Embed Flash in PDF
 *
 * Required software: PDFlib/PDFlib+PDI/PPS 9
 * Required data: Flash data files
 *
 * The Flash source files "mini.mxml" and "minivid.mxml" for the the Flash
 * video player "minivid.swf" and the Flash test application "mini.swf"
 * are included in the "data" directory.
 */

/*
 * Utility function to create a button that calls an action on a rich-media
 * annotation.
 */
function create_richmedia_action_button($p, $font, $fontsize, $caption,
        $tooltip, $target_name, $functionname,
        $arg_handle, $xpos, $ypos, $width, $height)
{
    $optlist = "target={" . $target_name . "} functionname=" . $functionname;

    if ($arg_handle != 0)
    {
        $optlist .= " richmediaargs=" . $arg_handle;
    }

    $action = $p->create_action("RichMediaExecute", $optlist);

    $optlist = "caption={" . $caption . "} "
                    . "tooltip={" . $tooltip . "} "
                    . "action={up=" . $action . "} "
                    . "bordercolor={gray 0} "
                    . "font=" . $font . " fontsize=" . $fontsize;
    $p->create_field($xpos, $ypos, $xpos + $width, $ypos + $height,
            $caption, "pushbutton", $optlist);
}

/*
 * This is where the data files are. Adjust as necessary.
 */
$searchpath = dirname(dirname(__FILE__)).'/data';
$outfile = "";

try {
    $p = new pdflib();
    
    $pageheight = 600;
    $pagewidth = 700;
    $gap = $pageheight / 20;

    $fontsize = $pageheight / 30;
    $button_fontsize = ($fontsize * 2) / 3;

    /*
     * Layout for header
     */
    $textbox_width = $pagewidth - 2 * $gap;
    $textbox_height = $fontsize;
    $textbox_llx = $gap;
    $textbox_lly = $pageheight - $gap - $fontsize;

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    /*
     * This means we must check return values of load_font() etc.
     */
    $p->set_option("errorpolicy=return");

    /* all strings are expected as utf8 */
    $p->set_option("stringformat=utf8");

    if ($p->begin_document($outfile,
        "viewerpreferences={fitwindow=true} compatibility=1.7ext3") == 0) {
        throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_flash");

    $font = $p->load_font("Helvetica", "unicode", "");
    if ($font == 0) {
        throw new Exception("Error: " . $p->get_errmsg());
    }

    /*
     * Name of the flash video player application
     */
    $video_player_file = "minivid.swf";

    /*
     * Name of the video to play
     */
    $video_file = "flashvid.flv";

    /*
     * Layout for Flash area
     */
    $flash_width = $pagewidth - 2 * $gap;
    $flash_height = ($flash_width * 10) / 18;
    $flash_llx = $textbox_llx;
    $flash_lly = $textbox_lly - $gap - $flash_height;

    /*
     * Layout for pushbuttons
     */
    $num_buttons = 5;
    $button_gap = 20;
    $button_width =
        ($flash_width - ($num_buttons - 1) * $button_gap) / $num_buttons;
    $button_height = $button_width / 2;
    $button_llx = $flash_llx;
    $button_lly = $flash_lly - $gap - $button_height;

    $NUM_CUEPOINTS = 8;
    $CUEPOINT_FIELDNAME = "cuepoint";
    
    $textfield_gap = $button_gap;
    $textfield_llx = $flash_llx;
    $textfield_height = $button_height / 2;
    $textfield_lly = $button_lly - $gap - $textfield_height;
    $textfield_width =
        ($flash_width - ($NUM_CUEPOINTS - 1) * $textfield_gap) / $NUM_CUEPOINTS;
    $textfield_fontsize = ($button_fontsize * 3) / 4;

    $cuepoint_actions = array();
    $cuepoint_timestamps = 
        array(
            /*
             * The cue point timestamps do not have any functionality,
             * but are displayed in Acrobat in the properties of the
             * Flash video, therefore they should be accurate.
             */
            660, 1133, 1700, 2266, 2933, 3500, 3933, 4566
        );

    /*
     * Start a page
     */
    $p->begin_page_ext($pagewidth, $pageheight, "");

    /*
     * Header line
     */
    $optlist = "position={center bottom} font=" . $font
            . " fontsize=" . $fontsize . " boxsize={" . $textbox_width
            . " " . $textbox_height . "}";
    
    $PLAYER_TITLE =
            "Video player with PDF button controls and cue point feedback";
    $p->fit_textline($PLAYER_TITLE, $textbox_llx, $textbox_lly, $optlist);
    $p->create_bookmark($PLAYER_TITLE, "");

    /*
     * Load the video display flash application
     */
    $video_player = $p->load_asset("Flash", $video_player_file, "");
    if ($video_player == 0) {
        throw new Exception("Error: " . $p->get_errmsg());
    }

    $video = $p->load_asset("Video", $video_file,"");
    if ($video == 0) {
        throw new Exception("Error: " . $p->get_errmsg());
    }

    /*
     * Create actions that are triggered by the cue points from the
     * Video. They change the visual appearance of the text fields at
     * the bottom of the page.
     */
    for ($i = 0; $i < $NUM_CUEPOINTS; $i += 1)
    {
        $javascript_buf =
            "script {"
                . "var f = this.getField(\"$CUEPOINT_FIELDNAME$i\"); "
                . "f.value = \"Cue point " . ($i + 1) . "\"; "
                . "f.fillColor = color.blue;"
            . "}";
        $cuepoint_actions[] = $p->create_action("JavaScript", $javascript_buf);
    }

    /*
     * Build the option list for creating the richmedia annotation. The
     * name for the video player and video assets can be freely choosen,
     * but must be consistent between the "assets" declarations and
     * the "instances" declarations.
     *
     * The cue points must be matchable by name to the actual cue points
     * in the Video. The "time" options do not have any effect, but it
     * is recommended to add them with proper values as Acrobat
     * displays them in the properties dialog of the video.
     */
    $VIDEO_PLAYER_ASSET_NAME = "minivid.swf";
    $VIDEO_ASSET_NAME = "flashvid.flv";
    $VIDEO_PLAYER_NAME = "Video Player";
    $optlist =
        "name={" . $VIDEO_PLAYER_NAME . "} "
        . "richmedia={"
            . "activate={condition=opened} "
            . "assets={"
                . "{asset=" . $video_player . " name={" . $VIDEO_PLAYER_ASSET_NAME . "}} "
                . "{asset=" . $video . " name={" . $VIDEO_ASSET_NAME . "}} "
            . "} "
            . "configuration={"
            . "type=Video name=DefaultConfiguration "
                . "instances={"
                    . "{"
                        . "asset=" . $VIDEO_PLAYER_ASSET_NAME . " "
                        . "params={"
                            . "flashvars={"
                                . "source=" . $VIDEO_ASSET_NAME . "&"
                                 . "title=PDFlib%20Video%20Player"
                             . "} "
                             . "cuepoints={";
                             for ($i = 0; $i < $NUM_CUEPOINTS; $i += 1)
                             {
                                 $optlist .=
                                     "{"
                                         . "type=event "
                                         . "name={Cue-Point " . ($i + 1) . "} "
                                         . "time=" . $cuepoint_timestamps[$i] . " "
                                         . "action={activate={" . $cuepoint_actions[$i] . "}}"
                                     . "} ";
                             }
                             $optlist .=
                             "} "
                        . "}"
                    . "}"
                . "} "
            . "} "
        . "}";

    /*
     * Create the rich-media annotation
     */
    $p->create_annotation($flash_llx, $flash_lly,
            $flash_llx + $flash_width, $flash_lly + $flash_height,
            "RichMedia", $optlist);

    /*
     * Create action buttons to drive the player
     */
    $button_xpos = $button_llx;
    create_richmedia_action_button($p,
                    $font, $button_fontsize,
                    "Play", "Play the video",
                    $VIDEO_PLAYER_NAME, "play", 0,
                    $button_xpos, $button_lly,
                    $button_width, $button_height);

    $button_xpos += $button_gap + $button_width;
    create_richmedia_action_button($p,
                    $font, $button_fontsize,
                    "Pause", "Pause the video",
                    $VIDEO_PLAYER_NAME, "pause", 0,
                    $button_xpos, $button_lly,
                    $button_width, $button_height);

    /*
     * The rewind action is special because it not only executes a
     * RichMediaExecute action but also a JavaScript action to
     * reset the text fields for the cue point feedback.
     */
    $button_xpos += $button_gap + $button_width;
    $rm_action = $p->create_action("RichMediaExecute",
        "target={" . $VIDEO_PLAYER_NAME . "} functionname=rewind");
    $optlist = "script {"
        . "for (var i = 0; i < " . $NUM_CUEPOINTS . "; i += 1)"
            . "{"
                . "var f = this.getField(\"$CUEPOINT_FIELDNAME\" + i); "
                . "f.value = \"\"; "
                . "f.fillColor = color.transparent;"
            . "}"
        . "}";
    $js_action = $p->create_action("JavaScript", $optlist);
    $optlist =
        "caption={Rewind} "
            . "tooltip={Rewind the video} "
            . "action={up={" . $rm_action . " " . $js_action . "}} "
            . "bordercolor={gray 0} "
            . "font=" . $font
            . " fontsize=" . $button_fontsize;
    $p->create_field($button_xpos, $button_lly,
                $button_xpos + $button_width,
                $button_lly + $button_height,
                "Rewind", "pushbutton", $optlist);

    /*
     * Create an argument list containing one argument to set the
     * volume for the video player to 20%. Note that Acrobat expects
     * floating point numbers as PDF type string.
     */
    $vol20pct_args = $p->poca_new("containertype=array usage=richmediaargs");
    $p->poca_insert($vol20pct_args, "type=string index=0 value={0.2}");
    $button_xpos += $button_gap + $button_width;
    create_richmedia_action_button($p,
                    $font, $button_fontsize,
                    "Volume\n20%", "Set volume to 20%",
                    $VIDEO_PLAYER_NAME, "volume", $vol20pct_args,
                    $button_xpos, $button_lly,
                    $button_width, $button_height);

    /*
     * Create an argument list containing one argument to set the
     * volume for the video player to 100%.
     */
    $vol100pct_args = $p->poca_new("containertype=array usage=richmediaargs");
    $p->poca_insert($vol100pct_args, "type=string index=0 value={1.0}");
    $button_xpos += $button_gap + $button_width;
    create_richmedia_action_button($p,
                    $font, $button_fontsize,
                    "Volume\n100%", "Set volume to 100%",
                    $VIDEO_PLAYER_NAME, "volume", $vol100pct_args,
                    $button_xpos, $button_lly,
                    $button_width, $button_height);

    /*
     * Create textfields for giving feedback about the cue points that
     * are reached.
     */
    for ($i = 0, $textfield_xpos = $textfield_llx; $i < $NUM_CUEPOINTS;
            $i += 1, $textfield_xpos += $textfield_gap + $textfield_width)
    {
        $fieldname = $CUEPOINT_FIELDNAME . $i;

        $optlist = "readonly=true font=" . $font
                . " fontsize=" . $textfield_fontsize
                    . " fillcolor={gray 1} bordercolor={gray 0} "
                    . "alignment=center";

        $p->create_field($textfield_xpos, $textfield_lly,
                $textfield_xpos + $textfield_width,
                $textfield_lly + $textfield_height,
                $fieldname, "textfield", $optlist);
    }

    $p->end_page_ext("");

    $p->poca_delete($vol20pct_args, "");
    $p->poca_delete($vol100pct_args, "");
        
    /*
     * Name of the flash application
     */
    $flash_app_file = "mini.swf";

    /*
     * Layout for Flash area
     */
    $flash_width = 400;
    $flash_height = 300;
    $flash_llx = $pagewidth / 2 - $flash_width / 2;
    $flash_lly = $textbox_lly - $gap - $flash_height;

    /*
     * Layout for pushbuttons
     */
    $button_gap = 20;
    $button_width = $flash_width / 5;
    $button_height = $button_width * 2 / 3;
    $button_llx = $pagewidth / 2 - $button_gap / 2 - $button_width;
    $button_lly = $flash_lly - $gap - $button_height;

    /*
     * Start a page
     */
    $p->begin_page_ext($pagewidth, $pageheight, "");

    /*
     * Header line
     */
    $optlist = "position={center bottom} font=" . $font
            . " fontsize=" . $fontsize
            . " boxsize={" . $textbox_width . " " . $textbox_height . "}";
    $PLAYER_TITLE2 = "Passing parameters to functions in the Flash application";
    
    $p->fit_textline($PLAYER_TITLE2, $textbox_llx, $textbox_lly, $optlist);
    $p->create_bookmark($PLAYER_TITLE2, "");

    /*
     * Load the flash application
     */
    $flash_app = $p->load_asset("Flash", $flash_app_file, "");
    if ($flash_app == 0) {
        throw new Exception("Error: " . $p->get_errmsg());
    }

    /*
     * Build the option list for creating the richmedia annotation.
     */
    $FLASH_APP_NAME = "Flash Application";
    $optlist =
        "name={" . $FLASH_APP_NAME . "} " .
        "richmedia={" .
            "assets={" .
                "{asset=" . $flash_app . " name={" . $FLASH_APP_NAME . "}} " .
            "} " .
            "configuration={" .
                "type=Flash " .
                "instances={" .
                    "{" .
                        "asset={" . $FLASH_APP_NAME . "} " .
                        "params={" .
                            "binding=foreground " .
                            "flashvars={" .
                                "title=Click below for test" .
                                "&text=" .
                            "}" .
                        "}" .
                    "}" .
                "} " .
            "} " .
            "activate={ " .
                "condition=visible " .
            "} " .
        "}";

    /*
     * Create the rich-media annotation
     */
    $p->create_annotation($flash_llx, $flash_lly,
            $flash_llx + $flash_width, $flash_lly + $flash_height,
            "RichMedia", $optlist);

    /*
     * Create argument list for usage with varargs-style function.
     * This only works as expected with strings and booleans.
     */
    $flash_args = $p->poca_new("containertype=array usage=richmediaargs");
    $p->poca_insert($flash_args,
            "type=string index=0 value={Got varargs parameters}");
    $p->poca_insert($flash_args, "type=string index=1 value={text string}");
    $p->poca_insert($flash_args, "type=integer index=2 value={42}");
    $p->poca_insert($flash_args, "type=float index=3 value={3.14159}");
    $p->poca_insert($flash_args, "type=boolean index=4 value=true");
    $p->poca_insert($flash_args, "type=string index=5 value={another string}");

    $button_xpos = $button_llx;
    create_richmedia_action_button($p,
                    $font, $button_fontsize,
                    "Varargs",
                    "Pass arguments to Flash application via " .
                            "variable-length argument list",
                    $FLASH_APP_NAME, "myCallbackVarargs", $flash_args,
                    $button_xpos, $button_lly,
                    $button_width, $button_height);

    /*
     * Create argument list for a function with types for the
     * parameters. Note that numbers must be passed as strings.
     */
    $flash_args2 = $p->poca_new("containertype=array usage=richmediaargs");
    $p->poca_insert($flash_args2,
            "type=string index=0 value={Got typed parameters}");
    $p->poca_insert($flash_args2, "type=boolean index=1 value=false");
    $p->poca_insert($flash_args2, "type=string index=2 value={3.14159}");
    $p->poca_insert($flash_args2, "type=string index=3 value={42}");
    $p->poca_insert($flash_args2,
            "type=string index=4 value={typed string argument}");

    $button_xpos += $button_gap + $button_width;
    create_richmedia_action_button($p,
                    $font, $button_fontsize,
                    "Typed\narguments",
                    "Pass arguments to Flash application via " .
                    "typed argument list",
                    $FLASH_APP_NAME, "myCallbackTyped", $flash_args2,
                    $button_xpos, $button_lly,
                    $button_width, $button_height);

    $p->end_page_ext("");

    $p->poca_delete($flash_args, "");
    $p->poca_delete($flash_args2, "");

    /*
     * Prevent the prompt for saving the document, that is caused by
     * modifying the text fields for the cue points.
     */
    $undirty_action = $p->create_action("JavaScript",
                                        "script={ this.dirty = false; }");
    $optlist = "action={willclose=" . $undirty_action . "}";
    $p->end_document($optlist);

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_flash.pdf");
    print $buf;
}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_flash sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
