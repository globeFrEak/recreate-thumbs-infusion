<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
| Version: 1.1
| Author: globeFrEak (www.cwclan.de)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

if (file_exists(INFUSIONS."recreate_thumbs/locale/".$settings['locale'].".php")) {	
	include INFUSIONS."recreate_thumbs/locale/".$settings['locale'].".php";
} else {	
	include INFUSIONS."recreate_thumbs/locale/English.php";
}

// Infusion general information
$inf_title = $locale['RCT_title_inf'];
$inf_description = $locale['RCT_desc'];
$inf_version = "1.1";
$inf_developer = "globeFrEak";
$inf_email = "globefreak@cwclan.de";
$inf_weburl = "http://www.cwclan.de";

$inf_folder = "recreate_thumbs";

$inf_adminpanel[1] = array(
	"title" => $locale['RCT_title_inf'],
	"image" => "image.gif",
	"panel" => "recreate_thumbs_admin.php",
	"rights" => "RCT"
);
?>