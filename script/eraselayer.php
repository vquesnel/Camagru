<?php
session_start();
$_SESSION['layer'] = "";
$_SESSION['calque'] = "";
$_SESSION['x_origin'] = 10;
$_SESSION['y_origin'] = 10;
echo '<script language="javascript">document.location.href="../post.php"</script>';
?>