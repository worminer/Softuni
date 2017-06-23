
    <div id="contain2">

		<?php

			$query= mysql_query("SELECT id,albumName,albumCategories,albumTags,albumRating
			FROM albums");
			while($run=mysql_fetch_array($query)){
				$album_id=$run['id'];
				$album_name=$run['albumName'];
				$album_category=$run['albumCategories'];
				$album_tags=$run['albumTags'];
				$album_rating=$run['albumRating'];
				
					$query1= mysql_query("SELECT url FROM photos WHERE album_id='$album_id'");
					$run1= mysql_fetch_array($query1);
					$pic=$run1['url'];
		?>
				
		<a href="viewAlbum.php?id=<?php echo $album_id;?>">
			<div id="albumViewer">
				<img src="photoUploads/<?php echo $pic; ?>";
				<br/>
				<b><?php echo $album_name;?>
			</div>
		</a>
		<?php
			}
		?>
		<div class="clear"></div>
   </div>
</div>