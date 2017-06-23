<html>
<head>
    <title>Upload Photos to an Album</title>
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
    <form action="uploadFile.php" enctype="multipart/form-data" method="post">
        <?php
            ini_set("post_max_size", "30M");
            ini_set("upload_max_filesize", "30M");
            ini_set("memory_limit", "20000M");
        if(isset($_POST['upload'])){
            $photo_name=$_POST['photoName'];
            $album_id=$_POST['album'];
            $file=$_FILES['photo']['name'];
            $file_type=$_FILES['photo']['type'];
            $file_size=$_FILES['photo']['size'];
            $file_tmp=$_FILES['photo']['tmp_name'];
            $random_name=rand();


            if(empty($photo_name) or empty($file)){
                echo ("Please fill all the fields ! <br/><br/>");
            } else {
                move_uploaded_file($file_tmp,'photoUploads/'.$random_name.'.jpg');
                mysql_query("INSERT INTO photos VALUES('','$photo_name','','','$album_id','$random_name.jpg','')");
                echo("Photo uploaded");

            }
        }
        ?>
        <label for="photoName">
            Photo Name:
        </label>
        <input type="text" name="photoName" placeholder="Enter the name of your photo"/><br/>
        <label for="album">
            Select album
        </label>
        <select name="album" id="album">
            <?php
            $query=mysql_query("SELECT id, albumName FROM albums");
            while($run=mysql_fetch_array($query)){
                $album_id=$run['id'];
                $album_name=$run['albumName'];
                echo("<option value=\"$album_id\">$album_name</option>");
            }
            ?>
        </select><br/>
        <input type="hidden" name="MAX_FILE_SIZE" value="3150000" />
        <input type='file' name='photo'/><br/>
        <input type="submit" name="upload" value="Upload" />
    </form>
  </div>
</body>
</html>