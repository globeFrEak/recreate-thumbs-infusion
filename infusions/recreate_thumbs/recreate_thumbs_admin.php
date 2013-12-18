<?php

/* -------------------------------------------------------+
  | PHP-Fusion Content Management System
  | Copyright (C) 2002 - 2011 Nick Jones
  | http://www.php-fusion.co.uk/
  +--------------------------------------------------------+
  | Filename: recreate_thumbs_admin.php
  | Version: 1.00
  | Author: globeFrEak (www.cwclan.de)
  +--------------------------------------------------------+
  | This program is released as free software under the
  | Affero GPL license. You can redistribute it and/or
  | modify it under the terms of this license which you
  | can read by viewing the included agpl.txt or online
  | at www.gnu.org/licenses/agpl.html. Removal of this
  | copyright header is strictly prohibited without
  | written permission from the original author(s).
  +-------------------------------------------------------- */
require_once "../../maincore.php";
require_once THEMES . "templates/admin_header.php";

if (!checkrights("RCT") || !defined("iAUTH") || $_GET['aid'] != iAUTH) {
    redirect("../index.php");
}

if (file_exists(INFUSIONS . "recreate_thumbs/locale/" . $settings['locale'] . ".php")) {
    include INFUSIONS . "recreate_thumbs/locale/" . $settings['locale'] . ".php";
} else {
    include INFUSIONS . "recreate_thumbs/locale/English.php";
}
// get all photos
$result = dbquery("SELECT * FROM " . DB_PHOTOS . "");
$count_photos = dbrows($result);

opentable($locale['RCT_title'] . $locale['RCT_title_admin']);
// include admin locale
include_once LOCALE . LOCALESET . "admin/settings.php";

echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border rct-table'>\n<tr>\n";
echo "<td class='tbl2' style='text-align:center'><b>" . $locale['601'] . "</b><br /><span class='small2'>" . $locale['604'] . "</span></td>\n";
echo "<td class='tbl2' style='text-align:center'><b>" . $locale['602'] . "</b><br /><span class='small2'>" . $locale['604'] . "</td>\n";
echo "<td class='tbl2' style='text-align:center'><b>" . $locale['RCT_count'] . "</b></td>\n";
echo "</tr>\n<tr>\n";
echo "<td class='tbl1' style='text-align:center'>" . $settings['thumb_w'] . "x" . $settings['thumb_h'] . " <a href='" . ADMIN . "settings_photo.php$aidlink'>".$locale['RCT_change']."</a></td>\n";
echo "<td class='tbl1' style='text-align:center'>" . $settings['photo_w'] . "x" . $settings['photo_h'] . " <a href='" . ADMIN . "settings_photo.php$aidlink'>".$locale['RCT_change']."</a></td>\n";
echo "<td class='tbl1' style='text-align:center'>" . $count_photos . " <a href='" . FUSION_SELF . $aidlink . "&recreate=1'>".$locale['RCT_recreate_all']."</a></td>";
echo "\n</tr></table>\n";
closetable();

if (isset($_GET["recreate"]) && $_GET["recreate"] == 1) {
// recreate Thumbs 
    opentable($locale['RCT_title']);
    add_to_head("<script type=\"text/javascript\">
function CREATE_THUMBS(id, filename, album_id){    
   $.ajax({
        url:'" . INFUSIONS . "recreate_thumbs/create.php',
        data: {id:id,filename:filename,album_id:album_id},
        datatype:'json',
        type: 'POST',
        success: function(data) { RESPONSE_THUMBS(data); }
   });
} 
function RESPONSE_THUMBS(data) {   
   var response = $.parseJSON(data);
   var id = response.id;
   var file = response.file;
   var small = (response.small != null ? response.small : '');
   var mid = (response.mid != null ? response.mid : '');
   $('body').find('#photo_' + id).first().prepend(file + small + mid);   
}
</script>");
    
    $i = 1;
    while ($data = dbarray($result)) {
        echo $i . "/" . $count_photos . "<br>";
        echo "<script type=\"text/javascript\">CREATE_THUMBS(" . $i . ",'" . $data['photo_filename'] . "'," . $data['album_id'] . ");</script>";
        //echo "<button onclick='CREATE_THUMBS(" . $i . ",'" . $data['photo_filename'] . "'," . $data['album_id'] . ")'>START</button>";    
        echo "<div id='photo_" . $i . "'></div><hr>";
        $i++;
    }
    closetable();
}

require_once THEMES . "templates/footer.php";
?>