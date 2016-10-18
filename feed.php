<?php
    include 'script/security.php';
?>

    <html>

    <head>
        <meta charset="utf8">
        <meta name="viewport" content="width=device-width initial-scale=1.0" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Camagru</title>
        <link href="stylesheets/menu.css" rel="stylesheet">
        <link href="stylesheets/footer.css" rel="stylesheet">
        <link href="stylesheets/feed2.css" rel="stylesheet">
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
                        <a href="feed.php" class="a2"><img class="logo-menu" src="img/feed.png" alt="feed" </a>
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
                            <div class="feed">

                                <?php
                                    include 'script/display_feed.php';
                                ?>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="separator"></div>
        <script language="javascript" src="js/tools.js"></script>
    </body>

    </html>
