#!/Library/Frameworks/Python.framework/Versions/3.7/bin/python3

import requests
from lxml import html

def get_release_countdown(url):
	r  = requests.get(url)
	date = html.fromstring(r.content).xpath('//tr[contains(@class, "day-future")][1]/td/span[contains(@class, "datetime")]/text()')
	episode = html.fromstring(r.content).xpath('//tr[contains(@class, "day-future")][1]/td[2]/span[contains(text(),*)]/text()')
	countdowndata = (date,episode)
	return countdowndata 


urls  = [('Boruto: Naruto Next Generations', 'https://www.monthly.moe/anime/2117-nanatsu-no-taizai-kamigami-no-gekirin'),
		 ('Boku no Hero Academia', 'https://www.monthly.moe/anime/1048-boruto-naruto-next-generations'),
		 ('Nanatsu no Taizai: Kamigaki no Gekirin','https://www.monthly.moe/anime/1048-boruto-naruto-next-generations')]


for item in urls:
	print ("<p><h1>", item[0], "</h1> episode:" , get_release_countdown(item[1])[1][0], "release date:", get_release_countdown(item[1])[0][0] ,"</p>")