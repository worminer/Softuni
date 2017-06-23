<form action="" method="GET">
  <input type="text" name="name"  /><br>
  <input type="text" name="age"   /> <br>
  <input type="radio" name="gender" value="male"> Male<br>
  <input type="radio" name="gender" value="female" > Female<br>
  <button type="submit">Submit</button><br>
</form>

<?php
$name = '';
$gender = '';
$age = '';

if (isset($_GET['name'])) {
  $name = $_GET['name'];
}

if (isset($_GET['age'])) {
  $age = $_GET['age'];
}

if (isset($_GET['gender'])) {
  $gender = $_GET['gender'];
}
if (!empty($name) && !empty($age) && !empty($gender)) {
  echo "My name is {$name}. I am {$age} years old. I am {$gender}";
}

?>




