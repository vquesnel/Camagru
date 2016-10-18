<?php
    include 'script/password-email.php';
?>
    <html>

    <head>
        <meta charset="utf8">
        <link href="stylesheets/sign_in.css" rel="stylesheet">
        <link href="stylesheets/menu.css" rel="stylesheet">
        <link href="stylesheets/reset_password.css" rel="stylesheet">
		<link rel="icon" type="image/png" href="img/homelogo.png"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Reset Password</title>
    </head>

    <body>

        <div class="site-content">
            <div class="site-cache" id="site-cache">
                <div class="container" align="center">

                    <div class="form-content">
                        <img text-align="center" src="img/locked.png" alt="user_logo" class="img_form">
                        <div class="title" align="center">Modify password</div>
                        <form align="center" class="form" method="post" action="">
                            <div class="item">Login</div>
                            <input style="text-align:center;" class="input" type="text" name="login" />
                            <br>
                            <div class="item">Email</div>
                            <input style="text-align:center;" class="input" type="text" name="email" />
                            <div class="item">New password</div>
                            <input style="text-align:center;" class="input" type="password" name="newpassword" />
                            <br>
                            <div class="item">Confimation</div>
                            <input style="text-align:center;" class="input" type="password" name="confirmnewpassword" />
                            <br>
                            <div align="center">
                                <div>
                                    <input type="submit" name="button" value="Change Password" class="button" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="separator"></div>
                    <a class="back" href="account.php" class="back">Back</a>
                    <div class="separator"></div>
                    <?php
                        if (isset($ret))
                        {
                            echo $ret;
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>

    </html>
