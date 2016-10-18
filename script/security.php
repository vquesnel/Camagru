<?php
    session_start();
    if (!$_SESSION['login'] || !$_SESSION['password'])
    {
        header("Location: index.php");
    }
?>
