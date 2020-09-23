<?php
require_once('API.php');
require_once('Webscrapping.php');
require_once('code/pokemon.php');
require_once('htmlDOM/simple_html_dom.php');


class Online
{
    /**
     * An API object for the class
     *
     * @var API
     */
    private $api;

    /**
     * A Webscrapping  object for the class
     *
     * @var Webscrapping
     */
    private $ws;

    /**
     * Needed url for extracting height and weight info
     *
     * @var string
     */
    private $HWUrl = 'https://pokemon.fandom.com/wiki/';

    /**
     * Th list with the pokemon objects for Online mode
     * @var array
     */
    var $pokemon_list = array();

    /**
     * Constructor
     */
    function Online(){
        $this->api = new API();
        $this->ws = new Webscraping();
    }

    /**
     * Unifies all pokemon API data with it's image
     *
     * @param array $pokeInfo info from the api
     * @param array $pokeImage images from webscrapping
     */
    private function unifyData($pokeInfo, $pokeImage){
        for ($i = 0; $i < sizeof($pokeInfo); $i++) {
            $pokemon = new Pokemon($pokeInfo[$i], $pokeImage[$i]);
            array_push($this->pokemon_list, $pokemon);
        }

        $this->compararInfo($this->pokemon_list);
    return $this->pokemon_list;
    }

    /**
     * Uses Levenshtein's distance comparing API given name with
     * webpage title name
     *
     * @param array $pokeInfo info from the api
     */
    private function compararInfo($pokeInfo){

        for($i=0; $i<sizeof($pokeInfo);$i++){
            $num = $pokeInfo[$i]->getNumber();
            $dist=1;
            if (!($num==83 || $num==122 || $num==250 || $num==474 || $num==492 || $num==648 || $num==772 || ($num>784 && $num<789))) {
                $LevensName = @file_get_html($this->HWUrl . $pokeInfo[$i]->getName())->find('h2[data-source=name]', 0)->plaintext;
                $dist = levenshtein($pokeInfo[$i]->getName(), $LevensName);
            }
            $this->ws->heightWeight($pokeInfo[$i], $dist);
        }

    }

    /**
     * Public search function
     *
     * @param array $attribute
     * @param array $value
     * @return mixed Error message or full pokemon list
     */
    public function searchPokemons($attribute, $value){

        $value =trim(strtolower($value));

        $pokeInfo = $this->api->getPokemons($attribute, $value);
        if(is_array($pokeInfo)) {
            $pokeImage = $this->ws->getImages($pokeInfo);
            return $this->unifyData($pokeInfo, $pokeImage);
        }else{
            return $pokeInfo;
        }
    }

}