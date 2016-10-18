<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));

if ($_GET['id_post'])
{
	$_SESSION['id_post'] = $_GET['id_post'];
}

if ($_GET['envoyer']  == 'Envoyer')
{
	if (!empty($_GET['comment']))
	{
		$id_post = $_SESSION['id_post'];
		$login = $_SESSION['login'];
		$comment = htmlentities($_GET['comment']);
		try {
			$req_com = $bdd->prepare("INSERT INTO commentaires(id_post, login, value) VALUES(?, ?, ?)");
			$req_com->execute(array($id_post, $login, $comment));
			$find_user = $bdd->prepare("SELECT * FROM post WHERE id = ?");
			$find_user->execute(array($id_post));
			$post = $find_user->fetch();
			$login_to_find = $post['login'];
			$find_mail = $bdd->prepare("SELECT * FROM users WHERE login = ?");
			$find_mail->execute(array($login_to_find));
			$mail = $find_mail->fetch();
			if ($login != $login_to_find)
				send_email($mail['email'], $login, $login_to_find);
		}
		catch (PDOexception $e) {
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	} else {$ret = "Please enter a comment";}
}

if ($_GET['delete-com'])
{
	$com_id = $_GET['delete-com'];
	try {
		$req_del_com = $bdd->prepare("DELETE FROM commentaires WHERE id = ?");
		$req_del_com->execute(array($com_id));
	}
	catch (PDOexception $e) {
		print "Erreur : ".$e->getMessage()."";
		die();
	}
}

if ($_GET['like'] == "Like")
{
	$id_post = $_SESSION['id_post'];
	$login = $_SESSION['login'];
	try{
		$req_like = $bdd->prepare("SELECT * FROM like_dislike WHERE id_post = ? AND login = ?");
		$req_like->execute(array($id_post, $login));
		$verif = $req_like->rowCount();
	}
	catch (PDOexception $e) {
		print "Erreur : ".$e->getMessage()."";
		die();
	}
	if ($verif == 0)
	{
		$confirm = 1;
		try{
			$like = $bdd->prepare("INSERT INTO like_dislike(id_post, login, confirm) VALUES(?, ?, ?)");
			$like->execute(array($id_post, $login, $confirm));
		}
		catch (PDOexception $e) {
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}
	try {
		$req_nb_like = $bdd->prepare("SELECT * FROM like_dislike WHERE id_post = ?");
		$req_nb_like->execute(array($id_post));
		$like_set = $req_nb_like->fetchAll();
	}
	catch (PDOexception $e) {
		print "Erreur : ".$e->getMessage()."";
		die();
	}
	$j = 0;
	while ($like_set[$j])
	{
		$j++;
	}
	try {
		$update_nb_like = $bdd->prepare("UPDATE post SET nb_likes = ? WHERE id = ?");
		$update_nb_like->execute(array($j, $id_post));
	}
	catch (PDOexception $e) {
		print "Erreur : ".$e->getMessage()."";
		die();
	}
}

if ($_GET['like'] == "Unlike")
{
	$id_post = $_SESSION['id_post'];
	$login = $_SESSION['login'];
	try {
		$req_del_like = $bdd->prepare("DELETE FROM like_dislike WHERE id_post = ? AND login = ?");
		$req_del_like->execute(array($id_post, $login));
		$req_nb_like = $bdd->prepare("SELECT * FROM like_dislike WHERE id_post = ?");
		$req_nb_like->execute(array($id_post));
		$like_set = $req_nb_like->fetchAll();
	}
	catch (PDOexception $e) {
		print "Erreur : ".$e->getMessage()."";
		die();
	}
	$j = 0;
	while ($like_set[$j])
	{
		$j++;
	}
	try{
		$update_nb_like = $bdd->prepare("UPDATE post SET nb_likes = ? WHERE id = ?");
		$update_nb_like->execute(array($j, $id_post));
	}
	catch (PDOexception $e) {
		print "Erreur : ".$e->getMessage()."";
		die();
	}
}

if ($_GET['delete-post'] == "Delete post")
{
	try{
		$req_name = $bdd->prepare("SELECT * FROM post WHERE id = ?");
		$req_name->execute(array($_SESSION[id_post]));
		$post = $req_name->fetch();
		unlink('./photos/'.$post['image']);
		$req_delete_post = $bdd->prepare("DELETE FROM post WHERE id = ?");
		$req_delete_post->execute(array($_SESSION['id_post']));
		$req_delete_com = $bdd->prepare("DELETE FROM commentaires WHERE id_post = ?");
		$req_delete_com->execute(array($_SESSION['id_post']));
		$req_delete_like = $bdd->prepare("DELETE FROM like_dislike WHERE id_post = ?");
		$req_delete_like->execute(array($_SESSION['id_post']));
	}
	catch (PDOexception $e) {
		print "Erreur : ".$e->getMessage()."";
		die();
	}
}

if ($_SESSION['id_post'])
{
	try{
		$id_post = $_SESSION['id_post'];
		$req_image = $bdd->prepare("SELECT * FROM post WHERE id = ?");
		$req_com_set = $bdd->prepare("SELECT * FROM commentaires WHERE id_post = ?");
		$req_com_set->execute(array($id_post));
		$com_set = $req_com_set->fetchAll();
	}
	catch (PDOexception $e) {
		print "Erreur : ".$e->getMessage()."";
		die();
	}
	$i = 0;
	while ($com_set[$i])
	{
		$i++;
	}
	try {
		$update_nb_com = $bdd->prepare("UPDATE post SET nb_com  = ? WHERE id = ?");
		$update_nb_com->execute(array($i, $id_post));
		$req_image->execute(array($id_post));
		$style = "b1";
		$verif = $req_image->rowCount();
	}
	catch (PDOexception $e) {
		print "Erreur : ".$e->getMessage()."";
		die();
	}
	if ($verif == 1)
	{
		$post = $req_image->fetch();
		echo '<div class="post">';   
		echo '<img src="./photos/'.$post['image'].'">';   
		echo '<div class="post-container">';
		echo '<div class="marks">';
		echo '<div class="num">'.$post['nb_likes'].'</div><img src="img/like.png">';
		echo '<div class="num">'.$post['nb_com'].'</div><img src="img/flag.png">';
		echo '<div class="info">Posted by : '.$post['login'].' '.$post['date_post'].' </div>';
		echo '</div>';

		$i = 0;
		while ($com_set[$i])
		{
			if ($i % 2 == 1)
			{
				$style = "b2";
			}
			else {$style = "b1";}
				echo '<div class="commentaire" id="'.$style.'">';
			if ($com_set[$i]['login'] == $_SESSION['login'])
			{
				echo '<a class="delete-com"  href="comment_like.php?delete-com='.$com_set[$i]["id"].'"><img src="img/delete.png" id="delete-logo"></a>';
			}
			echo '<div class="login">'.$com_set[$i][login].'</div>';
			echo '<p>'.$com_set[$i]['value'].'</p>';

			echo '<br>';
			echo '</div>';
			$i++;
		}



		echo '<form method="get" action="" class="comment">';
		echo '<br>';
		echo '<textarea type="text" name="comment"></textarea>';
		echo '<br/>';
		echo '<input type="submit" name="envoyer" value="Envoyer" class="envoyer">';
		try {
			$req_liked = $bdd->prepare("SELECT * FROM like_dislike WHERE id_post = ? AND login = ?");
			$req_liked->execute(array($id_post, $_SESSION['login']));
			$already_liked = $req_liked->rowCount();
		}
		catch (PDOexception $e) {
			print "Erreur : ".$e->getMessage()."";
			die();
		}
		if ($already_liked == 0)
		{
			$value = "Like";
		} else {$value = "Unlike";}
			echo '<input type="submit" name="like" value="'.$value.'" class="envoyer">';
		if ($post['login'] == $_SESSION['login'])
		{
			echo '<input type="submit" name="delete-post" value="Delete post" class="delete-button" onMouseHover="buttonHover()"/>';
		}
		echo '<br><br>';
		echo '<a class="back" href="feed.php">Return</a>';
		echo '</form>';
		echo '</div>';
		echo '</div>';  
		echo '<div class="separator"></div>';

		echo '<div class="separator"></div>';

	} else {$ret = "This post was deleted, or dosen't exist"; 
	}
} else {$ret = "Error when trying to find this post";}
echo $ret;
if ($ret === "This post was deleted, or dosen't exist")
{
	echo '<br><br>';
	echo '<a href="my_gallery.php">Return</a>';
}
function send_email($mail, $login, $login_to_find)
{
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
		$passage_ligne = "\r\n";
	else
		$passage_ligne = "\n";
	$message_txt = "Salut à tous, voici un e-mail envoyé par un script PHP.";
	$message_html = "<html><head></head><body><b>Bonjour ".$login_to_find.",</b><br/>Un nouveau commentaire vient d'etre ecrit par ".$login." sur une de vos photos!</body></html>";
	$boundary = "-----=".md5(rand());
	$sujet = "Commentaire photo";
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


?>
