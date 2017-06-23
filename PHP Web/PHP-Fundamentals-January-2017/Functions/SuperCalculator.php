<?php
$command = trim(fgets(STDIN));
$result = array();
$finally = false;
while(!$finally){
    if($finally){
        break;
    }
    $result = CheckCommand($command,$result,$finally);
    if($finally){
        break;
    }
    $command = trim(fgets(STDIN));
    if($command == "finally"){
        break;
    }
}
$finally = true;
$command = trim(fgets(STDIN));
$result = CheckCommand($command,$result,$finally);
if(count($result)> 1) {
    echo implode(', ', $result);
}else{
    echo $result[0];
}

function CheckCommand(&$command,$result,&$finally){
    switch ($command){
        case "sum":
            if($finally){
                $result = Sum();
            }else {
                $result[] = Sum();
            }
            break;
        case "multiply":
            if($finally){
                $result = Multiply();
            }else {
                $result[] = Multiply();
            }
            break;
        case "divide":
            try{
                if($finally){
                    $result = Divide();
                }else {
                    $result[] = Divide();
                }
            }catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                $command = trim(fgets(STDIN));
                if($command =="finally"){
                    $finally = true;
                }else {
                    $result = CheckCommand($command, $result, $finally);
                }
            }
            break;
        case "subtract":
            if($finally){
                $result = Subtract();
            }else {
                $result[] = Subtract();
            }
            break;
        case "power":
            if($finally){
                $result = Power();
            }else {
                $result[] = Power();
            }
            break;
        case "quadratic":
            try{
                if($finally){
                    $result = QuadraticEquasion();
                }else {
                    $result[] = QuadraticEquasion();
                }
            }catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                $command = trim(fgets(STDIN));
                if($command =="finally"){
                    $finally = true;
                }else {
                    $result = CheckCommand($command, $result, $finally);
                }
            }
            break;
        case "root":
            try {
                if ($finally) {
                    $result = Root();
                } else {
                    $result[] = Root();
                }
            }catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                $command = trim(fgets(STDIN));
                if($command =="finally"){
                    $finally = true;
                }else {
                    $result = CheckCommand($command, $result, $finally);
                }
            }
            break;
        case "triangleArea":
            try {
                if ($finally) {
                    $result = triangleArea();
                } else {
                    $result[] = triangleArea();
                }
            }catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                $command = trim(fgets(STDIN));
                if($command =="finally"){
                    $finally = true;
                }else {
                    $result = CheckCommand($command, $result, $finally);
                }
            }
            break;
        case "pythagorean":
            if($finally){
                $result = pythagoreanTheorem();
            }else {
                $result[] = pythagoreanTheorem();
            }
            break;
        case "absolute":
            if($finally){
                $result = Absolute();
            }else {
                $result[] = Absolute();
            }
            break;
        case "factorial":
            if($finally){
                for ($i=0;$i<count($result);$i++){
                    $result[$i] = factorial($result[$i]);
                }
            }else {
                $num = (trim(fgets(STDIN)));
                $result[] = factorial($num);
            }
            break;
        case "finally":
            $finally = true;
            break;
    }
    return $result;
}
function triangleArea(){
    global $finally;
    if($finally){
        global $result;
        $count = count($result);
        if($count<3){
            return $result;
        }else {
            while(count($result)>2){
                $p = ($result[0] + $result[1] + $result[2]) / 2;
                $area= sqrt($p * ($p - $result[0]) * ($p - $result[1]) * ($p - $result[2]));
                if(is_nan($area)){
                    throw new Exception("Can't take the root of a negative number");
                }else {
                    array_splice($result, 0, 3);
                    $result[] = $area;
                }
            }
            return $result;
        }
    }else {
        $a = (trim(fgets(STDIN)));
        $b = (trim(fgets(STDIN)));
        $c = (trim(fgets(STDIN)));
        $p = ($a + $b + $c) / 2;
        $area = sqrt($p * ($p - $a) * ($p - $b) * ($p - $c));
        if(is_nan($area)){
            throw new Exception("Can't take the root of a negative number");
        }else {
            return $area;
        }
    }
}
function Sum(){
    global $finally;
    if($finally){
        global $result;
        $count = count($result);
        if($count<2){
            return $result[0];
        }else {
            while(count($result)>1){
                $sum = $result[0]+$result[1];
                array_splice( $result, 0, 2);
                $result[] = $sum;
            }
            return $result;
        }
    }else {
        $a = (trim(fgets(STDIN)));
        $b = (trim(fgets(STDIN)));
        return $a + $b;
    }
}
function Multiply(){
    global $finally;
    if($finally){
        global $result;
        $count = count($result);
        if($count<2){
            return $result[0];
        }else {
            while(count($result)>1){
                $multiply = $result[0]*$result[1];
                array_splice( $result, 0, 2);
                $result[] = $multiply;
            }
            return $result;
        }
    }else {
        $a = (trim(fgets(STDIN)));
        $b = (trim(fgets(STDIN)));
        return $a * $b;
    }
}
function Divide(){
    global $finally;
    if($finally){
        global $result;
        $count = count($result);
        if($count<2){
            return $result[0];
        }else {
            while(count($result)>1){
                if($result[1]==0){
                    throw new Exception ("Division by zero.");
                }else {
                    $multiply = $result[0] / $result[1];
                    array_splice($result, 0, 2);
                    $result[] = $multiply;
                }
            }
            return $result;
        }
    }else {
        $a = (trim(fgets(STDIN)));
        $b = (trim(fgets(STDIN)));
        if ($b == 0) {
            throw new Exception('Division by zero.');
        } else {
            return $a / $b;
        }
    }
}
function Subtract(){
    global $finally;
    if($finally){
        global $result;
        $count = count($result);
        if($count<2){
            return $result[0];
        }else {
            while(count($result)>1){
                $sum = $result[0]-$result[1];
                array_splice( $result, 0, 2);
                $result[] = $sum;
            }
            return $result;
        }
    }else {
        $a = (trim(fgets(STDIN)));
        $b = (trim(fgets(STDIN)));
        return $a - $b;
    }
}
function Power(){
    global $finally;
    if($finally){
        global $result;
        $count = count($result);
        if($count<2){
            return $result[0];
        }else {
            while(count($result)>1){
                $pow = pow($result[0],$result[1]);
                array_splice( $result, 0, 2);
                $result[] = $pow;
            }
            return $result;
        }
    }else {
        $a = (trim(fgets(STDIN)));
        $b = (trim(fgets(STDIN)));
        return pow($a, $b);
    }
}
function QuadraticEquasion(){
    global $finally;
    if($finally){
        global $result;
        $count = count($result);
        if($count<3){
            return $result;
        }else {
            while(count($result)>2){
                $a = $result[0];
                $b = $result[1];
                $c = $result[2];
                if ($a == 0) {
                    throw new Exception('Division by zero.');
                } else {
                    $d = $b * $b - 4 * $a * $c;
                    if ($d < 0) {
                        array_splice( $result, 0, 3);
                        $result[] = 0;
                        return $result;
                    } elseif ($d == 0) {
                        array_splice( $result, 0, 2);
                        $result[] =  (-$b / 2 * $a);
                        return $result;

                    } else {
                        $x1 = ((-$b + sqrt($d)) / (2 * $a));
                        $x2 = ((-$b - sqrt($d)) / (2 * $a));
                        array_splice( $result, 0, 3);
                        $result[] = $x1+$x2;
                        return $result;
                    }
                }
            }
            return $result;
        }
    }else {
        $a = trim(fgets(STDIN));
        $b = trim(fgets(STDIN));
        $c = trim(fgets(STDIN));
        if ($a == 0) {
            throw new Exception('Division by zero.');
        } else {
            $d = $b * $b - 4 * $a * $c;
            if ($d < 0) {
                return 0;
            } elseif ($d == 0) {
                return (-$b / 2 * $a);
            } else {
                $x1 = ((-$b + sqrt($d)) / (2 * $a));
                $x2 = ((-$b - sqrt($d)) / (2 * $a));
                return $x1 + $x2;
            }
        }
    }
}
function Root(){
    global $finally;
    if($finally){
        global $result;
        for ($i=0;$i<count($result);$i++){
            if($result[$i]<0){
                throw new Exception("Can't take the root of a negative number");
            }
            $result[$i] = sqrt($result[$i]);
        }
        return $result;
    }else {
        $a = trim(fgets(STDIN));
        if($a<0){
            throw new Exception("Can't take the root of a negative number");
        }
        return sqrt($a);
    }
}
function pythagoreanTheorem(){
    global $finally;
    if($finally){
        global $result;
        $count = count($result);
        if($count<2){
            return $result[0];
        }else {
            while(count($result)>1){
                $pythagor = sqrt(pow($result[0],2)+pow($result[1],2));
                array_splice( $result, 0, 2);
                $result[] = $pythagor;
            }
            return $result;
        }
    }else {
        $a = trim(fgets(STDIN));
        $b = trim(fgets(STDIN));
        return sqrt(pow($a, 2) + pow($b, 2));
    }
}
function Absolute(){
    global $finally;
    if($finally){
        global $result;
        for ($i=0;$i<count($result);$i++){
            $result[$i] = abs($result[$i]);
        }
        return $result;
    }else {
        $x = (trim(fgets(STDIN)));
        return abs($x);
    }
}
function factorial($number)
{
    if ($number < 2) {
        return 1;
    } else {
        return ($number * factorial($number - 1));
    }
}