<?php

// $op = shell_exec ( '/Applications/MAMP/htdocs/Anime-Count-Down/Main.py' );
$pythonOutput = "Boruto: Naruto Next Generations;21;4 March 2020 17:55|Boku no Hero Academia;147;8 March 2020 17:30|Nanatsu no Taizai: Kamigaki no Gekirin;147;8 March 2020 17:30";

$arrAllAnime = explode("|", $pythonOutput);

// print_r($arr);

foreach ($arrAllAnime as $EachAnime) {
	$arrEachAnime = explode(";", $EachAnime);
	echo ("<p name='Anime'><h1><span name = 'Title'>");
	echo $arrEachAnime[0];
	echo( "</span></h1> <span name = 'Episode'>Ep: <span name='EpisodeNumber'>");
	echo $arrEachAnime[1];
	echo("</span></span><span name ='date'> Release Date: <span name='ReleaseDate'>");
	echo $arrEachAnime[2];
	echo("</span></span></p>");
}

?>


<!-- Display the countdown timer in an element -->
<p id="demo"></p>

<script>

d = new Date();
localTime = d.getTime();
localOffset = d.getTimezoneOffset() * 60000;
utc = localTime + localOffset;



// Set the date we're counting down to
var ddate= document.querySelector('body > span:nth-child(4) > span').innerText;
var countDownDate = new Date("ddate").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>