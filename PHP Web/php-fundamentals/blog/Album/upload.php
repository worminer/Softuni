<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php include('connect.php')?>
<div id="headerContainer">
    <div id="header">
        <?php
        include 'header.php';
        ?>
    </div>
</div>
<div id="contain">
    <h2>Upload photo to an album</h2>
<?php

if(isset($_POST['upload'])){
    $photo_name=$_POST['photoName'];
    $album_id=$_POST['albumName'];

    $file=$_FILES['file']['name'];
    $file_type=$_FILES['file']['type'];
    $file_size=$_FILES['file']['size'];
    $file_tmp=$_FILES['file']['tmp_name'];
    $random_name=rand();
	switch($file_type){
		case "image/jpg":
		$file_ext=".jpg";
		break;
		case "image/png":
		$file_ext=".png";
		break;
		case "image/jpeg":
		$file_ext=".jpeg";
		break;
		case "image/gif":
		$file_ext=".gif";
		break;
	}
    if(empty($photo_name) or empty($file)){
        echo ("Please fill all the fields ! <br/><br/>");
    } else if($file_type != "image/jpg" && $file_type != "image/png" && $file_type != "image/jpeg"&& $file_type != "image/gif" ) {
			echo ("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
	} else if($file_size>5242880){
		echo("This file is too big. Please upload files smaller than 5MB");
	}
	else {
        move_uploaded_file($file_tmp,'photoUploads/'.$random_name.$file_ext);
        if(!empty($_POST['tags'])){
		$photo_tags=$_POST['tags'];
		mysql_query("INSERT INTO photos VALUES('','$photo_name','$photo_tags','','$album_id','$random_name$file_ext','')");
		}else{
		mysql_query("INSERT INTO photos VALUES('','$photo_name','','','$album_id','$random_name$file_ext','')");
		}
        echo("Photo uploaded");
		}
}
?>

<form action="upload.php" enctype="multipart/form-data" method="post">
    <label for="photoName">
        Photo Name:
    </label>
    <input type="text" name="photoName" placeholder="Enter the name of your photo"/><br/><br/>
    <label for="albumName">
        Select album
    </label>
    <select name="albumName" id="albumName">
        <?php
        $query=mysql_query("SELECT id, albumName FROM albums");
        while($run=mysql_fetch_array($query)){
            $album_id=$run['id'];
            $album_name=$run['albumName'];
            echo("<option value=\"$album_id\">$album_name</option>");
        }
        ?>
    </select><br/><br/>
	<label for="tags">
		Enter Photo Tags
	</label>
	<input type='text' name='tags'/><br/><br/>
    <input type='file' name='file'/><br/><br/>
    <input type="submit" name="upload" value="Upload" />
</form>
<p>Upload only images not bigger than 5MB</p></div>  <?php include('./footer.inc.php'); ?>
</body>
</html>