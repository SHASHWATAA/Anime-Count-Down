<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="google-site-verification" content="FQHL0GahvQppWp5VXcGojp5xz8nRWCwfvfElEQX8YLw" />
</head>

<body>
	

	<?php


	 exec( '/Library/Frameworks/Python.framework/Versions/3.7/bin/python3 ./Main.py', $pythonOutput, $return);

	 if ($return != 0){
	 	exec( '/opt/alt/python37/bin/python3 ./Main.py', $pythonOutput, $return);		
	}

	//$pythonOutput = array("Boruto: Naruto Next Generations;147;8 March 2020 17:30;['https://cdn.myanimelist.net/images/anime/4/83369.jpg', 'https://cdn.myanimelist.net/images/anime/12/86784.jpg', 'https://cdn.myanimelist.net/images/anime/1393/96860.jpg', 'https://cdn.myanimelist.net/images/anime/1777/104957.jpg']|Boku no Hero Academia;84;7 March 2020 17:30;['https://cdn.myanimelist.net/images/anime/1978/95162.jpg', 'https://cdn.myanimelist.net/images/anime/1251/97634.jpg', 'https://cdn.myanimelist.net/images/anime/1831/102539.jpg', 'https://cdn.myanimelist.net/images/anime/1315/102961.jpg', 'https://cdn.myanimelist.net/images/anime/1137/105203.jpg', 'https://cdn.myanimelist.net/images/anime/1023/105559.jpg', 'https://cdn.myanimelist.net/images/anime/1233/106246.jpg', 'https://cdn.myanimelist.net/images/anime/1744/106248.jpg']|Nanatsu no Taizai: Kamigaki no Gekirin;21;4 March 2020 17:55;['https://cdn.myanimelist.net/images/anime/1574/100519.jpg', 'https://cdn.myanimelist.net/images/anime/1546/103418.jpg']");

	$arrAllAnime = explode("|", $pythonOutput[0]);

		// print_r($arrAllAnime);

	echo "<div id = AnimeList>";

	foreach ($arrAllAnime as $EachAnime) {
		$arrEachAnime = explode(";", $EachAnime);
		echo ("<div class='Anime'>");

		$searchval = array("]","[","'");
		$replaceval = array("","","");
		$imagelinks = str_replace($searchval,$replaceval,$arrEachAnime[3]);
		$imagelinksarr = explode(',', $imagelinks);
		echo("<h1>");
		echo $arrEachAnime[0];
		echo( "</h1>");

		foreach ($imagelinksarr as $imagelinks) {
			echo('<img class="mySlides" src="' . $imagelinks . '">');
		}

		echo("<span class = 'Episode'>Ep: <span name='EpisodeNumber'>");
		echo $arrEachAnime[1];
		echo("</span></span><span name ='date'> Release Date: <span name='ReleaseDate'>");
		echo $arrEachAnime[2];
		echo("</span></span><span name ='countdown'> Time left: <span name='Timer'>");
		echo("</span></span></div>");
	}

	echo "</div>"
	
	?>
	
	<!-- timer script -->
	<script>

		var AnimeList = document.getElementById('AnimeList').getElementsByTagName('div');

		for (var Anime of AnimeList){

			var ReleasedateJST= Anime.querySelector("span[name='ReleaseDate']").innerText;
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




















