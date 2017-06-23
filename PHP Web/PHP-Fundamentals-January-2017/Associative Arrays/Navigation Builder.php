<?php
$htmlBuilder = "";
if (isset($_GET['categories']) && !empty($_GET['categories'])) {
  $categories = explode(", ", trim($_GET['categories']));
  $htmlBuilder .= "<h2>Categories</h2>";

  $htmlBuilder .= "<ul>";
  foreach ($categories as $item) {
    $htmlBuilder .= "<li>{$item}</li>";
  }
  $htmlBuilder .= "</ul>";

}

if (isset($_GET['tags']) && !empty($_GET['tags'])) {
  $tags = explode(", ", trim($_GET['tags']));
  $htmlBuilder .= "<h2>Tags</h2>";
  $htmlBuilder .= "<ul>";
  foreach ($tags as $item) {
    $htmlBuilder .= "<li>{$item}</li>";
  }
  $htmlBuilder .= "</ul>";
}

if (isset($_GET['months']) && !empty($_GET['months'])) {
  $months = explode(", ", trim($_GET['months']));
  $htmlBuilder .= "<h2>Months</h2>";
  $htmlBuilder .= "<ul>";
  foreach ($months as $item) {
    $htmlBuilder .= "<li>{$item}</li>";
  }

  $htmlBuilder .= "</ul>";
}
echo $htmlBuilder;