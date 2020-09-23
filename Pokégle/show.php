<?php
require_once('code/Online/Online.php');
require_once ('code/Offline/offline.php');

$dataOn = new Online();
$dataOffline = new offline();
$json = file_get_contents('docs/pokedex.json');
$dataOffline->setPokemonList($json);
$myFullData = null;

if (isset($_GET['id'])){
    $pokemonId = $_GET['id'];
    if(isset($_GET['mode'])) {
        $modo = $_GET['mode'];
        $myFullData = $dataOffline->getPokemon('id', $pokemonId, $modo)[0];
    }else if (!isset($_GET['mode'])){
        $myFullData = $dataOn->searchPokemons('id', $pokemonId)[0];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="code/functions.js"></script>
    <title>
        <?php
        echo ucfirst($myFullData->getName());
        ?>
    </title>
</head>
<body class="body-bg" style="display: block">

<div class="buttonPosition">

    <label class="switch switch-flat">
        <input class="switch-input" type="checkbox" id="fondoShow" onclick="changePaletteShow()"/>
        <span class="switch-label" data-on="Night" data-off="Day"></span>
        <span class="switch-handle"></span>
    </label>

</div>

<div class="logo-prop-show" id="logo">
    <img class="pokegle-logo" src="media/pokegle-logo-blanco.png">
</div>

<div class="pokemon infobox" id="infobox">
    <?php
    if($_GET['light'] == "night"){
        echo '<script>document.getElementById("fondoShow").click()</script>';
    }
    echo '<div class="nombrePokemon nameShow" id="nameShow">'. ucfirst($myFullData->getName()) .
    '</div>

    <div class="contentData"><div class="block-info"><div class="fotoPokemon" >' .
        '<img class="imageDiv" style="max-height: 200px" src="'. $myFullData->getImage() . '" /></div>
    <div>';

    echo '<b>Size:</b><br>&emsp;Height:'. $myFullData->getHeight().'<br>&emsp;Weight:'. $myFullData->getWeight();
    echo '<br><br><b>Types:</b><br>';

    if(isset($_GET['mode'])){
        for ($i = 0; $i < sizeof($myFullData->getTypes()); $i++)
            echo '&emsp;' . ucfirst($myFullData->getTypes()[$i]) . '<br>';
    }else {
        for ($i = 0; $i < sizeof($myFullData->getTypes()); $i++)
            echo '&emsp;' . ucfirst($myFullData->getTypes()[$i]->type->name) . '<br>';
    }

    echo '</div>
    </div>
    <div class="block-info" style="float: right">';

    echo '<b>Id: </b>'.$myFullData->getNumber().'<br><br><b>Name: </b>'. ucfirst($myFullData->getName()). '
    <br> <br><b>Stats:</b>'.
        '<br>&emsp;HP: '.$myFullData->getHp().
        '<br>&emsp;Attack: '.$myFullData->getAttack().
        '<br>&emsp;Defense: '.$myFullData->getDefense().
        '<br>&emsp;Sp. Attack: '.$myFullData->getSpAttack().
        '<br>&emsp;Sp. Defense: '.$myFullData->getSpDefense().
        '<br>&emsp;Speed: '.$myFullData->getSpeed();

    echo '<br><br><b>Abilities:</b><br>';

    if(isset($_GET['mode'])){
        echo '<br>Offline mode can\'t show abilities, please make a new search with "online" mode enabled.';
    }else {
        for ($i = 0; $i < sizeof($myFullData->getAbilities()); $i++)
            echo '&emsp;' . ucfirst($myFullData->getAbilities()[$i]->ability->name) . '<br>';
    }
    echo '<script>changePaletteShow();</script></div>';
?>
</div></div>

</body>
</html>