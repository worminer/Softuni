<?php
if (isset($_GET['names']) && isset($_GET['ages']) && isset($_GET['delimiter'])) {
  $delimiter = trim($_GET['delimiter']);
  $names = array_filter(array_map('trim', explode($delimiter, $_GET['names'])));
  $ages =  array_map('intval', array_filter(array_map('trim', explode($delimiter, $_GET['ages']))));
  if (strpos($_GET['names'], $_GET['delimiter']) !== false  &&
      strpos($_GET['ages'], $_GET['delimiter']) !== false &&
      sizeof($names) == sizeof($ages)) {
    $students = [];
    for ($i = 0; $i < sizeof($ages); $i++) {
      $student = (object)[];
      $student->name = $names[$i];
      $student->age = $ages[$i];
      array_push($students, $student);
    }
  }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Render Students</title>
    <style>
table, td, th {
  border: 1px solid black;
        }
    </style>
</head>
<body>
<form action="" method="get">
    <div>
        <label for="delimiter">Delimiter: </label>
        <select name="delimiter" id="delimiter">
            <option value=",">,</option>
            <option value="|">|</option>
            <option value="&amp;">&amp;</option>
        </select>
    </div>
    <div>
        <label for="names">Names: </label>
        <input type="text" id="names" name="names" required>
    </div>
    <div>
        <label for="ages">Ages: </label>
        <input type="text" id="ages" name="ages" required>
    </div>
    <div>
        <button>Filter!</button>
    </div>
</form>
<?php if (isset($students)) : ; ?>
  <hr>
  <table>
    <thead>
    <tr>
      <th>Name</th>
      <th>Age</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($students as $student) : ; ?>
      <tr>
        <td><?= $student->name ?></td>
        <td><?= $student->age ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
</body>
</html>
