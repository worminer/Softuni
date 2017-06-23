<style>
  table, th, td {
    border: 1px solid black;
    border-collapse:collapse;
    padding: 5px 5px;
  }

  .orange {
    background-color: darkorange;
  }
</style>

<?php

function showInformation($infoArr){
  if (gettype($infoArr) == "array") {
    echo "    
      <table>
        <tr>
          <td class='orange'>Name</td>
          <td>{$infoArr['name']}</td>
        </tr>
        <tr>
          <td class='orange'>Phone number</td>
          <td>{$infoArr['phone']}</td>
        </tr>
        <tr>
          <td class='orange'>Age</td>
          <td>{$infoArr['age']}</td>
        </tr>
        <tr>
          <td class='orange'>Address</td>
          <td>{$infoArr['address']}</td>
        </tr>
        
      </table>
    ";
    
    
  } else {
    echo "Error: Function parameter is not an array!";
  }
  echo "<br>";
}
// variant 1
showInformation(['name' => "Gosho" , 'phone' => "0882-321-423" , 'age' => 24 , "address" => 'Hadji Dimitar']);


//variant 2
$personalInfo = ['name' => "Pesho" , 'phone' => "0884-888-888" , 'age' => 67 , "address" => 'Suhata Reka'];

showInformation($personalInfo);