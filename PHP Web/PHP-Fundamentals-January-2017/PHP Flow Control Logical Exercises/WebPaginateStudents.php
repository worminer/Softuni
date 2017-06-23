<?php
session_start();
$page = 0;
if (isset($_GET['page'])) {
  $page = intval($_GET['page']);
  $page = $page >= 0 ? $page : 0;
  if (isset($_SESSION['students']) && !empty($_SESSION['students'])) {
    $students = json_decode($_SESSION['students']);
    if ($page * 5 >= sizeof($students)) {
      unset($students);
    }
  } else {
    session_unset();
  }
} else {
  if (isset($_GET['names']) && isset($_GET['ages']) && isset($_GET['delimiter'])) {
    $studentData = buildStudentData();
    if ($studentData !== false) {
      $students = $studentData;
      $_SESSION['students'] = json_encode($studentData);
    }
  } else {
    session_unset();
  }
}
function buildStudentData() {
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
    return $students;
  }
  return false;
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
    <?php for ($i = $page * 5; $i < min(($page * 5) + 5, sizeof($students)); $i++) : ; ?>
      <tr>
        <td><?= $students[$i]->name ?></td>
        <td><?= $students[$i]->age ?></td>
      </tr>
    <?php endfor; ?>
    </tbody>
  </table>
  <?php if ($page > 0) : ; ?>
    <a href="<?= $_SERVER['PHP_SELF'] ?>?page=<?= $page - 1 ?>">Previous</a>
  <?php endif; ?>
  <?php if (($page + 1) * 5 < sizeof($students)) : ?>
    <a href="<?= $_SERVER['PHP_SELF'] ?>?page=<?= $page + 1 ?>">Next</a>
  <?php endif; ?>
<?php endif; ?>
</body>
</html>
