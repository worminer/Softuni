<?php

$host = "localhost"; // Host name
$username = "root"; // Mysql username
$password = ""; // Mysql password
$db_name = "forum_db"; // Database name
$tbl_name = "forum_question"; // Table name

// Connect to server and select databse.
$conn = mysqli_connect("$host", "$username", "$password")or die("cannot connect");
mysqli_select_db($conn, "$db_name")or die("cannot select DB");
$sql="SELECT * FROM $tbl_name ORDER BY id DESC";
// OREDER BY id DESC is order result by descending

$result=mysqli_query($conn, $sql);
?>

<table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
    <tr>
        <td width="6%" align="center" bgcolor="#E6E6E6"><strong>#</strong></td>
        <td width="53%" align="center" bgcolor="#E6E6E6"><strong>Topic</strong></td>
        <td width="15%" align="center" bgcolor="#E6E6E6"><strong>Views</strong></td>
        <td width="13%" align="center" bgcolor="#E6E6E6"><strong>Replies</strong></td>
        <td width="13%" align="center" bgcolor="#E6E6E6"><strong>Date/Time</strong></td>
    </tr>

    <?php

    // Start looping table row
    while ($rows = mysqli_fetch_array($result)) {
        ?>
        <tr>
            <td bgcolor="#FFFFFF"><? echo $rows['id']; ?></td>
            <td bgcolor="#FFFFFF"><a href="view_topic.php?id=<? echo $rows['id']; ?>"><? echo $rows['topic']; ?></a><BR>
            </td>
            <td align="center" bgcolor="#FFFFFF"><? echo $rows['view']; ?></td>
            <td align="center" bgcolor="#FFFFFF"><? echo $rows['reply']; ?></td>
            <td align="center" bgcolor="#FFFFFF"><? echo $rows['datetime']; ?></td>
        </tr>

        <?php
// Exit looping and close connection
    }
    mysqli_close($conn);
    ?>

    <tr>
        <td colspan="5" align="right" bgcolor="#E6E6E6"><a href="create_topic.php"><strong>Create New Topic</strong>
            </a></td>
    </tr>
</table>