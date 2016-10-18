<?php
    session_start();
    $_SESSION['img_name'] = "";
	$_SESSION['layer'] = "";
	$_SESSION['calque'] = "";
	$_SESSION['moove'] = "";
	$_SESSION['x_origin'] = 100;
	$_SESSION['y_origin'] = 100;
	echo '<script language="javascript">document.location.href="../post.php";</script>';
?>
