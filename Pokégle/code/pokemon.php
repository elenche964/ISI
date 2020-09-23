<?php

class Pokemon
{

    /**
     * Pokemon name.
     * @var string
     */
    private $name;

    /**
     * Pokemon number.
     * @var integer
     */
    private $number;

    /**
     * Pokemon types.
     * @var array
     */
    private $types;

    /**
     * Pokemon abilities.
     * @var array
     */
    private $abilities;

    /**
     * Pokemon image link
     * @var string
     */
    private $image;

    /**
     * Pokemon HP (Health Points)
     * @var string
     */
    private $HP;

    /**
     * Pokemon base attack
     * @var integer
     */
    private $attack;

    /**
     * Pokemon base defense
     * @var integer
     */
    private $defense;

    /**
     * Pokemon base special attack
     * @var integer
     */
    private $SpAttack;

    /**
     * Pokemon base special defense
     * @var integer
     */
    private $SpDefense;

    /**
     * Pokemon base speed
     * @var integer
     */
    private $speed;

    /**
     * Pokemon height with metric
     * @var string
     */
    private $height;

    /**
     * Pokemon weight with metric
     * @var string
     */
    private $weight;

    /**
     * Complete constructor
     *
     * @param array $pokemon Pokemon info from the API
     * @param array $file_image images for the pokemon or a string for offline mode
     * @return mixed
     */

    public function Pokemon($pokemon, $file_image){

        if($file_image == 'offline'){
            $this->PokemonOffline($pokemon);
            return true;
        }

        $this->PokemonAPI($pokemon);
        $this->setImage($file_image);

    }

    /**
     * Constructor for API info
     *
     * @param array $pokeInfo Pokemon info
     * @return mixed
     */
    private function PokemonAPI($pokeInfo){
        $this->setName(ucfirst($pokeInfo->name));
        $this->setNumber($pokeInfo->id);
        $this->setTypes($pokeInfo->types);
        $this->setAbilities($pokeInfo->abilities);
        $this->setHP($pokeInfo->stats[5]->base_stat);
        $this->setAttack($pokeInfo->stats[4]->base_stat);
        $this->setDefense($pokeInfo->stats[3]->base_stat);
        $this->setSpAttack($pokeInfo->stats[2]->base_stat);
        $this->setSpdefense($pokeInfo->stats[1]->base_stat);
        $this->setSpeed($pokeInfo->stats[0]->base_stat);
    }

    /**
     * Constructor for offline info
     *
     * @param array $pokeInfo Pokemon info
     * @return mixed
     */
    private function PokemonOffline($pokeJSON){
        $this->setName($pokeJSON->name->english);
        $this->setNumber($pokeJSON->id);
        $this->setTypes($pokeJSON->type);
        $this->setHP($pokeJSON->base->HP);
        $this->setAttack($pokeJSON->base->Attack);
        $this->setDefense($pokeJSON->base->Defense);
        $this->setSpAttack($pokeJSON->base->{'Sp. Attack'});
        $this->setSpDefense($pokeJSON->base->{'Sp. Defense'});
        $this->setSpeed($pokeJSON->base->Speed);
        $this->setImage('media/Poke_Ball_icon.png');
        $this->setHeight('N/A');
        $this->setWeight('N/A');
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Pokemon
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     * @return Pokemon
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param mixed $types
     * @return Pokemon
     */
    public function setTypes($types)
    {
        $this->types = $types;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getAbilities()
    {
        return $this->ability;
    }

    /**
     * @param mixed $ability
     * @return Pokemon
     */
    public function setAbilities($ability)
    {
        $this->ability = $ability;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Pokemon
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHP()
    {
        return $this->HP;
    }

    /**
     * @param mixed $HP
     * @return Pokemon
     */
    public function setHP($HP)
    {
        $this->HP = $HP;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAttack()
    {
        return $this->attack;
    }

    /**
     * @param mixed $attack
     * @return Pokemon
     */
    public function setAttack($attack)
    {
        $this->attack = $attack;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     * @param mixed $defense
     * @return Pokemon
     */
    public function setDefense($defense)
    {
        $this->defense = $defense;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpAttack()
    {
        return $this->SpAttack;
    }

    /**
     * @param mixed $SpAttack
     * @return Pokemon
     */
    public function setSpAttack($SpAttack)
    {
        $this->SpAttack = $SpAttack;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpDefense()
    {
        return $this->SpDefense;
    }

    /**
     * @param mixed $Spdefense
     * @return Pokemon
     */
    public function setSpDefense($SpDefense)
    {
        $this->SpDefense = $SpDefense;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @param mixed $speed
     * @return Pokemon
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     * @return Pokemon
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     * @return Pokemon
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }







}