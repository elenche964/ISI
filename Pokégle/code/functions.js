/**
 *Shows css animation when clicking in text field
 * depending on light mode selected.
 */
function barraInf() {
    if(document.getElementById('fondo').checked){
        document.getElementById('caja').className = 'search-bar-prop input-class2';
    }else
        document.getElementById('caja').className = 'search-bar-prop input-class';
}

/**
 *Shows css animation when results/messages are returned from the search
 */
function goTop(){
    document.getElementById('logo').className = 'logo-prop logo-change';
    document.getElementById('searchDiv').className = 'div-buscador search-change';
}

/**
 *Changes search mode value
 */
function changeMode(){
    var tmp = document.getElementById('changeMode');
    if(document.getElementById('modeButton').checked){
        tmp.value = "offline";
    }else{
        tmp.value = "online";
    }

}

/**
 *Changes light mode value
 */
function changeLight(){
    var tmp = document.getElementById('changeLight');
    if(document.getElementById('fondo').checked){
        tmp.value = "night";
    }else{
        tmp.value = "day";
    }
}

/**
 *Changes color palette when clicking in Day/Night button
 */
function changePalette(){
    if(document.getElementById('fondo').checked){
        document.body.style.backgroundImage = "url(\'media/fondo-noche.png\')";
        document.getElementById('searchDiv').style.boxShadow="0 2px 2px 1px #08113d";
        document.getElementById('lupa').style.backgroundImage="url(\'media/gray-search-icon.png\')";
        var namesNight = document.getElementsByClassName('nombrePokemon');
        for(var i = 0; i < namesNight.length; i++) {
                namesNight[i].style.color="whitesmoke";
        }
        var messages = document.getElementsByClassName('message');
        for(var i = 0; i < messages.length; i++) {
            messages[i].style.color="whitesmoke";
        }
    }else {
        document.body.style.backgroundImage = "url(\'media/fondo-hada.png\')";
        document.getElementById('searchDiv').style.boxShadow = "0 2px 2px 1px #2f9b76";
        document.getElementById('lupa').style.backgroundImage = "url(\'media/white-search-icon.png\')";
        var namesDay = document.getElementsByClassName('nombrePokemon');
        for(var i = 0; i < namesDay.length; i++) {
            namesDay[i].style.color="#2f9b76";
        }
        var messages = document.getElementsByClassName('message');
        for(var i = 0; i < messages.length; i++) {
            messages[i].style.color="#2f9b76";
        }
    }
}

/**
 *Changes color palette when clicking in Day/Night button in
 * Full Pokémon Info Page
 */
function changePaletteShow(){
    if(document.getElementById('fondoShow').checked){
        document.body.style.backgroundImage = "url(\'media/fondo-noche.png\')";
        document.getElementById('infobox').style.color="whitesmoke";
        document.getElementById('nameShow').style.color="whitesmoke";
    }else{
        document.body.style.backgroundImage = "url(\'media/fondo-hada.png\')";
        document.getElementById('infobox').style.color="#2f9b76";
        document.getElementById('nameShow').style.color="#2f9b76";
    }
}