//CONTENT 1
var titlesOpacity = 1;

function loadMediaQueries(){
    let littleSize =  window.matchMedia("only screen and (max-width: 479px)");
    let smallSize =  window.matchMedia("only screen and (min-width: 480px) and (max-width: 959px)");
    let mediumSize =  window.matchMedia("only screen and (min-width: 960px) and (max-width: 1280px)");
    let bigSize =  window.matchMedia("only screen and (min-width: 1281px)");

    if (littleSize.matches) { // If media query matches
        titlesOpacity = 1;
    }
    else if(smallSize.matches){
        titlesOpacity = 1;
    }
    else if(mediumSize.matches){
        titlesOpacity = 0.9;
    }
    else if(bigSize.matches){
        titlesOpacity = 0.8;
    }
}