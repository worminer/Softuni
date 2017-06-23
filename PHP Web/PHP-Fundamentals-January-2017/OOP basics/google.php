<?php
namespace google;
/**
 * Class Google
 * @package google
 */
class Google{
    /**
     * @var array
     */
    private $subjects = [];

    /**
     * @param array $subjectInfo
     */
    public function setSubjectInfo(array $subjectInfo){
        $subjectName = array_shift($subjectInfo);

        if (!array_key_exists($subjectName,$this->getSubjects())) {
            $this->addNewSubject($subjectName);
            //var_export($this->subjects);
        }

        $subject = $this->getSubjectByName($subjectName);
        $subject->setSubjectData($subjectInfo);
    }

    /**
     * @return array
     */
    public function getSubjects(): array
    {
        return $this->subjects;
    }

    /**
     * @param string $name
     * @return Subject
     */

    public function getSubjectByName(string $name): Subject
    {
        $subjects = $this->subjects;
        return $subjects[$name];
    }

    public function existSubjectByName(string $name): bool
    {
        return array_key_exists($name, $this->subjects);
    }

    /**
     * @param string $name
     */

    public function addNewSubject($name)
    {
        $this->subjects[$name] = new Subject($name);
    }

    public function getSubjectInfo(string $name)
    {
        if (!$this->existSubjectByName($name)) {
            throw new \Exception("There is no person with name:{$name} in DB.");
        }

        echo $this->getSubjectByName($name);

    }

}

/**
 * Class Subject
 * @package google
 */
class Subject
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var Company
     */
    private $company = null;
    /**
     * @var Car
     */
    private $car = null;
    /**
     * @var array
     */
    private $parents = [];
    /**
     * @var array
     */
    private $children = [];
    /**
     * @var array
     */
    private $pokemons = [];


    /**
     * Subject constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }


    /**
     * @param array $subjectData
     * @throws \Exception
     */
    public function setSubjectData(array $subjectData)
    {
        $infoType = array_shift($subjectData);

        if ($infoType == "company") {
            $this->setCompany($subjectData);
        } else if ($infoType == "pokemon") {
            $this->addNewPokemon($subjectData);
        } else if ($infoType == "parents") {
            $this->addNewParent($subjectData);
        } else if ($infoType == "children") {
            $this->addNewChild($subjectData);
        } else if ($infoType == "car") {
            $this->setCar($subjectData);
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $companyData
     */
    public function setCompany($companyData)
    {
        if (!isset($this->company)) {
            $companyName = array_shift($companyData);
            $companyDepartment = array_shift($companyData);
            $companySalary = array_shift($companyData);
            $this->company = new Company($companyName, $companyDepartment, floatval($companySalary));
        }
    }


    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param array $carData
     */
    public function setCar(array $carData)
    {
        if (!isset($this->car)) {
            $this->car = new Car($carData[0], intval($carData[1]));
        }
    }


    public function getParents():array
    {
        return $this->parents;
    }

    /**
     * @param array $parentData
     */
    public function addNewParent(array $parentData)
    {
        $this->parents[] = new Person($parentData[0], $parentData[1]);;
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param array $childData
     */
    public function addNewChild(array $childData)
    {
        $this->children[] = new Person($childData[0], $childData[1]);
    }

    /**
     * @return array
     */
    public function getPokemons(): array
    {
        return $this->pokemons;
    }

    /**
     * @param array $pokemonData
     */
    public function addNewPokemon(array $pokemonData)
    {
        $this->pokemons[] = new Pokemon($pokemonData[0], $pokemonData[1]);
    }

    public function __toString(): string
    {
        $output = "{$this->name}" . PHP_EOL;
        $output .= "Company:" . PHP_EOL;
        $output .= $this->company != null ? $this->company . PHP_EOL : "";
        $output .= "Car:" . PHP_EOL;
        $output .= $this->car != null ? $this->car . PHP_EOL : "";
        $output .= "Pokemon:" . PHP_EOL;
        foreach ($this->pokemons as $pokemon) {
            $output .= $pokemon . PHP_EOL;
        }
        $output .= "Parents:" . PHP_EOL;
        foreach ($this->parents as $parent) {
            $output .= $parent . PHP_EOL;
        }
        $output .= "Children:" . PHP_EOL;
        foreach ($this->children as $child) {
            $output .= $child . PHP_EOL;
        }
        return $output;
    }



}

/**
 * Class Company
 * @package google
 */
class Company {
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $department;
    /**
     * @var float
     */
    private $salary;

    /**
     * Company constructor.
     * @param string $name
     * @param string $department
     * @param float $salary
     */
    public function __construct(string $name, string  $department, float $salary)
    {
        $this->name = $name;
        $this->department = $department;
        $this->salary = $salary;
    }

    public function __toString(): string
    {
        $salary = number_format($this->salary, 2);
        return "{$this->name} {$this->department} {$salary}";
    }

}

/**
 * Class Pokemon
 * @package google
 */
class Pokemon {
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $type;

    /**
     * Pokemon constructor.
     * @param string $name
     * @param string $type
     */
    public function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function __toString(): string
    {
        return "{$this->name} {$this->type}";
    }

}

/**
 * Class Person
 * @package google
 */
class Person {
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $birthDay;

    /**
     * Person constructor.
     * @param string $name
     * @param string $birthDay
     */

    public function __construct(string $name, string $birthDay)
    {
        $this->name = $name;
        $this->birthDay = $birthDay;
    }

    public function __toString(): string
    {
        return "{$this->name} {$this->birthDay}";
    }
}

/**
 * Class Car
 * @package google
 */
class Car {
    /**
     * @var string
     */
    private $model;
    /**
     * @var string
     */
    private $speed;

    /**
     * Car constructor.
     * @param string $model
     * @param int  $speed
     */
    public function __construct(string $model, int $speed)
    {
        $this->model = $model;
        $this->speed = $speed;
    }

    public function __toString(): string
    {
        return "{$this->model} {$this->speed}";
    }

}
$google = new Google();
try {
    while (true) {
        $command = explode(" ", fgets(STDIN));
        if ($command[0] == "End") {
            break;
        } else {
            $google->setSubjectInfo($command);
        }
    }

    $subject = trim(fgets(STDIN));
    $google->getSubjectInfo($subject);
} catch (\Exception $e){
    echo $e->getMessage();
}


