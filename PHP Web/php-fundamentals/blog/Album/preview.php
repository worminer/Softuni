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
	<?php 
			$album_id=$_GET['id'];
			$photo_url=$_GET['url'];
			
			$query=mysql_query("SELECT id, name, tags, comments, rating FROM photos WHERE url='$photo_url'");
			while($run=mysql_fetch_array($query)){
				$photo_name=$run['name'];
				$photo_tags=$run['tags'];
				$photo_comments=$run['comments'];
				$photo_rating=$run['rating'];
				}
			?>
			<div id="photoViewer">
				<b><?php echo $photo_name; ?></b>	<br/>
				<img src="photoUploads/<?php echo $photo_url; ?>"/></a>
			</div>
			<div id="photoViewer">
			<div id="comments">
				<?php
			if(isset($_POST['comments'])){
			$username_post=$_POST['username'];
			$comment_post=$_POST['comment'];
			mysql_query("INSERT INTO comments VALUES('','$username_post','$comment_post','$photo_url')");
			if(empty($username_post) or empty($comment_post)){
				echo("Please fill all the fields");
			}
			else{
				$query2=mysql_query("SELECT username, comments FROM comments WHERE url='$photo_url'");
				while($run=mysql_fetch_array($query)){
				$username=$run['name'];
				$comment=$run['tags'];			
			}
			}
			}
			?>
			<form method="post">
			<label for="username">
				Username:
			</label>
				<input type="text" name="username" placeholder="Enter your user name..."/><br/>
				<textarea rows="4" cols="50" name="comment">
				</textarea><br/>
				<input type="submit" name="comments" value="Comment"/>
			</form>
			</div>
			</div>
		<?php
			
		?>
		<div class="clear"></div>
</div>
</body>
</html>