#!/Library/Frameworks/Python.framework/Versions/3.7/bin/python3

import requests
from lxml import html

def get_release_countdown(url):
	r  = requests.get(url)
	timer = html.fromstring(r.content).xpath('normalize-space(//*[@id="app"]/div[3]/div/div[2]/div[1]/div[2]/div[1]/div[2]/span)')
	return timer


urls  = [('Boruto: Naruto Next Generations', 'https://anilist.co/anime/97938/Boruto-Naruto-Next-Generations'),
		 ('Boku no Hero Academia', 'https://anilist.co/anime/104276/Boku-no-Hero-Academia-4'),
		 ('Nanatsu no Taizai: Kamigaki no Gekirin','https://anilist.co/anime/108928/Nanatsu-no-Taizai-Kamigami-no-Gekirin')]


for item in urls:
	print ("<p><h1>", item[0], "</h1> " , get_release_countdown(item[1]), "</p>")