<?php
interface ISoldier{
    public function getID();
    public function getFirstName();
    public function getLastName();
}
interface IPrivate{
    public function getSalary();
}
interface ILeutenantGeneral{
    public function getPrivates();
}
interface ISpecializedSoldier{
    public function getCorps();
}
class Soldier implements ISoldier{
    private $id;
    public function getID()
    {
        return $this->id ;
    }
    private $firstName;
    public function getFirstName()
    {
        return $this->firstName;
    }
    private $lastName;
    public function getLastName()
    {
        return $this->lastName ;
    }
    public function __construct($id,$firstName,$lastName)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}
class Privat extends Soldier implements IPrivate{
    private $salary;
    public function getSalary()
    {
        return $this->salary;
    }
    public function __construct($id, $firstName, $lastName,$salary)
    {
        parent::__construct($id, $firstName, $lastName);
        $this->salary = $salary;
    }
    public function __toString()
    {
        $result = "Name: ".$this->getFirstName()." ".$this->getLastName()." Id: ".$this->getID()." Salary: ".sprintf('%0.2f',$this->getSalary());
        return $result;
    }
}
class LeutenantGeneral extends Privat implements ILeutenantGeneral{
    public $privates = [];
    public function getPrivates()
    {
        return $this->privates ;
    }
    public function setPrivates($private){
        $this->privates[] = $private;
    }
    public function __toString()
    {
        $result = "Privates:\n";
        foreach ($this->privates as $private)
        {
            $result  .= "  ".$private."\n";
        }
        return parent::__toString()."\n".trim($result);
    }
}
class Engineer extends Privat implements ISpecializedSoldier{
    public $corps;
    public $repairs;
    public function setReprairs($repairName,$hours){
        $this->repairs[$repairName] = $hours;
    }
    public function getCorps()
    {
        return $this->corps;
    }
    public function __construct($id, $firstName, $lastName, $salary,$corps)
    {
        parent::__construct($id, $firstName, $lastName, $salary);
        $this->corps = $corps;
    }
    public function __toString()
    {
        $result = "Corps: " . $this->getCorps() . "\n";
        $result .= "Repairs:\n";
        if (count($this->repairs) > 0) {
            $keys = array_keys($this->repairs);
            foreach ($keys as $key) {
                $result .= "  Part Name: " . $key . " Hours Worked: " . $this->repairs[$key] . "\n";
            }
        }
        return parent::__toString() . "\n" . trim($result);
    }
}
class Commando extends Privat implements ISpecializedSoldier{
    public $corps;
    public $missions;
    public function setMissions($missionName,$missionState){
        $this->missions[$missionName] = $missionState;
    }
    public function getCorps()
    {
        return $this->corps;
    }
    public function __construct($id, $firstName, $lastName, $salary,$corps)
    {
        parent::__construct($id, $firstName, $lastName, $salary);
        $this->corps = $corps;
    }
    public function __toString()
    {
        $result = "Corps: " . $this->getCorps() . "\n";
        //$result .= "Missions:\n";
        if (count($this->missions) > 0) {
            $result .= "Missions:\n";
            $keys = array_keys($this->missions);
            foreach ($keys as $key) {
                $result .= "  Code Name: " . $key . " State: " . $this->missions[$key] . "\n";
            }
        }else{
            $result .= "Missions:";
        }
        return parent::__toString() . "\n" . $result;
    }
}
class Spy extends Soldier{
    public $spy;
    public function __construct($id, $firstName, $lastName,$spy)
    {
        parent::__construct($id, $firstName, $lastName);
        $this->spy = $spy;
    }
    public function __toString()
    {
        $result = "Name: ".$this->getFirstName()." ".$this->getLastName()." Id: ".$this->getID()."\n"."Code number: ".$this->spy;
        return $result;
    }
}

$army = [];
$command = explode(" ",trim(fgets(STDIN)));
$privates = [];
while($command[0] != "End"){
    switch ($command[0]){
        case "Private":
            $privates[$command[1]] = new Privat($command[1],$command[2],$command[3],$command[4]);
            $army[] = new Privat($command[1],$command[2],$command[3],$command[4]);
            break;
        case "LeutenantGeneral":
            $leutenant = new LeutenantGeneral($command[1],$command[2],$command[3],$command[4]);
            for ($i=5;$i<count($command);$i++){
                $leutenant->setPrivates($privates[$command[$i]]);
            }
            $army[] = $leutenant;
            break;
        case"Engineer":
            $engineer = new Engineer($command[1],$command[2],$command[3],$command[4],$command[5]);
            for ($i=6;$i<count($command);$i+=2){
                $repairName = $command[$i];
                $hours = $command[$i+1];
                $engineer->setReprairs($repairName,$hours);
            }
            $army[] = $engineer;
            break;
        case "Commando":
            $commando = new Commando($command[1],$command[2],$command[3],$command[4],$command[5]);
            for ($i=6;$i<count($command);$i+=2){
                $missionName = $command[$i];
                $missionState = $command[$i+1];
                $commando->setMissions($missionName,$missionState);
            }
            $army[] = $commando;
            break;
        case "Spy":
            $army[] = new Spy($command[1],$command[2],$command[3],$command[4]);
    }
    $command = explode(" ",trim(fgets(STDIN)));
}
$result = "";
foreach ($army as $soldier){
    $result.= $soldier."\n";
}
echo trim($result);