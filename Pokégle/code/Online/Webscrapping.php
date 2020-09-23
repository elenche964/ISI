<?php

require_once('htmlDOM/simple_html_dom.php');


class Webscraping
{

    /**
     * The page base url.
     *
     * @var string
     */
    var $sourceBegin = 'https://bulbapedia.bulbagarden.net/wiki/';

    /**
     * The string that indicates that we search a pokemon.
     *
     * @var string
     */
    var $sourceEnd = '_(Pokémon)';

    /**
     * The image list that matches the search.
     *
     * @var array
     */
    var $image_list = array();

    /**
     * The page base url.
     *
     * @var string
     */
    var $sourceXtra = 'https://pokemon.fandom.com/wiki/';

    /**
     * Returns a image for each pokemon that matches the search.
     * There's some name exceptions
     *
     * @param array $data The pokemon list for the search.
     */
    function webSearch($data)
    {
            for ($i = 0; $i < sizeof($data); $i++) {

                if ($data[$i]->name == "nidoran-m") {
                    $data[$i]->name = 'Nidoran♂';
                } else if ($data[$i]->name == "nidoran-f") {
                    $data[$i]->name = 'Nidoran♀';
                }

                $num = $data[$i]->id;

                $capName = ucfirst($data[$i]->name);

                if (!($num==83 || $num==122 || $num==250 || $num==474 || $num==492 || $num==648 || $num==772 || ($num>784 && $num<789))) {
                    $ret = @file_get_html($this->sourceBegin . $capName . $this->sourceEnd)->find('img[alt=' . $capName . ']', 0)->src;
                }

                if (!isset($ret)) {
                    $ret = 'media/Poke_Ball_icon.png';
                }

                array_push($this->image_list, $ret);

            }

            return $this->image_list;
    }

    public function getImages($data)
    {

        return $this->webSearch($data);
    }

    /**
     * Sets height and weight of a pokémon if distance is 0, if not N/A is set.
     * There's some name exceptions, as in image source, but a letter can change pokémon full info,
     * that's why distance is so restricted.
     *
     * @param pokemon $pokemon The pokemon we have to extract the info from and put info into.
     * @param int $dist The Levenshtein distance, if not 0, we set default values.
     */
    public function heightWeight($pokemon, $dist){

        if ($dist==0) {

            $height = @file_get_html($this->sourceXtra . $pokemon->getName())->find('div[data-item-name=height]', 0)->find('span[title=Metric]', 0)->plaintext;
            $pokemon->setHeight($height);

            $weight = @file_get_html($this->sourceXtra . $pokemon->getName())->find('div[data-item-name=weight]', 0)->find('span[title=Metric]', 0)->plaintext;
            $pokemon->setWeight($weight);
        }else{
            $pokemon->setHeight('N/A');
            $pokemon->setWeight('N/A');
        }
    }

}

