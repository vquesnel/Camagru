<?php
$bdd = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
if ($_POST['connect'] == "sign in")
{
	if (!empty($_POST['login2']) AND !empty($_POST['password2']))
	{
		$login2 = htmlentities($_POST['login2']);
		$mdp3 = sha1(htmlentities($_POST['password2']));
		try {
			$req_user = $bdd->prepare("SELECT * FROM users WHERE login= ? AND password = ? AND confirmation= 1");
			$req_user->execute(array($login2, $mdp3));
			$user_exist = $req_user->rowCount();
		}
		catch (PDOexception $e)
		{
			print "Erreur : ".$e->getMessage()."";
			die();
		}
		if ($user_exist == 1)
		{
			$user_info = $req_user->fetch();
			$_SESSION['id'] = $user_info['id'];
			$_SESSION['login'] = $user_info['login'];
			$_SESSION['email'] = $user_info['email'];
			$_SESSION['password'] = $mdp3;
			$_SESSION['x_origin'] = 100;
			$_SESSION['y_origin'] = 100;
			echo '<script language="javascript">
				document.location.href="post.php";
</script>';
		} else {$ret = "User not registred or wrong password";}
	} else {$ret = "Please complete all the areas";}
}
if (($_POST['inscription'] == "signup"))
{
	if (!empty($_POST['login']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['confirmpassword']))
	{
		$login = trim(htmlentities($_POST['login']));
		$email = trim(htmlentities($_POST['email']));
		try {
			$check_email = $bdd->prepare("SELECT * FROM users WHERE email= ?");
		$check_email->execute(array($email));
		$email_exist =$check_email->rowCount();
		$check_login = $bdd->prepare("SELECT * FROM users WHERE login= ?");
		$check_login->execute(array($login));
		$login_exist =$check_login->rowCount();
		}
		catch (PDOexception $e)
		{
	print "Erreur : ".$e->getMessage()."";
			die();
		}
		if ($login_exist == 0)
		{    
			if ($email_exist == 0)
			{	
				if (testpassword($_POST['password']))
				{
					$mdp = sha1(htmlentities($_POST['password']));
					$mdp2 = sha1(htmlentities($_POST['confirmpassword']));
					$token = sha1(uniqid());
					if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email))
					{
						if ($mdp == $mdp2)
						{
							try {
							$insert_user = $bdd->prepare("INSERT INTO users(login,confirmation, email, password, token) VALUES(?, 0, ?, ?, ?)");
							$insert_user->execute(array($login, $email, $mdp, $token));
							send_email($email, $login, $token);
							$ret = "Account created, check your email to confirm your account !";
							}
							catch (PDOexception $e) {
								print "Erreur : ".$e->getMessage()."";
								die();
							}
						} else {$ret = "Passwords doesn't match !";}
					} else {$ret = "Invalid Email format";}
				}	else {$ret = "Password is too weak !";}
			} else {$ret = "This email is already registred.";}
		} else {$ret = "This login is already used, please try another one.";}
	} else {$ret = "Please complete all the areas.";}
}

function send_email($mail, $login, $token)
{
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
		$passage_ligne = "\r\n";
	else
		$passage_ligne = "\n";
	$url = str_replace("index.php", "", $_SERVER['REQUEST_URI']);
	$message_txt = "Salut à tous, voici un e-mail envoyé par un script PHP.";
	$message_html = "<html><head></head><body><b>Bonjour ".$login.",</b><br/>Vous venez de vous inscrire sur le site web Camagru ! <br/>Pour valider votre compte cliquez sur le lien suivant: <br/> <a href='http://".$_SERVER['HTTP_HOST']."".$url."script/confirm_account.php?login=".$login."&token=".$token."'>Validation de votre compte</a></body></html>";
	$boundary = "-----=".md5(rand());
	$sujet = "Validation du compte Camagru";
	$header = "From: \"Camagru\"<camagru@42.fr>".$passage_ligne;
	$header.= "Reply-to: \"Camagru\" <camagru@42.fr>".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	$message = $passage_ligne."--".$boundary.$passage_ligne;
	$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_txt.$passage_ligne;
	$message.= $passage_ligne."--".$boundary.$passage_ligne;
	$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	mail($mail,$sujet,$message,$header);
}

function testpassword($mdp)	
{
$longueur = strlen($mdp);
if ($longueur >= 5) {
	for($i = 0; $i < $longueur; $i++) 	{
		$lettre = $mdp[$i];
		if ($lettre>='a' && $lettre<='z'){
			$point = $point + 1;
			$point_min = 1;
		}
		else if ($lettre>='A' && $lettre <='Z'){
			$point = $point + 2;
			$point_maj = 2;
		}
		else if ($lettre>='0' && $lettre<='9'){
			$point = $point + 3;
			$point_chiffre = 3;
		}
		else {
			$point = $point + 5;
			$point_caracteres = 5;
		}
	}
}
else 
	return (0);
$etape1 = $point / $longueur;
$etape2 = $point_min + $point_maj + $point_chiffre + $point_caracteres;
$resultat = $etape1 * $etape2;
$final = $resultat * $longueur;
if ($final >= 50)
	return (1);
else
	return (0);
}
?>
