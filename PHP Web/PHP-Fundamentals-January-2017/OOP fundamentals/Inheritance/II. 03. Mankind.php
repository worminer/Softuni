<?php

namespace Mankind ;

function readLine(): string
{
    return trim(fgets(STDIN));
}

$studentData = explode(" ", readLine());
$workerData = explode(" ", readLine());

/**
 * @var $humans Human[]
 */
$humans = [];
try {
    $humans[] = new Student(...$studentData);
    $humans[] = new Worker($workerData[0], $workerData[1], floatval($workerData[2]), floatval($workerData[3]));

    foreach ($humans as $human) {
        echo $human;
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}

class Human
{
    private $firstName;
    private $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }

    protected function setFirstName(string $firstName)
    {
        if ($firstName[0] !== strtoupper($firstName[0])) {
            throw new \Exception("Expected upper case letter!Argument: firstName");
        }

        if (!preg_match("/.{4,}/", $firstName)) {
            throw new \Exception("Expected length at least 4 symbols!Argument: firstName");
        }

        $this->firstName = $firstName;
    }

    protected function setLastName(string $lastName)
    {
        if ($lastName[0] !== strtoupper($lastName[0])) {
            throw new \Exception("Expected upper case letter!Argument: lastName");
        }

        if (!preg_match("/.{3,}/", $lastName)) {
            throw new \Exception("Expected length at least 3 symbols!Argument: lastName");
        }

        $this->lastName = $lastName;
    }

    public function __toString(): string
    {
        $output = "First Name: {$this->firstName}" . PHP_EOL;
        $output .= "Last Name: {$this->lastName}" . PHP_EOL;

        return $output;
    }
}







class Student extends Human
{
    private $facultyNumber;

    public function __construct(string $firstName, string $lastName, string $facultyNumber)
    {
        parent::__construct($firstName, $lastName);

        $this->setFacultyNumber($facultyNumber);
    }

    public function setFacultyNumber($facultyNumber)
    {
        if (strlen($facultyNumber) < 5 || strlen($facultyNumber) > 10) {
            throw new \Exception("Invalid faculty number!");
        }

        $this->facultyNumber = $facultyNumber;
    }

    public function __toString(): string
    {
        $output = parent::__toString();
        $output .= "Faculty number: {$this->facultyNumber}" . PHP_EOL;

        return $output . PHP_EOL;
    }
}







class Worker extends Human
{
    private $salary;
    private $workHoursPerDay;

    public function __construct(string $firstName, string $lastName, float $salary, float $workHoursPerDay)
    {
        parent::__construct($firstName, $lastName);

        $this->setSalary($salary);
        $this->setWorkHoursPerDay($workHoursPerDay);
    }

    protected function setLastName(string $lastName)
    {
        if (strlen($lastName) < 3) {
            throw new \Exception("Expected length more than 3 symbols!Argument: lastName");
        }


        parent::setLastName($lastName);
    }

    protected function setSalary(float $salary)
    {
        if ($salary <= 10) {
            throw new \Exception("Expected value mismatch!Argument: weekSalary");
        }

        $this->salary = $salary;
    }

    protected function setWorkHoursPerDay(float $workHoursPerDay)
    {
        if ($workHoursPerDay < 1 || $workHoursPerDay > 12) {
            throw new \Exception("Expected value mismatch!Argument: workHoursPerDay");
        }

        $this->workHoursPerDay = $workHoursPerDay;
    }

    public function __toString(): string
    {
        $output = parent::__toString();
        $output .= "Week Salary: " . number_format($this->salary, 2, '.', ''). PHP_EOL;
        $output .= "Hours per day: " . number_format($this->workHoursPerDay, 2, '.', ''). PHP_EOL;
        $output .= "Salary per hour: " . number_format($this->calculateSalaryPerHour(), 2, '.', ''). PHP_EOL;

        return $output;
    }

    private function calculateSalaryPerHour(): float
    {
        return $this->salary / 7 / $this->workHoursPerDay;
    }
}






