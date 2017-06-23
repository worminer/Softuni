<?php
namespace whateva;

class Person {

    private $name;
    private $age;

    /**
     * Person constructor.
     * @param string $name
     * @param int $age
     */
    public function __construct(string $name, int $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    public function __toString():string
    {

        return "{$this->getName()} {$this->getAge()}";
    }

}

class Femily {
    private $members;

    public function addMember(Person $member)
    {
        $this->members[] = $member;
    }

    /**
     * @return mixed
     */
    public function getMembers()
    {
        return $this->members;
    }

    public function getOldestMember():Person
    {
        $members = $this->getMembers();
        /**
         * @var Person $oldestMember
         */
        $oldestMember = $members[0];
        foreach ($members as $member) {
            /**
             * @var Person $member             *
             */
            if ($member->getAge() > $oldestMember->getAge()) {
                $oldestMember = $member;
            }
        }

        return $oldestMember;

    }
}

$family = new Femily();

$numberOfPeople = intval(fgets(STDIN));

while ($numberOfPeople--){
    $memberInfo = explode(" ", trim(fgets(STDIN)));
    $family->addMember(new Person($memberInfo[0],$memberInfo[1]));
}

echo $family->getOldestMember();