<?php
include 'script/security.php';
session_start();
include 'script/upload.php';
include 'script/montage.php';
?>

    <html>

    <head>
        <meta charset="utf8">
        <meta name="viewport" content="width=device-width initial-scale=1.0" />
        <title>Camagru</title>
        <link href="stylesheets/menu.css" rel="stylesheet">
        <link href="stylesheets/account.css" rel="stylesheet">
        <link href="stylesheets/post.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
		<link rel="icon" type="image/png" href="img/homelogo.png"/>
    </head>

    <body>
        <div class="site-container">
            <div class="site-pusher">
                <header class="header">
                    <a href="#" class="header__icon" id="header__icon" onClick="hide()"></a>
                    <a href="feed.php" class="header__logo">
                        <img src="img/logo.png" alt="logo">
                    </a>
                    <nav class="menu">
                        <div class="a0" class="fix"></div>
                        <a href="feed.php" class="a2"><img class="logo-menu" src="img/feed.png" alt="feed"></a>
                        <a href="my_gallery.php" class="a1"><img class="logo-menu" src="img/mygallery.png" alt="man"></a>
                        <a href="post.php" class="a2"><img class="logo-menu" src="img/post.png" alt="eye"></a>
                        <a href="account.php" class="a1"><img class="logo-menu" src="img/account.png"></a>
						<a href="logout.php" class="a2"><img class="logo-menu" src="img/logout.png"></a>
 <?php echo '<p>'.$_SESSION['login'].'@camagru</p>'; ?>

                    </nav>
                </header>
                <div class="site-content">
                    <div class="site-cache" id="site-cache" onClick="hide()">
                        <div class="container" align="center" onClick="hide()">
                            <div class="separator"></div>

                            <div id="selector" class="selector">
                                <form method="get">
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/1.png"></div>
                                        <input type="submit" name="plane" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/2.png"></div>
                                        <input type="submit" name="maillot" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/3.png"></div>
                                        <input type="submit" name="bird" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/4.png"></div>
                                        <input type="submit" name="medal" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/5.png"></div>
                                        <input type="submit" name="cup" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/6.png"></div>
                                        <input type="submit" name="diamond" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/7.png"></div>
                                        <input type="submit" name="donut" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/8.png"></div>
                                        <input type="submit" name="eye" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/9.png"></div>
                                        <input type="submit" name="egg" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/10.png"></div>
                                        <input type="submit" name="game" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/11.png"></div>
                                        <input type="submit" name="gift" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/12.png"></div>
                                        <input type="submit" name="heart" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/13.png"></div>
                                        <input type="submit" name="flotter" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/14.png"></div>
                                        <input type="submit" name="champion" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/15.png"></div>
                                        <input type="submit" name="speaker" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/16.png"></div>
                                        <input type="submit" name="hat" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/17.png"></div>
                                        <input type="submit" name="spaceship" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/18.png"></div>
                                        <input type="submit" name="aces" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/19.png"></div>
                                        <input type="submit" name="flag-zdp" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/20.png"></div>
                                        <input type="submit" name="zdp" value="Select" />
                                    </div>
                                    <div class="pkg">
                                        <div class="collage-item"><img src="contents/21.png"></div>
                                        <input type="submit" name="d6av" value="Select" />
                                    </div>
                                </form>
                            </div>

                            <div class="hud">
                                <?php
												if (isset($_SESSION['img_name']) && $_SESSION['img_name'] !== "")
												{ 	
													echo '<img id="montage-done" height="525" width="700" style="display:block" src="./script/image.php">';
													echo '<video id="video" style="display:none"></video>';
													echo'<canvas id="canvas" style="display:none"></canvas>';
												}
												else 
												{
													echo '<img id="montage-done" style="display:none" src="">';
													echo '<video id="video" style="display:block"></video>';
													echo'<canvas id="canvas" style="display:none"></canvas>';
												}
											?>
                                    <img id="photo" height="525" width="700" style="display:none" src="">
                                    <div class="menu-cam">
                                        <a id="startbutton"><img src="img/cam.png" alt="camera" class="img-logo" onClick="buttonStart()"></a>
                                        <a id="deletebutton" href="script/clear.php"><img src="img/erase.png" alt="camera" class="img-logo"></a>
                                        <a id="finish"><img src="img/montage.png" class="img-logo" onCLick="save()"></a>
                                        <a id="cancelmontage" href="script/eraselayer.php"><img src="img/reload.png" alt="camera" class="img-logo"></a>
                                        <a id="montage" href="script/upload_db.php"><img src="img/check.png" alt="camera" class="img-logo"></a>

                                    </div>
                                    <?php
                                    if (isset($_SESSION['img_name']) && $_SESSION['img_name'] !== "")
                                    {
										echo '<style>';
                                        echo '#selector {';
                                        echo 'height: 900px;}';
                                        echo '@media only screen and (max-width: 975px) {';
                                        echo '#selector {height: 200px;}';
                                        echo '}';
                                        echo '</style>';
                                        echo '<div class="montage-option">';
                                        echo '<form method="post" action="post.php">';
                                        echo '<button name="calque" value="negative"><img src="img/negative.png" class="img-logo"></button>';
                                        echo '<button name="calque" value="grayscale"><img src="img/grayscale.png" class="img-logo"></button>';
                                        echo '<button name="calque" value="normal"><img src="img/none.png" class="img-logo"></button>';
                                        echo '<button name="moove" value="left"><img src="img/left.png" class="img-logo"></button>';
                                        echo '<button name="moove" value="up"><img src="img/up.png" class="img-logo"></button>';
                                        echo '<button name="moove" value="down"><img src="img/down.png" class="img-logo"></button>';
										echo '<button name="moove" value="right"><img src="img/right.png" class="img-logo"></button>';
                                        echo '</form>';
                                        echo '</div>';
                                    }
                                    else 
                                    {
                                        echo '<style>';
                                        echo '#selector {';
                                        echo 'height: 830px;}';
                                        echo '@media only screen and (max-width: 975px) {';
                                        echo '#selector {height: 200px;}';
                                        echo '}';
                                        echo '</style>';
                                    }
                                ?>
                                        <div class="upload">
                                            <h2>Upload an image</h2>
                                            <input id="file" type="file" onchange="previewFile()">
                                            <br>
                                            <form id="zdp" method="post" enctype="multipart/form-data" action="#" class="upload-form">
                                                <br>
                                                <input id="test" type="hidden" name="test" value=>
                                            </form>
                                            <?php
										echo $message;
									 ?>
                                        </div>
                            </div>

                            <div class="separator"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script language="javascript" src="js/camera.js"></script>
        <script language="javascript" src="js/tools.js"></script>

    </body>

    </html>
