<?php
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    $login = $_SESSION['login'];
     try{
    $req = $bdd->prepare("SELECT * FROM post ORDER BY posix DESc");

    $req->execute(array($login));
      
	$image_set = $req->fetchAll();
	 }
	catch (PDOexception $e){
		print "Erreur : ".$e->getMessage()."";
		die();
	}
    $i = 0;
    while ($image_set[$i])
    {
        $encode_image = $image_set[$i]['image'];
        echo '<div class="post">';
        echo '<div class="montage">';
        echo '<img src="./photos/'.$encode_image.'">';
        echo '</div>';
        echo '<div class="post-container">';
        echo '<div class="marks">';
        echo '<div class="num">'.$image_set[$i]['nb_likes'].'</div><img id="like" src="img/like.png">';
        echo '<div class="num">'.$image_set[$i]['nb_com'].'</div><img id="com" src="img/flag.png">';        
        echo '</div>';
        echo '<a class="interact" href="comment_like.php?id_post='.$image_set[$i]['id'].'">interact</a>';
        echo '<div class="date">'.$image_set[$i]['date_post'].' </div>';
        echo '<br>';
        echo '<center><div class="info">Posted by : '.$image_set[$i]['login'].' </div></center>';        
        echo '</div>';
        echo '</div>';
        $i++;
    }
?>
