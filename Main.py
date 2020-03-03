#!/Library/Frameworks/Python.framework/Versions/3.7/bin/python3

import requests
from lxml import html
from multiprocessing import Process, Queue
phptransfer=''
CountdownQueue = Queue()
ImagesQueue = Queue()

def get_image(url,queue):
	r  = requests.get(url)
	image = html.fromstring(r.content).xpath('//*[@id="content"]/table/tr/td[2]/div[1]/table/tr/td[1]/div[1]/a/img/@data-src')
	
	queue.put(image)

def get_release_countdown(url,queue):
	r  = requests.get(url)
	episode = html.fromstring(r.content).xpath('//tr[contains(@class, "day-future")][1]/td[2]/span[contains(text(),*)]/text()')
	date = html.fromstring(r.content).xpath('//tr[contains(@class, "day-future")][1]/td/span[contains(@class, "datetime")]/text()')
	countdowndata = (episode,date)
	
	queue.put(countdowndata)


urls  = [('Boruto: Naruto Next Generations', 'https://www.monthly.moe/anime/1048-boruto-naruto-next-generations', 'https://myanimelist.net/anime/34566/Boruto__Naruto_Next_Generations/pics'),
		 ('Boku no Hero Academia', 'https://www.monthly.moe/anime/2082-boku-no-hero-academia-2019', 'https://myanimelist.net/anime/38408/Boku_no_Hero_Academia_4th_Season/pics'),
		 ('Nanatsu no Taizai: Kamigaki no Gekirin','https://www.monthly.moe/anime/2117-nanatsu-no-taizai-kamigami-no-gekirin','https://myanimelist.net/anime/39701/Nanatsu_no_Taizai__Kamigami_no_Gekirin/pics')]


for item in urls:
	# print ("<p id ='t'><span>", item[0], "</span> <span>episode:" , get_release_countdown(item[1])[1][0], "</span><span>release date:", get_release_countdown(item[1])[0][0] ,"</span></p>")
	name = item[0]

	jobs = (get_release_countdown,get_image)
	args = ((item[1],CountdownQueue),(item[2],ImagesQueue))
	
	for job, arg in zip(jobs, args):
		Process(target=job, args=arg).start()

	scrapeddata = CountdownQueue.get()
	episodenum 	= scrapeddata[0][0]
	releaseDate = scrapeddata[1][0].strip()
	releaseDate = releaseDate[0:releaseDate.find(" JST")]
	imageUrl 	= ImagesQueue.get()
	combined = name + ";" + episodenum + ";" + releaseDate + ";" + str(imageUrl)
	phptransfer = phptransfer + "|" + combined

print(phptransfer[1:])