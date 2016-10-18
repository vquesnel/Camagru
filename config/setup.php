<?PHP
$bdd = new PDO('mysql:host=localhost', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
try {
$req =$bdd->prepare("CREATE DATABASE IF NOT EXISTS camagru;");
$req->execute();
$users_table = $bdd->prepare("CREATE TABLE IF NOT EXISTS `camagru`.`users` ( `id` INT(5) NOT NULL AUTO_INCREMENT , `login` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , `confirmation` INT(1) NOT NULL DEFAULT '0', `token` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
$users_table->execute();
$post_table = $bdd->prepare("CREATE TABLE IF NOT EXISTS `camagru`.`post` ( `id` INT(5) NOT NULL AUTO_INCREMENT , `login` VARCHAR(255) NOT NULL , `image` VARCHAR(255) NOT NULL , `nb_likes` INT(4) NOT NULL DEFAULT '0' , `nb_com` INT(5) NOT NULL DEFAULT '0' , `date_post` VARCHAR(255 ) NOT NULL , `posix` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
$post_table->execute();
$comment_table = $bdd->prepare("CREATE TABLE IF NOT EXISTS `camagru`.`commentaires` ( `id` INT(5) NOT NULL AUTO_INCREMENT , `id_post` INT(5) NOT NULL , `login` VARCHAR(255) NOT NULL , `value` VARCHAR(255 ) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
$comment_table->execute();
$like_table = $bdd->prepare("CREATE TABLE IF NOT EXISTS `camagru`.`like_dislike` ( `id` INT(5) NOT NULL AUTO_INCREMENT , `id_post` INT(5) NOT NULL , `login` VARCHAR(255) NOT NULL , `confirm` INT(1) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
$like_table->execute();
}

catch (PDOException $e)
{
	print "Erreur :".$e->getMessage()."";
	die();
}
?>
