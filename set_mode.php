<?php
include("common.php");

$mode = $_GET['mode'];
if (isset($_GET['playlist'])) {
    $playlist = $_GET['playlist'];
} else {
    $playlist = null;
}

print set_mode($mode, $playlist);
