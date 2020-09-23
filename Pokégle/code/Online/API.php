<?php

require_once('code/pokemon.php');

class API
{
    /**
     * The pokemon list that matches the search.
     *
     * @var array
     */
    var $pokemon_list = array();

    /**
     * The common path for all API searches.
     *
     * @var string
     */
    var $source = 'https://pokeapi.co/api/v2/';

    /**
     * Max pokémon id allowed in our API.
     *
     * @var integer
     */
    private $max_id = 808;

    /**
     * Search for Pokemon data through API.
     *
     * @param string $attribute The pokemon attribute we search.
     * @param string $value the value of that attribute.
     */
    private function searchAPI($attribute, $value){

        if($attribute=='type'){

            $myUrl = $this->getMyNumber($attribute, $value);

            if($myUrl==null){
                return 'Are you sure about the existence of that type? 
                        <p>Check types <a href="#" 
                        onclick="window.open(\'https://bulbapedia.bulbagarden.net/wiki/Type\'
                        , \'_blank\')">here</a>.</p>';
            }

            $this->getTypePokemons($myUrl);

        }else if($attribute=='region'){

            $myUrl = $this->getMyNumber($attribute, $value);

            if($myUrl==null){
                return 'Are you sure that it appears on the map? 
                        <p>You should take a look  <a href="#" 
                        onclick="window.open(\'https://pokemon.fandom.com/wiki/Regions\',
                         \'_blank\')">here</a>, dude.</p>';
            }

            $this->getRegionPokemons($myUrl);

        }else if($attribute=='id' or $attribute=='name'){

            $myPageName = $this->source . 'pokemon/'. $value;

            $myData = $this->getData($myPageName);

            if($myData!=null){
                array_push($this->pokemon_list, $myData);
            }else{

                return 'Are you sure that Pokémon exists? Remember Pokémons máx Ndex (National Pokédex id) right now is '.
                    $this->max_id .'.<p>Check full Pókemon list <a href="#" 
                    onclick="window.open(\'https://bulbapedia.bulbagarden.net/wiki/List_of_Pok%C3%A9mon_by_National_Pok%C3%A9dex_number\',
                     \'_blank\')">here</a>.</p>';
            }

        }

        return $this->pokemon_list;

    }

    /**
     * Insert all the pokemons from the region pokedex in my pokemon list
     *  Limited to 12 due to storage size
     *
     * @param string $myUrl the Url with the region data
     */
    private function getRegionPokemons($myUrl){

        $region_data = $this->getData($myUrl);

        $my_pokedex = $this->getData($region_data->pokedexes[0]->url); //Some has 2 different pokedexes, but I prefer the original one

        for($i=0; $i<12; $i++) { //Complete data $i<sizeof($my_pokedex->pokemon_entries)

            $differentUrlData = $this->getData($my_pokedex->pokemon_entries[$i]->pokemon_species->url);

            //We get the pokemon page because the page is ../pokemon-species/id
            //and the info contained is different, so we get the id and the data
            //from the ../pokemon/id as in type
            $pokemonData = $this->source . 'pokemon/' . $differentUrlData->id;

            array_push($this->pokemon_list, $this->getData($pokemonData));
        }
    }

    /**
     * Insert all the pokemons from the type list in my pokemon list
     * Limited to 12 due to storage size
     *
     * @param string $myUrl the Url with all pokemon data for the type
     */
    private function getTypePokemons($myUrl){
        $url_list = $this->getData($myUrl);

        if($url_list!=null) {
            for ($i = 0; $i < 12; $i++) //Complete data $i<sizeof($url_list)
                array_push($this->pokemon_list, $this->getData($url_list->pokemon[$i]->pokemon->url));
        }
    }

    /**
     * Gets the URL that correspond to the type/region searched because we can't access by name,
     * but by number correspondence.
     *
     * @param string $attribute The attribute we search for (type/region).
     * @param string $value The value of the attribute we search for.
     */

    private function getMyNumber($attribute, $value){

        $myPageName = $this->source . strtolower($attribute);

        $aux = $this->getData($myPageName);

        $myUrl = null;

        for($i=0; $i<$aux->count; $i++){
            if($aux->results[$i]->name == $value)
                $myUrl= $aux->results[$i]->url;
        }

        return $myUrl;

    }

    /**
     * Returns a JSON with all the data we extract from the API url.
     * We capitalize the name so we only do it once.
     *
     * @param string $url The URL we want the data from.
     */
    private function getData($url){

        $data= array();

        $myPage = curl_init($url);
        curl_setopt($myPage, CURLOPT_RETURNTRANSFER, TRUE);
        $info = curl_exec($myPage);
        if(curl_errno($myPage)){
            return null;
            exit;
        }
        curl_close($myPage);

        $data = json_decode($info);

        return $data;
    }

    /**
     * Returns the list of pokemons that matches the search.
     *
     * @param string $attribute The attribute we search for (type/region).
     * @param string $value The value of the attribute we search for.
     */
    public function getPokemons($attribute, $value){

        return $this->searchAPI($attribute, $value);
    }

}