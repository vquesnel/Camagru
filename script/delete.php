<?php
include 'security.php';
if ($_GET['confirmed'] == "confirmation")
{
	if ($_GET['confirm-email'] == $_SESSION['email'])
	{
		$password = sha1(htmlentities($_GET['password']));
		$email = htmlentities($_GET['confirm-email']);

		$bdd = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		try {
			$check_pw = $bdd->prepare("SELECT password FROM users WHERE login = ?");
			$check_pw->execute(array($_SESSION['login']));
			$verif = $check_pw->fetch();
		}
		catch (PDOexception $e) {
			print "Erreur : ".$e->getMessage()."";
			die();
		}
		if ($verif['password'] === $password) {
			try {
				$req_delete_account = $bdd->prepare("DELETE FROM users WHERE login = ?");
				$req_delete_account->execute(array($_SESSION['login']));

				$req_delete_post = $bdd->prepare("DELETE FROM post WHERE login = ?");
				$req_delete_post->execute(array($_SESSION['login']));

				$req_delete_like = $bdd->prepare("DELETE FROM like_dislike  WHERE login = ?");
				$req_delete_like->execute(array($_SESSION['login']));

				$req_delete_com = $bdd->prepare("DELETE FROM commentaires WHERE login = ?");
				$req_delete_com->execute(array($_SESSION['login']));

				$ret =  '<div class="deleted">Account deleted</div>';
			}
			catch (PDOexception $e) {
				print "Erreur : ".$e->getMessage()."";
				die();
			}
		} else {$ret = '<div class="not-deleted">You made a mistake with your password try again.</div>';}
	} else {$ret = '<div class="not-deleted">The email you enter is not matching with the one registred to your account.<br>
	If you don\'t remeber it you can find it on your account\'s page, just by clicking on change email</div>';} 
}

?>

	<html>
	<head>
		<link href="../stylesheets/menu.css" rel="stylesheet">
		<link href	="../stylesheets/delete.css" rel="stylesheet">
		<link rel="icon" type="image/png" href="../img/homelogo.png"/>
	</head>
	<body>
		<div class="separator"></div>
		<center>
			<img src="../img/homelogo.png" alt="camagru's-logo" width="300px">
			<h6>Please type your mail to confirm your request :</h6>
		<form method="get" action="">
		<div class="item">Email</div>
			<input style="text-align:center;" type="email" name="confirm-email" class="input" />
		<div class="item">Password</div>
		<input style="text-align:center;" class="input" type="password" name="password" />
		<br>
		<br>
		<input type="submit" name="confirmed" value="confirmation" class="button"/>
		</form>
<?php
echo $ret;
if (strlen($ret) === 42)
{
	echo '<div class="come-back">It was a pleasure to have you aside us, come back when you wanted to. <br>Best regards, Camagru\'s team.</div>';
	echo '<script language="javascript">
		setTimeout(function(){
			document.location.href="../logout.php";
}, 3000);
							</script>';
				}
			?>
		<div class="separator"></div>
		<a class="back" href="../account.php" class="back">Back</a>
			<div class="separator"></div>
		</center>
	</body>

	</html>
