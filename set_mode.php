<?php
include("common.php");

$mode = $_GET['mode'];
$playlist = $_GET['playlist'] || null;

print set_mode($mode, $playlist);