function mfade(){
    $( "div.show" ).effect( "bounce",500 );
}

$(function() {
//$( "div" ).effect( "fade", "slow" );  효과-blind, bounce, clip, drop, explode, fade, highlight, puff, pulsate, scale, shake, size, slide, transfer
$( "div.show" ).show( "fade",1000 );
 setInterval("mfade()" , 3000); //1초단위

});