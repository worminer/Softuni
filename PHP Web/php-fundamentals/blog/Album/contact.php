<html>

<head>

    <title>Contact</title>

    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

<body>

<?php include('connect.php')?>

<div id="headerContainer">
    <div id="Latest albums">
    <div id="header">

        <?php

        include 'header.php';

        ?>

    </div>

</div>

<body>
<div id="contain">
    <h2>Contact us</h2>

	
    <div id="maincontent">
        
      <p></p>
        <form id="feedback" method="post" action="">
            <p>
                <label for="name">Name:</label>
                <input name="name" id="name" type="text" class="formbox">
            </p>
            <p>
                <label for="email">Email:</label>
                <input name="email" id="email" type="text" class="formbox">
            </p>
            <p>
                <label for="comments">Comments:</label>
                <textarea name="comments" id="comments" cols="60" rows="8"></textarea>
            </p>
            <p>
                <input name="send" id="send" type="submit" value="Send message">
            </p>
        </form>
    </div>

</div>
</div>
    <?php include('./footer.inc.php'); ?>
</body>
</html>
