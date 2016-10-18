<?php
    session_start();
    $polite = "Hello ".$_SESSION['login'];
    $sure =  "You are going to delete your account.<br>This action will be permanent and will erase all the data you saved on Camagru, are you sure you want to delete your account ? <b>If yes please click under the link below";

?>

<html>
    <head>
        <link href="stylesheets/delete.css" rel="stylesheet">
        <link href="stylesheets/menu.css" rel="stylesheet"> 
		<link rel="icon" type="image/png" href="img/homelogo.png"/>
        <meta charset="utf-8">
    </head>
    <body>
        <div class="separator"></div>
        <center>
        <div class="all">
        <?php 
            echo '<h1>'.$polite.'</h1>';
            echo '<h4>'.$sure.'</h4>';
            echo "<br>";
            echo '<a href="script/delete.php?login='.$_SESSION['login'].' class="salam-link"> Delete account</a>';       
        ?>
        </div>
            <img src="img/homelogo.png" alt="camagru-logo" width="300px">
			<div class="separator"></div>
            <a class="back" href="account.php" class="back">Back</a>
            <div class="separator"></div>
		</center>
    </body>
</html>
