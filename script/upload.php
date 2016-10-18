<?PHP
session_start();
define('TARGET', './photos/tmp/');
$valid_ext =array('jpg', 'gif', 'png', 'jpeg');
$message = "Please select a file";

if (!is_dir('./photos'))
{
	if (!mkdir('./photos', 0755))
	{
		exit("Problem with the repertory");
	}
}
if (!is_dir(TARGET)) {
		if ( !mkdir(TARGET, 0755)){
			exit("Problem with the repertory");
		}
	}


if (!empty($_POST['test'])) {
	list($type, $data) = explode(';', $_POST['test']);
	list(, $type) = explode('/',$type);
	list(, $data) = explode(',', $data);
	if(in_array(strtolower($type), $valid_ext))
	{
		$data = base64_decode($data);
		$image_name = md5(uniqid()).'.'.$type;
		file_put_contents( './photos/tmp/' .$image_name, $data);
		$_SESSION['img_name'] = "../photos/tmp/".$image_name;
		$message= "Upload suceed";
	}
	else
		$message = "wrong extension";
}
?>
