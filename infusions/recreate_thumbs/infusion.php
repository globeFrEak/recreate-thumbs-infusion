<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
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
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

//include INFUSIONS."recreate_thumbs/infusion_db.php";

if (file_exists(INFUSIONS."recreate_thumbs/locale/".$settings['locale'].".php")) {	
	include INFUSIONS."recreate_thumbs/locale/".$settings['locale'].".php";
} else {	
	include INFUSIONS."recreate_thumbs/locale/English.php";
}

// Infusion general information
$inf_title = $locale['RCT_title_inf'];
$inf_description = $locale['RCT_desc'];
$inf_version = "1.0";
$inf_developer = "globeFrEak";
$inf_email = "globefreak@cwclan.de";
$inf_weburl = "http://www.cwclan.de";

$inf_folder = "recreate_thumbs";

$inf_adminpanel[1] = array(
	"title" => $locale['RCT_title'],
	"image" => "image.gif",
	"panel" => "recreate_thumbs_admin.php",
	"rights" => "RCT"
);
// Delete any items not required below.
/*
$inf_newtable[1] = DB_INFUSION_TABLE." (
field1 SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
field2 TINYINT(5) UNSIGNED DEFAULT '1' NOT NULL,
field3 VARCHAR(200) DEFAULT '' NOT NULL,
field4 VARCHAR(50) DEFAULT '' NOT NULL,
PRIMARY KEY (field1)
) TYPE=MyISAM;";

$inf_insertdbrow[1] = DB_INFUSION_TABLE." (field1, field2, field3, field4) VALUES('', '', '', '')";
$inf_droptable[1] = DB_INFUSION_TABLE;
$inf_altertable[1] = DB_INFUSION_TABLE." ADD etc";
$inf_deldbrow[1] = "other_table"; */
?>