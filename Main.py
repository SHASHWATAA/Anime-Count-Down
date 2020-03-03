#!/Library/Frameworks/Python.framework/Versions/3.7/bin/python3

import requests
from lxml import html
phptransfer=''

def get_image(url):
	r  = requests.get(url)
	image = html.fromstring(r.content).xpath('//*[@id="content"]/table/tr/td[2]/div[1]/table/tr/td[1]/div[1]/a/img/@data-src')
	
	return image

def get_release_countdown(url):
	r  = requests.get(url)
	episode = html.fromstring(r.content).xpath('//tr[contains(@class, "day-future")][1]/td[2]/span[contains(text(),*)]/text()')
	date = html.fromstring(r.content).xpath('//tr[contains(@class, "day-future")][1]/td/span[contains(@class, "datetime")]/text()')
	countdowndata = (episode,date)
	
	return countdowndata 


urls  = [('Boruto: Naruto Next Generations', 'https://www.monthly.moe/anime/1048-boruto-naruto-next-generations', 'https://myanimelist.net/anime/34566/Boruto__Naruto_Next_Generations/pics'),
		 ('Boku no Hero Academia', 'https://www.monthly.moe/anime/2082-boku-no-hero-academia-2019', 'https://myanimelist.net/anime/38408/Boku_no_Hero_Academia_4th_Season/pics'),
		 ('Nanatsu no Taizai: Kamigaki no Gekirin','https://www.monthly.moe/anime/2117-nanatsu-no-taizai-kamigami-no-gekirin','https://myanimelist.net/anime/39701/Nanatsu_no_Taizai__Kamigami_no_Gekirin/pics'),
		 ('One Piece','https://www.monthly.moe/anime/181-one-piece','https://myanimelist.net/anime/21/One_Piece/pics')]


for item in urls:
	# print ("<p id ='t'><span>", item[0], "</span> <span>episode:" , get_release_countdown(item[1])[1][0], "</span><span>release date:", get_release_countdown(item[1])[0][0] ,"</span></p>")
	name = item[0]
	episodenum 	= get_release_countdown(item[1])[0][0]
	releaseDate = get_release_countdown(item[1])[1][0].strip()
	releaseDate = releaseDate[0:releaseDate.find(" JST")]
	imageUrl 	= get_image(item[2])
	combined = name + ";" + episodenum + ";" + releaseDate + ";" + str(imageUrl)
	phptransfer = phptransfer + "|" + combined

print(phptransfer[1:])