<html>
<head>
    <title>Add your album</title>
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
    <h2>Create your album</h2>
    <form method="post">
        <?php
        if(isset($_POST["albumName"])){
            $albumName=$_POST["albumName"];
            $albumCategories=$_POST["albumCategory"];
            $albumTags=$_POST["albumTags"];
            if(empty($albumName) or empty($albumCategories) or empty($albumTags)){
                echo("Please fill all fields !<br/><br/>");
            }
            else{
                mysql_query("INSERT INTO albums VALUES ('','$albumName','$albumCategories','$albumTags','')");
                echo("You have successfully created a new album. Please click <a href=\"upload.php\">here</a> to add your photos.");
            }

        }
        ?>
        <label for="albumName">
            Enter album name:
        </label>
        <input type="text" name="albumName" placeholder="Enter album name..."/><br/>
        <label for="albumCategory">
            Choose album category:
        </label>
        <select name="albumCategory">
            <option>
                Family
            </option>
            <option>
                Sport
            </option>
            <option>
                Season
            </option>
            <option>
                Summer
            </option>
            <option>
                Winter
            </option>
        </select><br/>
        <label for="albumTags">
            Enter album tags:
        </label>
        <input type="text" name="albumTags" placeholder="Enter album tags.."/><br/>
        <input type="submit" value="Submit"/>
    </form>
</div> <?php include('./footer.inc.php'); ?>
</body>
</html>