<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="google-site-verification" content="FQHL0GahvQppWp5VXcGojp5xz8nRWCwfvfElEQX8YLw" />
</head>

<body>
	

	<?php


// this is a check to see if it is run on my local server or on the webserver.
// return will output the error code [i guess?]. 0 is no error.

	exec( '/Library/Frameworks/Python.framework/Versions/3.7/bin/python3 ./Main.py', $pythonOutput, $return);

	if ($return != 0){
		exec( '/opt/alt/python37/bin/python3 ./Main.py', $pythonOutput, $return);		
	}

// error checker.
	// $pythonOutput = array("Boruto: Naruto Next Generations;152;05 April 2020 17:30;['https://cdn.myanimelist.net/images/anime/4/83369.jpg', 'https://cdn.myanimelist.net/images/anime/12/86784.jpg', 'https://cdn.myanimelist.net/images/anime/1393/96860.jpg', 'https://cdn.myanimelist.net/images/anime/1777/104957.jpg']|Boku no Hero Academia;26;9 April 2020 17:30;['https://cdn.myanimelist.net/images/anime/1978/95162.jpg', 'https://cdn.myanimelist.net/images/anime/1251/97634.jpg', 'https://cdn.myanimelist.net/images/anime/1831/102539.jpg', 'https://cdn.myanimelist.net/images/anime/1315/102961.jpg', 'https://cdn.myanimelist.net/images/anime/1137/105203.jpg', 'https://cdn.myanimelist.net/images/anime/1023/105559.jpg', 'https://cdn.myanimelist.net/images/anime/1233/106246.jpg', 'https://cdn.myanimelist.net/images/anime/1744/106248.jpg']|Nanatsu no Taizai: Kamigaki no Gekirin;11;8 April 2020 17:30;['https://cdn.myanimelist.net/images/anime/1574/100519.jpg', 'https://cdn.myanimelist.net/images/anime/1546/103418.jpg']|Black Clover;129;7 April 2020 18:25;['https://cdn.myanimelist.net/images/anime/5/88165.jpg', 'https://cdn.myanimelist.net/images/anime/2/88336.jpg', 'https://cdn.myanimelist.net/images/anime/1426/94678.jpg', 'https://cdn.myanimelist.net/images/anime/1461/101072.jpg', 'https://cdn.myanimelist.net/images/anime/1190/105182.jpg']");

	$arrAllAnime = explode("|", $pythonOutput[0]);

		// print_r($arrAllAnime);
	$animearray = [];

	echo "<div id = AnimeList>";

	foreach ($arrAllAnime as $EachAnime) {
		$temp=[];
		$arrEachAnime = explode(";", $EachAnime);
		$temp['rd'] = $arrEachAnime[2];
		$temp[] = ("<div class='Anime'>");

		// searches ] [  and ' and replaces them with nothing.
		$searchval = array("]","[","'");
		$replaceval = array("","","");

		$imagelinks = str_replace($searchval,$replaceval,$arrEachAnime[3]);
		$imagelinksarr = explode(',', $imagelinks);
		$temp[] = ("<h1>");
		$temp[] =  $arrEachAnime[0];
		$temp[] = ( "</h1>");

		foreach ($imagelinksarr as $imagelinks) {
			$temp[] = ('<img class="mySlides" src="' . $imagelinks . '">');
		}

		$temp[] = ("<span class = 'Episode'>Ep: <span name='EpisodeNumber'>");
		$temp[] =  $arrEachAnime[1];
		$temp[] = ("</span></span><span name ='date'> Release Date: <span name='ReleaseDate'>");
		$temp[] =  $arrEachAnime[2];
		$temp[] = ("</span></span><span name ='countdown'> Time left: <span name='Timer'>");
		$temp[] = ("</span></span></div>");
		
		// first check if array is empty
		if (count($animearray) == 0) {
			$animearray[] = $temp;
		}else{ 
			// if anime is finished, doesnt matter add it to the last.
			if ($arrEachAnime[2] == 'Finished') {
				$animearray[] = $temp;
			}else{
				// check if first anime added was finished. If yes, simply add the current anime to the first position.
				if ($animearray[0]['rd'] == 'Finished') {
					array_unshift($animearray,$temp);	
				}else{
					// loop from first of animearray and add it before the first nth item whose release date is after current anime's date.
					for ($i=0; $i < count($animearray); $i++) { 
						if ($animearray[$i]['rd'] == 'Finished') {
							break;
						}
						
						$date1 = new DateTime($arrEachAnime[2]);
						$date2 = new DateTime($animearray[$i]['rd']);
						if ($date1>$date2) {
							continue;
						}else{ 
							break;
						}
					}
					array_splice($animearray, $i, 0, array($temp));
				}
				
			}
			
		}


	}


	foreach ($animearray as $anime) {
		foreach ($anime as $k => $v) {
			if ($k !== 'rd') {
				echo $v;
			}
			
		}
	}

	echo "</div>"
	
	?>
	
	<!-- timer script -->
	<script>

		var AnimeList = document.getElementById('AnimeList').getElementsByTagName('div');

		for (var Anime of AnimeList){

			var ReleasedateJST= Anime.querySelector("span[name='ReleaseDate']").innerText;
			console.log(ReleasedateJST);
			if (ReleasedateJST != 'Finished') {
				var ReleaseDateJSTepoch = new Date(ReleasedateJST).getTime();
				var JSToffset = -9*3600000;
				var ReleaseDateUTCepoch = ReleaseDateJSTepoch + JSToffset;

				var d = new Date();
				var localOffset = d.getTimezoneOffset() * 60000;
				var ReleaseDatelocalepoch = ReleaseDateUTCepoch - localOffset;
				var ReleaseDatelocalepochDateObj = new Date(ReleaseDatelocalepoch);
				var ReleaseDatelocal = ReleaseDatelocalepochDateObj.toDateString() + ' ' + ReleaseDatelocalepochDateObj.toLocaleTimeString('en-US');
				Anime.querySelector("span[name='ReleaseDate']").innerText = ReleaseDatelocal;

				// Update the count down every 1 second
				var x = setInterval(Counter, 1000, Anime, ReleaseDateUTCepoch);
			}else{
				Anime.querySelector("span[name='Timer']").innerHTML = "Ended!"
			}

		}

		function Counter(Anime, ReleaseDateUTCepoch) {

			// Get today's date and time
			var d = new Date();
			var localTime = d.getTime();
			var localOffset = d.getTimezoneOffset() * 60000;
			var UTClocal = localTime + localOffset;

			// Find the distance between now and the count down date
			var distance = ReleaseDateUTCepoch - UTClocal;

			// Time calculations for days, hours, minutes and seconds
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			if(String(days).length < 2){days = "0" + String(days);}
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			if(String(hours).length < 2){hours = "0" + String(hours);}
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			if(String(minutes).length < 2){minutes = "0" + String(minutes);}
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			if(String(seconds).length < 2){seconds = "0" + String(seconds);}

			// Display the result
			Anime.querySelector("span[name='Timer']").innerHTML = days + "d " + hours + "h "
			+ minutes + "m " + seconds + "s ";

			// If the count down is finished, write some text 
			if (distance < 0) {
				clearInterval(x);
				Anime.querySelector("span[name='Timer']").innerHTML = "Released!"
			}
		}
	</script>


	<!--slideshow script-->

	<script>
		
		var slideIndex = Array();
		Animes = document.querySelectorAll(".Anime")

		Anime = Animes.length - 1; 
		for (var i = 0 ; i <= Anime; i++) {
			slideIndex[i] = 0;
		}

		slideshow();



		function slideshow(){

			for (var i = 0 ; i <= Anime; i++) {
				Images = Animes[i].querySelectorAll("img");

				for (var j = 0; j <= Images.length - 1; j++) {
					if (j != slideIndex[i]) {Images[j].hidden = true;}
					else{Images[j].hidden = false;}
				}
			}


			for (var i = 0 ; i <= Anime; i++) {
				slideIndex[i]++;
				if(slideIndex[i] > Animes[i].querySelectorAll("img").length -1 ){slideIndex[i] = 0;}
			}

			setTimeout(slideshow, 5000); // Change image every 5 seconds
		}
	</script>

</body>




















