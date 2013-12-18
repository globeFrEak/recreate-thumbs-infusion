<?php

/* -------------------------------------------------------+
  | PHP-Fusion Content Management System
  | Copyright (C) 2002 - 2011 Nick Jones
  | http://www.php-fusion.co.uk/
  +--------------------------------------------------------+
  | Filename: create.php
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
require_once INCLUDES . "photo_functions_include.php";

$id = (isset($_POST["id"]) && is_numeric($_POST["id"]) ? $_POST["id"] : "");
$filename = (isset($_POST["filename"])? $_POST["filename"]: "");
$album_id = (isset($_POST["album_id"]) && is_numeric($_POST["album_id"]) ? $_POST["album_id"] : "");

$file = "<h5>" . $filename . "</h5>";

$photo_name = strtolower(substr($filename, 0, strrpos($filename, ".")));
$photo_ext = strtolower(strrchr($filename, "."));
$photo_dest = PHOTOS . "album_" . $album_id . "/";
$photo_file = $filename;

$imagefile = @getimagesize($photo_dest . $photo_file);

$photo_thumb1 = $photo_name . "_t1" . $photo_ext;
//createthumbnail($imagefile[2], $photo_dest . $photo_file, $photo_dest . $photo_thumb1, $settings['thumb_w'], $settings['thumb_h']);  
$small = "create small Thumb<br>";
$photo_thumb2 = "";
if ($imagefile[0] > $settings['photo_w'] || $imagefile[1] > $settings['photo_h']) {
    $photo_thumb2 = $photo_name . "_t2" . $photo_ext;
    $mid = "create mid Thumb<br>";
    //createthumbnail($imagefile[2], $photo_dest . $photo_file, $photo_dest . $photo_thumb2, $settings['photo_w'], $settings['photo_h']);
}
//$query = "UPDATE " . DB_PHOTOS . " set photo_thumb1 = '" . $photo_thumb1 . "', photo_thumb2 = '" . $photo_thumb2 . "' WHERE photo_id = " . $data['photo_id'] . "";
//dbquery($query);

// response to AJAX
$response = array(
    "id" => $id,
    "file" => $file,
    "small" => $small,
    "mid" => $mid
    );

// json to AJAX
print_r(json_encode($response));
?>