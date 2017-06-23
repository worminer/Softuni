<?php
$examsRaw = explode(',', $_GET['string']);
$exams = [];
foreach ($examsRaw as $examData){
    $data = explode(":", $examData);
    $points = trim($data[1]);
    if ($points >= 0 && $points <=400 ) {
        $data =  explode("-", $data[0]);
        $studentName = trim($data[0]);
        $examName = trim($data[1]);
        if (!array_key_exists($examName,$exams)) {
            $exams[$examName] = [];
        }
        if (!array_key_exists($studentName,$exams[$examName])) {
            $exams[$examName][$studentName] = [];
            $exams[$examName][$studentName]["makeups"] = 0;
            $exams[$examName][$studentName]["score"] = $points;
        } else {
            if ($points > $exams[$examName][$studentName]["score"]) {
                $exams[$examName][$studentName]["score"] = $points;
            }
            $exams[$examName][$studentName]["makeups"]++;
        }
    }
}
?>
<table>
<tr><th>Subject</th><th>Name</th><th>Result</th><th>MakeUpExams</th>
<?php
foreach ($exams as $examName => $examData){
    uasort($examData, function ($a,$b) {
        if ($a['score'] == $b['score']) {
            if ($a['makeups'] == $b['makeups']) {
                if ($a == $b) {
                    return 0;
                }
                return ($a < $b) ? -1 : 1;
            }
            return ($a['makeups'] < $b['makeups']) ? -1 : 1;
        }
        return ($a['score'] > $b['score']) ? -1 : 1;
    });
    foreach ($examData as $studentName => $studentData){

        echo "<tr><td>{$examName}</td><td>{$studentName}</td><td>{$studentData['score']}</td><td>{$studentData['makeups']}</td></tr>".PHP_EOL;
    }
}
?>
</table>

