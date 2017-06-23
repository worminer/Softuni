<?php
$inputArr = explode(",", trim(fgets(STDIN)));
function stringToXML(array $inputArr): string {
    $inputArrLen = count($inputArr);
    $output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $output .= "<quiz>\n";
    for ($i = 0; $i < $inputArrLen; $i++) {
        if ($i % 2 == 0) {
            $output .= "  <question>\n    " . trim($inputArr[$i]) . "\n  </question>";

        } else {
            $output .= "\n  <answer>\n    " . trim($inputArr[$i]) . "\n  </answer>\n";
        }
    }
    $output .= "</quiz>\n";
    return $output;
}

echo stringToXML($inputArr);
