<?php

require_once('code/Offline/offline.php');
require_once ('code/Online/Online.php');

//Info JSON, poner el modo offline para esto

$json = file_get_contents('docs/pokedex.json');
$dataOffline = new offline();
$dataOff = $dataOffline->setPokemonList($json);

$dataOnline = new Online();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="code/functions.js"></script>
    <title>Pokégle</title>

</head>
<body class="body-bg" id="body">

<div class="buttonPosition">

    <label class="switch switch-flat">
        <input class="switch-input" type="checkbox" id="fondo" onclick="changeLight(); changePalette();"/>
        <span class="switch-label" data-on="Night" data-off="Day"></span>
        <span class="switch-handle"></span>
    </label>

    <label class="switch switch-flat" style="margin: 3% 3% auto auto">
        <input class="switch-input" type="checkbox" id="modeButton" onclick="changeMode()"/>
        <span class="switch-label" data-on="Offline" data-off="Online"></span>
        <span class="switch-handle"></span>
    </label>

</div>

<div class="logo-prop" id="logo">
    <img class="pokegle-logo" src="media/pokegle-logo-blanco.png">
</div>

<form method="post" enctype="multipart/form-data" action="">
    <div class="div-buscador" id="searchDiv">
        <div class="select-info">
            <select name="SelectInfo" class="transparente">
                <option value="type">Type</option>
                <option value="id">Number</option>
                <option value="name">Name</option>
                <option value="region">Region</option>
            </select>
        </div>
        <div id="caja" class="search-bar-prop">
            <input class="transparente" type="text" name="InputInfo" placeholder="Search" onclick="barraInf();">
        </div>
        <input type="hidden" id="changeMode" value="online" name="changingMode">
        <input type="hidden" id="changeLight" value="day" name="changingLight">
        <div class="lupa" id="lupa">
            <input class="transparente" type="submit" value="" name="SubmitSearch">
        </div>
    </div>
</form>




<!--Resultados-->
   <?php

    if (isset($_POST['InputInfo']) && isset($_POST['SelectInfo'])){

        if($_POST['changingLight']=="night")
            echo '<script>document.getElementById("fondo").click()</script>';

        if($_POST['changingMode']=="offline")
            echo '<script>document.getElementById("modeButton").click()</script>';


        $attribute = $_POST['SelectInfo'];
        $value = $_POST['InputInfo'];

        $lightMode = $_POST['changingLight'];
        $searchMode = $_POST['changingMode'];

        echo '<div class="full"><div class="resultados" id="res">';

        echo '<script>goTop();</script>';

        if($_POST['changingMode']=='offline') {

            $modo = $_POST['changingMode'];

            if ($attribute == 'region') {
                echo '<div class="message">Offline mode is not prepared for region search, please change mode to "online".</div>';
            } else {
                $resultado = $dataOffline->getPokemon($attribute, $value, $modo);

                if (is_array($resultado)) {
                    for ($i = 0; $i < sizeof($resultado); $i++) {
                        echo '<button class="pokemon" onclick="window.open(\'show.php?id=' . $resultado[$i]->getNumber() . '&light=' . $lightMode .
                            '&mode=' . $searchMode . '\',\'_blank\');">';
                        echo '<div class="nombrePokemon"><b> ' . $resultado[$i]->getNumber() . ' ' . $resultado[$i]->getName() . '</b></div>';
                        echo '<div class="fotoPokemon"><img class="imageDiv" src="media/Poke_Ball_icon.png" /></div>';
                        echo '</button>';
                    }

                } else if ($resultado!=null) {
                    echo '<div class="message">'.$resultado.'</div>';
                }
            }

        }elseif ($_POST['changingMode']=='online'){

            $resultado = $dataOnline->searchPokemons($attribute, $value);


            if(is_array($resultado)) {
                for ($i = 0; $i < sizeof($resultado); $i++) {
                    echo '<button class="pokemon" onclick="window.open(\'show.php?id='.$resultado[$i]->getNumber().'&light=' . $lightMode .
                        '\',\'_blank\');">';
                    echo '<div class="nombrePokemon"><b> ' . $resultado[$i]->getNumber() . ' ' . $resultado[$i]->getName(). '</b></div>';
                    echo '<div class="fotoPokemon"><img class="imageDiv" src="'. $resultado[$i]->getImage() . '" /></div>';
                    echo '</button>';
                }
                if($attribute=='type' || $attribute=='region'){
                    echo '<script>changePalette(); alert("Search is limited to 12 due to space problems, please make a more accurate search by name or National Pokédex id.")</script>';
                }

            }else if ($resultado!=null){
                echo '<div class="message">'.$resultado.'</div>';
            }
        }

        echo '<script>changePalette();</script></div></div>';

    }
    ?>

</body>
</html>