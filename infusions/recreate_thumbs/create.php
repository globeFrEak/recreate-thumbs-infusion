<?php

/* -------------------------------------------------------+
  | PHP-Fusion Content Management System
  | Copyright (C) 2002 - 2011 Nick Jones
  | http://www.php-fusion.co.uk/
  +--------------------------------------------------------+
  | Filename: create.php
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
  +-------------------------------------------------------- */
require_once "../../maincore.php";

if (!checkrights("RCT") || !defined("iAUTH") || $_GET['aid'] != iAUTH) {
    redirect("../../index.php");
}

if (isset($_POST["id"]) && isset($_POST["filename"]) && isset($_POST["album_id"])) {
    require_once INCLUDES . "photo_functions_include.php";

    $id = (is_numeric($_POST["id"]) ? $_POST["id"] : "");
    $filename = $_POST["filename"];
    $album_id = (is_numeric($_POST["album_id"]) ? $_POST["album_id"] : "");

    $photo_name = strtolower(substr($filename, 0, strrpos($filename, ".")));
    $photo_ext = strtolower(strrchr($filename, "."));
    $photo_dest = PHOTOS . "album_" . $album_id . "/";
    $photo_file = $filename;

    $imagefile = @getimagesize($photo_dest . $photo_file);

    $photo_thumb1 = $photo_name . "_t1" . $photo_ext;
    createthumbnail($imagefile[2], $photo_dest . $photo_file, $photo_dest . $photo_thumb1, $settings['thumb_w'], $settings['thumb_h']);
    $small = "create small Thumb<br>";
    $photo_thumb2 = "";
    $mid = "";
    if ($imagefile[0] > $settings['photo_w'] || $imagefile[1] > $settings['photo_h']) {
        $photo_thumb2 = $photo_name . "_t2" . $photo_ext;
        $mid = "create mid Thumb<br>";
        createthumbnail($imagefile[2], $photo_dest . $photo_file, $photo_dest . $photo_thumb2, $settings['photo_w'], $settings['photo_h']);
    }
    $query = "UPDATE " . DB_PHOTOS . " set photo_thumb1 = '" . $photo_thumb1 . "', photo_thumb2 = '" . $photo_thumb2 . "' WHERE photo_id = " . $id . "";
    dbquery($query);

// response to AJAX
    $response = array(
        "id" => $id,
        "file" => $filename,
        "thumb" => $photo_thumb1,
        "album" => "album_" . $album_id,
        "small" => $small,
        "mid" => $mid
    );
// json to AJAX
    print_r(json_encode($response));
} else {
    redirect("../../index.php");
}
?>