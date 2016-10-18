<?php
session_start();
$dir = './photos/tmp';
$_SESSION = array();
if (is_dir($dir)) {
	$objects = scandir($dir);
	foreach ($objects as $object) {
		if ($object != "." && $object != "..") {
			if (filetype($dir."/".$object) == "dir") 
				rmdir($dir."/".$object); 
			else unlink($dir."/".$object);
		}
	}
	reset($objects);
}
session_destroy();
header("Location: index.php");
?>
