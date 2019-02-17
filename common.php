<?php
define("DISCO_DIR", "/home/pi/disco");
chdir(DISCO_DIR);

function _sanitize($string) {
    $sanitized = preg_replace("/[^a-z0-9\ .]+/i", "", $string);
    return $sanitized;
}

function get_playlists() {
	exec(DISCO_DIR . "/disco --playlist-search", $output, $return_var);
	return json_encode($output);
}

function add_playlist($name) {
    $name = _sanitize($name);
    exec(DISCO_DIR . "/disco --playlist-use \"" . $name . "\"", $output, $return_var);
	return $return_var != 255;
}

function set_mode($mode, $playlist=null) {
    $mode = _sanitize($mode);
    switch($mode) {
        case "Random":
        case "Jukebox":
        case "Mixed":
            exec(DISCO_DIR . "/disco --mode " . $mode, $output, $return_var);
            return $return_var != 255;
        case "Play-Mixed":
        case "Playlist":
            //TODO this isn't working yet - need to wait for Dad's help.
            if ($playlist != null) {
                exec(DISCO_DIR . "/disco --mode " . $mode . " --playlist \"" . $playlist . "\"", $output, $return_var);
                return $return_var != 255;
            }
            return false;
        default:
            return false;
    }
}

function get_current_mode() {
    exec(DISCO_DIR . "/disco --mode", $output, $return_var);
    // Pattern: "Current Mode: <mode>.  <list of other modes>"
    preg_match('/Current Mode\:\ (.*)\.\  .*/', $output[0], $matches);
    return json_encode($matches[1]);
}

// Could also implement:
// --playlist-add     Add artist/title No. to playlist
// --playlist-del     Delete artist/title No. from playlist

?>
