<?php
$layer_set = array('plane', 'maillot', 'bird', 'medal', 'cup', 'diamond', 'donut', 'eye', 'egg', 'game', 'gift', 'heart', 'flotter', 'champion', 'speaker', 'hat', 'spaceship', 'aces', 'flag-zdp', 'zdp', 'd6av');
$i = 0;
$layer = "none";
while ($layer_set[$i])
{
	if ($_GET[$layer_set[$i]] == "Select")
	{
		$i++;
		$layer = "../contents/".$i.".png";
		$_SESSION['layer'] = $layer;
		break;
	}
	$i++;
}

$calque_set = array('negative', 'grayscale', 'normal');
$i = 0;
$calque = "none";
while ($calque_set[$i])
{
	if ($_POST['calque'] === $calque_set[$i])
	{
		// $calque = ;
		$_SESSION['calque'] = $calque_set[$i];
		break;
	}
	$i++;
}

$moove_set = array('up', 'down', 'left', 'right');
$i = 0;
$moove = "none";
while ($moove_set[$i])
{
	if ($_POST['moove'] === $moove_set[$i])
	{
		$_SESSION['moove'] = $moove_set[$i];
		break;
	}
	$i++;
}
?>