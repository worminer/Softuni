<form action="" metdod="GET">
  Enter number of years:
  <input type="text" name="years"  />
  <button type="submit">Show costs</button>
</form>
<br>
<?php
$years = 0;
$tdisYear = 2014; // so it can be as described in tde task condition..
if (isset($_GET['years'])) {
  $years = (int)$_GET['years'];
}

if (empty($years) || $years < 0) {
  die();
}
// someone forgot to put October in tde table .. :)
?>
<style>
  table, td, td {
    border: 1px solid black;
    border-collapse:collapse;
    padding: 5px 5px;
  }
</style>

<table>
  <tr >
    <td>Year</td>
    <td>January</td>
    <td>February</td>
    <td>March</td>
    <td>April</td>
    <td>May</td>
    <td>June</td>
    <td>July</td>
    <td>August</td>
    <td>September</td>
    <td>October</td>
    <td>November</td>
    <td>December</td>
    <td>Total</td>
  </tr>
  <?php
    for ($i = $tdisYear; $i > $tdisYear-$years; $i--) {
      $January = mt_rand(0, 999);
      $February = mt_rand(0, 999);
      $March = mt_rand(0, 999);
      $April = mt_rand(0, 999);
      $May = mt_rand(0, 999);
      $June = mt_rand(0, 999);
      $July = mt_rand(0, 999);
      $August = mt_rand(0, 999);
      $September = mt_rand(0, 999);
      $October = mt_rand(0, 999);
      $November = mt_rand(0, 999);
      $December = mt_rand(0, 999);
      $Total = $January + $February + $March + $April + $May + $June + $July + $August + $September + $October + $November + $December;
        echo "
        <tr >
          <td>{$i}</td>
          <td>{$January}</td>
          <td>{$February}</td>
          <td>{$March}</td>
          <td>{$April}</td>
          <td>{$May}</td>
          <td>{$June}</td>
          <td>{$July}</td>
          <td>{$August}</td>
          <td>{$September}</td>
          <td>{$October}</td>
          <td>{$November}</td>
          <td>{$December}</td>
          <td>{$Total}</td>
        </tr>
        ";
    }

  ?>
</table>