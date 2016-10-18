<?PHP
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
$login = $_SESSION['login'];
$message = "Please select a file";
$img_name = basename($_SESSION['img_name']);
$date = date ('d/m/Y');
$posix = date ('d/m/Y H:i:s');
$extension = pathinfo($_SESSION['img_name'], PATHINFO_EXTENSION);
if ($extension == "png") {
	$destination = imagecreatefrompng($_SESSION['img_name']);
}
else 
$destination = imagecreatefromjpeg($_SESSION['img_name']);

if (!empty($_SESSION['calque']))
{
	if ($_SESSION['calque'] === "negative")
		imagefilter($destination, IMG_FILTER_NEGATE);
	else if ($_SESSION['calque'] === "grayscale")
		imagefilter($destination, IMG_FILTER_GRAYSCALE);
}
if(!empty($_SESSION['layer']))
{	
	$source = imagecreatefrompng($_SESSION['layer']);
	$largeur_source = imagesx($destination);
	$hauteur_source = imagesy($destination);
	$rendu = imagecreatetruecolor($largeur_source, $hauteur_source);
	$fond = imagecolorallocatealpha($rendu,  0, 128, 255, 0);
	imagefill($rendu, 0, 0, $fond);
	imagecopy($rendu, $destination, 0, 0, 0,0, $largeur_source, $hauteur_source);
	imagecopy($rendu, $source, $_SESSION['x_origin'], $_SESSION['y_origin'], 0,0, 200, 200);
	imagesavealpha($rendu, true);
	imagepng($rendu, $_SESSION['img_name']);
	unset($rendu);
}
else
{
	if ($extension == "png")
	{
		$nolayer = imagecreatefrompng($_SESSION['img_name']);
		if (!empty($_SESSION['calque']))
		{
			if ($_SESSION['calque'] === "negative")
				imagefilter($nolayer, IMG_FILTER_NEGATE);
			else if ($_SESSION['calque'] === "grayscale")
				imagefilter($nolayer, IMG_FILTER_GRAYSCALE);
		}
		imagepng($nolayer, $_SESSION['img_name']);
		unset($nolayer);	
	}
	else
	{
		$nolayer = imagecreatefromjpeg($_SESSION['img_name']);
		if (!empty($_SESSION['calque']))
		{
			if ($_SESSION['calque'] === "negative")
				imagefilter($nolayer, IMG_FILTER_NEGATE);
			else if ($_SESSION['calque'] === "grayscale")
				imagefilter($nolayer, IMG_FILTER_GRAYSCALE);
		}
		imagejpeg($nolayer, $_SESSION['img_name']);
		unset($nolayer);
	}
}

if (!empty($_SESSION['img_name']))
{
	if (rename($_SESSION['img_name'], "../photos/".$img_name))
	{
		try {
			$req = $bdd->prepare("INSERT INTO post(login, image, date_post, posix) VALUES(?, ?, ?, ?)");
		$req->execute(array($login, $img_name, $date, $posix));
		$_SESSION['img_name'] = "";
		$_SESSION['layer'] = "";
		$_SESSION['calque'] = "";
		$_SESSION['x_origin'] = 100;
		$_SESSION['y_origin'] = 100;
		echo '<script language="JavaScript">
			setTimeout(function(){
					document.location.href="../my_gallery.php";
					}, 40);
		</script>';
		}
		catch (PDOexception $e) {
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}
	else {
		$message = "Upload failed";
		echo '<script language="JavaScript">
			setTimeout(function(){
					document.location.href="../post.php";
					}, 40);
		</script>';
	}
}
else 
{
	$message = "Please select a file";
	echo '<script language="JavaScript">
		setTimeout(function(){
				document.location.href="../post.php";
				}, 40);
	</script>';
}
?>
