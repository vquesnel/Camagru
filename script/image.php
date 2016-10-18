<?php
session_start();
header ("Content-type: image/png");

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
if (!empty($_SESSION['layer']))
{
	$source = imagecreatefrompng($_SESSION['layer']);
	$largeur_source = imagesx($destination);
	$hauteur_source = imagesy($destination);
	$rendu = imagecreatetruecolor($largeur_source, $hauteur_source);
	$fond = imagecolorallocatealpha($rendu,  0, 128, 255, 0);
	imagefill($rendu, 0, 0, $fond);
	imagecopy($rendu, $destination, 0, 0, 0,0, $largeur_source, $hauteur_source);
	if (!empty($_SESSION['moove']))
	{
		if ($_SESSION['moove'] === "up")
			$_SESSION['y_origin'] -= $hauteur_source / 5;
		else if ($_SESSION['moove'] === "down")
			$_SESSION['y_origin'] += $hauteur_source / 5;
		else if ($_SESSION['moove'] === "left")
			$_SESSION['x_origin'] -= $largeur_source / 5;
		else if ($_SESSION['moove'] === "right")
			$_SESSION['x_origin'] += $largeur_source / 5;
		$_SESSION['moove'] = "";
	}
	imagecopy($rendu, $source, 	$_SESSION['x_origin'] ,	$_SESSION['y_origin'], 0,0, 200, 200);
	imagesavealpha($rendu, true);
	imagepng($rendu);
	header('Location: ../post.php');
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
		imagepng($nolayer);

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
		imagejpeg($nolayer);

	}
}
?>