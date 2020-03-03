<?php

// $pythonOutput = shell_exec ( '/Applications/MAMP/htdocs/Anime-Count-Down/Main.py' );
$pythonOutput = "Boruto: Naruto Next Generations;147;8 March 2020 17:30|Boku no Hero Academia;84;7 March 2020 17:30|Nanatsu no Taizai: Kamigaki no Gekirin;21;4 March 2020 17:55";

$arrAllAnime = explode("|", $pythonOutput);

// print_r($arrAllAnime);

echo "<div id = AnimeList>";

foreach ($arrAllAnime as $EachAnime) {
	$arrEachAnime = explode(";", $EachAnime);
	echo ("<div name='Anime'><h1><span name = 'Title'>");
	echo $arrEachAnime[0];
	echo( "</span></h1> <span name = 'Episode'>Ep: <span name='EpisodeNumber'>");
	echo $arrEachAnime[1];
	echo("</span></span><span name ='date'> Release Date: <span name='ReleaseDate'>");
	echo $arrEachAnime[2];
	echo("</span></span><span name ='countdown'> Time left: <span name='Timer'>");
	echo("</span></span></div>");
}

echo "</div>"
?>





<!-- Display the countdown timer in an element -->
<p id="demo"></p>

<script>

	var AnimeList = document.getElementById('AnimeList').getElementsByTagName('div');
	
	for (var Anime of AnimeList){

	// Set the date we're counting down to
	var Releasedate= Anime.querySelector('span:nth-child(3) > span').innerText;
	var countDownDateJST = new Date(Releasedate).getTime();
	var JSToffset = -9*3600000;
	var countDownDateUTC = countDownDateJST + JSToffset;


	// Update the count down every 1 second
	var x = setInterval(Counter, 1000, Anime, countDownDateUTC);	
	
	}

function Counter(Anime, countDownDateUTC) {

	  // Get today's date and time
	  d = new Date();
	  localTime = d.getTime();
	  localOffset = d.getTimezoneOffset() * 60000;
	  UTClocal = localTime + localOffset;

	  // Find the distance between now and the count down date
	  var distance = countDownDateUTC - UTClocal;

	  // Time calculations for days, hours, minutes and seconds
	  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
	  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
	  // Display the result in the element with id="demo"
	  Anime.querySelector("span:nth-child(4) > span").innerHTML = days + "d " + hours + "h "
	  + minutes + "m " + seconds + "s ";

	  // If the count down is finished, write some text 
	  if (distance < 0) {
	  	clearInterval(x);
	  	Anime.getElementById("demo").innerHTML = "EXPIRED";
	  }
	}
</script>





















