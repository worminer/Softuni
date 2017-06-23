<?php
class Employee
{
    private $name;
    private $salary;
    private $position;
    private $department;
    private $email;
    private $age;

    function __construct(string $name,
                         float $salary,
                         string $position,
                         string $department,
                         string $email = "n/a",
                         int $age = -1 )
    {
        $this->name = $name;
        $this->salary = $salary;
        $this->position = $position;
        $this->department = $department;
        $this->email = $email;
        $this->age = $age;
        //echo "TEST:{$this->name} {$salary} {$this->email} {$this->age}\n";
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function getDepartment(): string
    {
        return $this->department;
    }

    public function getEmail(): string
    {
        if ($this->email === null) {
            return "n/a";
        }
        return $this->email;
    }

    public function getAge(): int
    {
        if ($this->age === null) {
            return -1;
        }
        return $this->age;
    }

    public function __toString(): string
    {
        $salary = number_format($this->salary, 2);
        return "{$this->name} {$salary} {$this->email} {$this->age}";
    }

}

class Department {

    private $employees = [];
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }


    public function getEmployees(): array
    {
        return $this->employees;
    }


    public function setEmployees(array $employees)
    {
        $this->employees = $employees;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setNewEmployee(Employee $employee){
        //gives the department new employee
        $this->employees[] = $employee;
    }

    public function getAverageSalary():float {
        return array_sum(array_map(function (Employee $employee){ return $employee->getSalary();},$this->employees)) / count($this->employees);
    }

    public function getEmployeesBySalary (bool $desc = false):array {
        $currentEmployees = $this->employees;
        usort($currentEmployees,function (Employee $firstEmployee, Employee $secondEmployee){
            return $firstEmployee->getSalary() <=> $secondEmployee->getSalary();
        });
        if ($desc) {
            $currentEmployees = array_reverse($currentEmployees);
        }
        return $currentEmployees;
    }

    public function __toString(): string
    {
        $sortedEmployees = $this->getEmployeesBySalary(true);
        $output = "";
        foreach ($sortedEmployees as $employee) {
            $output .= $employee . PHP_EOL;
        }
        return $output;
    }
}

class Company {
    private $departments = [];

    public function setDepartment(Department $department) {
        $this->departments[$department->getName()] = $department;
    }

    public function hasDepartment(string $name)
    {
        return array_key_exists($name,$this->departments);
    }

    public function getDepartment(string $name):Department {
        if (!array_key_exists($name, $this->departments)) {
            throw new \Exception("There is no such Department!");
        }
        return $this->departments[$name];
    }

    public function getBestPayedDepartment():Department
    {   $sortedDepartments = $this->departments;
        usort($sortedDepartments,function (Department $department1,Department $department2){
            return  $department1->getAverageSalary() <=> $department2->getAverageSalary() ;
        });

        return $sortedDepartments[count($sortedDepartments) - 1];
    }
}

$company = new Company();

$linesNum = intval(fgets(STDIN));

for ($i = 0; $i < $linesNum; ++$i) {
    $personInfo = explode(" ", trim(fgets(STDIN)));
    $name = $personInfo[0];
    $salary = number_format(floatval($personInfo[1]),2,'.', '');
    //echo "test-{$salary}\n";
    $position = $personInfo[2];
    $department = $personInfo[3];
    $age = -1;
    $email = "n/a";

    if (isset($personInfo[4])) {
        if (is_numeric($personInfo[4])) {
            $age = intval($personInfo[4]);
        } else {
            $email = $personInfo[4];
        }
    }
    if (isset($personInfo[5])) {
        if (is_numeric($personInfo[5])) {
            $age = intval($personInfo[5]);
        }
    }

    if (!$company->hasDepartment($department)) {
        $company->setDepartment(new Department($department));
    }

    $departmentObj = $company->getDepartment($department);

    $departmentObj->setNewEmployee(new Employee($name, $salary, $position, $department ,$email,$age));
}

$bestPaidDepartment = $company->getBestPayedDepartment();

echo "Highest Average Salary: {$bestPaidDepartment->getName()}" . PHP_EOL;
echo $bestPaidDepartment;
