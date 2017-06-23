<?php

class Trainer {
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $badges = 0;
    /**
     * @var array
     */
    private $pokemons = [];

    /**
     * Trainer constructor.
     * @param string $name
     */
    public function __construct(string  $name)
    {
        $this->name = $name;
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
    public function getBadges(): int
    {
        return $this->badges;
    }

    /**
     * @return array
     */
    public function getPokemons(): array
    {
        return $this->pokemons;
    }

    /**
     * @param Pokemon $pokemon
     */
    public function addPokemon(Pokemon $pokemon)
    {
        $this->pokemons[] = $pokemon;
    }

    public function havePokemonOfType(string $element):bool
    {
        foreach ($this->getPokemons() as $pokemon) {
            /**
             * @var Pokemon $pokemon
             */
            if ($pokemon->getElement() == $element) {
                return true;
            }
        }
        return false;
    }
    public function hitPokemons(int $dmg){
        foreach ($this->pokemons as $pokemon){
            /**
             * @var Pokemon $pokemon
             */
            $pokemon->dmgPokemon($dmg);
            if (!$pokemon->isAlive()) {
                array_splice($this->pokemons, array_search($pokemon, $this->pokemons), 1);
            }
        }
    }
    
    public function fight(string $element, int $dmg){
        if ($this->havePokemonOfType($element)) {
            $this->badges += 1;
        } else {
            $this->hitPokemons($dmg);
        }
    }
    public function getPokemonCount():int {
        return count($this->pokemons);
    }

    public function __toString():string
    {
        return "{$this->getName()} {$this->getBadges()} {$this->getPokemonCount()}\n";
    }

}



class Pokemon {
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $health;
    /**
     * @var string
     */
    private $element;



    /**
     * Pokemon constructor.
     * @param string $name
     * @param int $health
     * @param string $element
     */
    public function __construct(string $name, string $element, int $health)
    {
        $this->name = $name;
        $this->health = $health;
        $this->element = $element;
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
    public function getHealth(): int
    {
        return $this->health;
    }

    /**
     * @return string
     */
    public function getElement(): string
    {
        return $this->element;
    }
    public function isAlive():bool{
        return $this->health > 0;
    }

    public function dmgPokemon(int $dmg){
        if ($this->isAlive()) {
            $this->health -= $dmg;
        }
    }
}

$trainers = [];

while (true) {
    $command = explode(" ", trim(fgets(STDIN)));
    if ($command[0] == "Tournament") {
        break;
    } else {
        if (!array_key_exists($command[0], $trainers)) {
            $trainers[$command[0]] = new Trainer($command[0]);
        }
        /**
         *  @var Trainer $trainer
         */
        $trainer = $trainers[$command[0]] ;
        //echo $command[1] .'- added\n';
        $trainer->addPokemon(new Pokemon($command[1], $command[2], $command[3]));
    }
}

while (true) {
    $command = trim(fgets(STDIN));
    
    if ($command == "End") {
        break;
    } else if ($command == "Fire") {
        foreach ($trainers as $trainer){
        /**
         *  @var Trainer $trainer
         */
            $trainer->fight("Fire",10);
        }
    } else if ($command == "Water") {
        foreach ($trainers as $trainer){
            /**
             *  @var Trainer $trainer
             */
            $trainer->fight("Water",10);
        }
    } else if ($command == "Electricity") {
        foreach ($trainers as $trainer){
            /**
             *  @var Trainer $trainer
             */
            $trainer->fight("Electricity",10);
        }
    }
}
usort($trainers,function ($trainer1,$trainer2){
    /**
     * @var Trainer $trainer1
     * @var Trainer $trainer2
     */
   return -($trainer1->getBadges() <=> $trainer2->getBadges());
});
foreach ($trainers as $trainer){
    /**
     *  @var Trainer $trainer
     */
    echo $trainer;
}
