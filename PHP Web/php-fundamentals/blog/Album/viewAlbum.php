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
<div id="Latest albums">
    <h2>View Album <?php $query1=mysql_query("SELECT id, albumName FROM albums");
			$album_id=$_GET['id'];
			$albumName=$query1['albumName'];
			echo "$albumName";?></h2>
    <div id="contain">
		<?php 
			$album_id=$_GET['id'];
			
			
			$query=mysql_query("SELECT id, name, tags, comments, url, rating FROM photos WHERE album_id='$album_id'");
			while($run=mysql_fetch_array($query)){
				$photo_name=$run['name'];
				$photo_tags=$run['tags'];
				$photo_comments=$run['comments'];
				$photo_url=$run['url'];
				$photo_rating=$run['rating'];
			?>
			<div id="albumViewer">
				<a href="preview.php?id=<?php echo $album_id;?>&url=<?php echo $photo_url;?>"><img src="photoUploads/<?php echo $photo_url; ?>"/></a>
				<br/>
				<b><?php echo $photo_name; ?></b>
			</div>
		<?php
			}
		?>
		<div class="clear"></div>
   </div>
</div>
</body>
</html>