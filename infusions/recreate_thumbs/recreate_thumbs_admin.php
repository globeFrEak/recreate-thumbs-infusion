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
$result = dbquery("SELECT * FROM " . DB_PHOTOS . " LIMIT 1, 10");
$count_photos = dbrows($result);

opentable($locale['RCT_title'] . $locale['RCT_title_admin']);
// include admin locale
include_once LOCALE . LOCALESET . "admin/settings.php";

echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border rct-table'>\n<tr>\n";
echo "<td class='tbl2' style='text-align:center'><b>" . $locale['601'] . "</b><br /><span class='small2'>" . $locale['604'] . "</span></td>\n";
echo "<td class='tbl2' style='text-align:center'><b>" . $locale['602'] . "</b><br /><span class='small2'>" . $locale['604'] . "</td>\n";
echo "<td class='tbl2' style='text-align:center'><b>" . $locale['RCT_count'] . "</b></td>\n";
echo "</tr>\n<tr>\n";
echo "<td class='tbl1' style='text-align:center'>" . $settings['thumb_w'] . "x" . $settings['thumb_h'] . " <a href='" . ADMIN . "settings_photo.php$aidlink'>" . $locale['RCT_change'] . "</a></td>\n";
echo "<td class='tbl1' style='text-align:center'>" . $settings['photo_w'] . "x" . $settings['photo_h'] . " <a href='" . ADMIN . "settings_photo.php$aidlink'>" . $locale['RCT_change'] . "</a></td>\n";
echo "<td class='tbl1' style='text-align:center'>" . $count_photos . " <a href='#' onclick='CREATE()'>" . $locale['RCT_recreate_all'] . "</a></td>";
echo "\n</tr></table>\n";

$return_json = array();
while ($data = dbarray($result)) {
    $row_array['id'] = $data['photo_id'];
    $row_array['filename'] = $data['photo_filename'];
    $row_array['album_id'] = $data['album_id'];
    array_push($return_json, $row_array);
}
$json = json_encode($return_json);

add_to_head("<script type=\"text/javascript\">    
        var rct_json = " . $json . ";       
        var rct_sum_photos = " . $count_photos . ";
        var rct_count = 1;        
function CREATE_THUMBS(data){    
   $.ajax({
        url:'" . INFUSIONS . "recreate_thumbs/create.php',
        data: {id:data.id, filename:data.filename, album_id:data.album_id},
        datatype:'json',
        type: 'POST',
        success: function(data) { RESPONSE_THUMBS(data); }       
   });
} 
function RESPONSE_THUMBS(data) {
   var response = $.parseJSON(data);   
   var id = response.id;
   var file = response.file;
   var album = response.album;
   var thumb = response.thumb;
   var img = '<img src=\"" . PHOTOS . "' + album + '/' + thumb + '\" alt=\"' + file + '\">';
   var small = (response.small != null ? response.small : '');
   var mid = (response.mid != null ? response.mid : ''); 
   $('#photo_progress').empty();
   $('body').find('#photo_progress').first().prepend(rct_count + '/' + rct_sum_photos);
   $('body').find('#photo_created').first().prepend(album + '/' + file + '<br>' + rct_count +'/' + rct_sum_photos + '<br>' + small + mid + img +'<hr>');
   rct_count++;
}
function CREATE(){    
    $('#photo_progress').empty();
    $('#photo_created').empty();
    rct_count = 1;
    var answer = confirm ('" . $locale['RCT_recreate_all_answer'] . "');
    if (answer) {
        $('#photos_title').empty();
        $('body').find('#photo_progress').first().before('<h5 id=\"photos_title\">" . $locale['RCT_recreated'] . "</h5>');
        $.each(rct_json, function (i, value) {             
            CREATE_THUMBS(value);                      
        });        
    }
    
}
</script>");
echo "<div id='photo_progress' style='text-align:center;font-weight:bold;'></div>";
echo "<div id='photo_created'></div>";
closetable();

require_once THEMES . "templates/footer.php";
?>