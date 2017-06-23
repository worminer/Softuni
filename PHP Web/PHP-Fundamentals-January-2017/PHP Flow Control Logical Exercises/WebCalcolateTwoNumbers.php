<?php
if (isset($_GET['numA']) && !empty(trim($_GET['numA'])) &&
    isset($_GET['numB']) && !empty(trim($_GET['numB'])) &&
    isset($_GET['operation']) && !empty(trim($_GET['operation']))
) {
  if (is_numeric(trim($_GET['numA'])) && is_numeric(trim($_GET['numB']))) {
    $operation = trim($_GET['operation']);
    $numA = intval(trim($_GET['numA']));
    $numB = intval(trim($_GET['numB']));
    $result = 0;
    switch ($operation) {
      case 'sum':
        $result = $numA + $numB;
        break;
      case 'subtract':
        $result = $numA - $numB;
        break;
      default:
        echo 'Wrong operation supplied!';
        break;
    }
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Calculate</title>
</head>
<body>
<form action="" method="get">
  <div>
    <label for="operation">Operation</label>
    <select name="operation" id="operation" title="Operation" required>
      <option value="sum">Sum</option>
      <option value="subtract">Subtract</option>
    </select>
  </div>
  <div>
    <label for="numA">Number 1:</label>
    <input type="number" name="numA" id="numA" required>
  </div>
  <div>
    <label for="numB">Number 2:</label>
    <input type="number" name="numB" id="numB" required>
  </div>
  <?php if (isset($result)) : ; ?>
    <div>
      <label for="result">Result:</label>
      <input type="text" id="result" disabled value="<?= $result ?>">
    </div>
  <?php endif; ?>
  <div>
    <button>Calculate</button>
  </div>
</form>
</body>
</html>




