<?php

require_once('code/pokemon.php');

class offline
{

    /**
     * Max pokémon id allowed in our API.
     *
     * @var integer
     */
    private $max_id = 809;

    /**
     * Th list with the pokemon objects for Offline mode
     * @var array
     */
    var $pokemon_list;

    /**
     * We transform the string given into JSON object
     *
     * @param string $doc
     */
    function setPokemonList($doc){
        $this->pokemon_list = json_decode($doc);
    }

    /**
     * Complete function for searching info inside the offline mode
     *
     * @param $attribute
     * @param $value
     * @param string $inputType if the pokemon object will be for offline mode
     * @return mixed
     */
    private function buscarPokemon($attribute, $value, $inputType){

        $mi_array = array();

        if($attribute == 'name'){
            for($i=0; $i<sizeof($this->pokemon_list); $i++) {
                if(strtolower($this->pokemon_list[$i]->$attribute->english) == trim(strtolower($value))) {
                    $pokemon = new Pokemon($this->pokemon_list[$i], $inputType);
                    array_push($mi_array, $pokemon);
                }
            }

        }else if ($attribute == 'type'){
            for ($i = 0; $i < sizeof($this->pokemon_list); $i++) {
                for ($j =0; $j < sizeof($this->pokemon_list[$i]->type); $j++){
                    if (strtolower($this->pokemon_list[$i]->$attribute[$j]) == trim(strtolower($value))) {
                        $pokemon = new Pokemon($this->pokemon_list[$i], $inputType);
                        array_push($mi_array, $pokemon);
                    }
                }
            }
            if($mi_array==null){
                return 'No data found.
                        <p>Check types <a href="#" 
                        onclick="window.open(\'https://bulbapedia.bulbagarden.net/wiki/Type\'
                        , \'_blank\')">here</a>.</p>';
            }
        }else{
            for($i=0; $i<sizeof($this->pokemon_list); $i++) {
                if($this->pokemon_list[$i]->$attribute == $value) {
                    $pokemon = new Pokemon($this->pokemon_list[$i], $inputType);
                    array_push($mi_array, $pokemon);
                }
            }
        }

        if($mi_array==null){
            return 'No data found. Remember Pokémons máx Ndex (National Pokédex id) right now is '.
                $this->max_id .'.<p>Check full Pókemon list <a href="#" 
                    onclick="window.open(\'https://bulbapedia.bulbagarden.net/wiki/List_of_Pok%C3%A9mon_by_National_Pok%C3%A9dex_number\',
                     \'_blank\')">here</a>.</p>';
        }
        return $mi_array;

    }

    /**
     * Public function for searching info
     *
     * @param $attribute
     * @param $value
     * @param string $inputType if the pokemon object will be for offline mode
     * @return mixed
     */
    public function getPokemon($attribute, $value, $inputType){

        return $this->buscarPokemon($attribute, $value, $inputType);

    }

}