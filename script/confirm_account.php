<?php
$bdd = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
$login = (isset($_GET["login"])) ? htmlentities($_GET["login"]) : NULL;
$token = (isset($_GET["token"])) ? htmlentities($_GET["token"]) : NULL;
try
{
$req_user = $bdd->prepare("UPDATE users SET confirmation = 1 WHERE login = ? AND token = ?");
$req_user->execute(array($login, $token));
$req_user = $bdd->prepare("SELECT 1 FROM users WHERE login = ? AND token = ?");
$req_user->execute(array($login, $token));
if ($user_info = $req_user->fetch()) {
	$ret = "Your account has been validate!";
}
else
{
	$ret ="A mistake occure please try again, your account hasn't been validate";
}
$req_user = $bdd->prepare("UPDATE users SET token = 0 WHERE login = ?");
$req_user->execute(array($login));
echo $ret;
}
catch (PDOexception $e)
{
	print "Erreur : ".$e->getMessage()."";
	die();
}
?>
<script language="JavaScript">
setTimeout(function(){
document.location.href="../index.php";
}, 4000);
</script>

