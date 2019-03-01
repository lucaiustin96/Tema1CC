from http.server import BaseHTTPRequestHandler, HTTPServer, SimpleHTTPRequestHandler
import json
import re
import requests
import datetime
import time
import threading


number_of_requests = 0
latency_sum = 0
latency_sum_first_api = 0
latency_sum_second_api = 0
latency_sum_third_api = 0

def getCountryCurrency(country):
    global latency_sum_first_api
    start_time = time.time()
    url = 'https://restcountries-v1.p.rapidapi.com/name/'+country
    headers = {"X-RapidAPI-Key": "288a4d13d7msh55483352eae7750p18cb3cjsn591fd7309717"}
    r = requests.get(url, headers=headers).json()
    end_time = time.time()
    latency_sum_first_api = latency_sum_first_api + end_time - start_time
    return r[0]["currencies"][0]

def convertUSDToCurrency(currency):
    global latency_sum_second_api
    start_time = time.time()
    url = "https://free.currencyconverterapi.com/api/v6/convert?q=USD_"+currency+"&compact=ultra&apiKey=1430f5dc312b4b43d589"
    #print(url)
    r = requests.get(url).json()
    key = "USD_"+currency
    end_time = time.time()
    latency_sum_second_api = latency_sum_second_api + end_time - start_time
    return r[key]

def getBitcoinValue(currency, value):
    global latency_sum_third_api
    start_time = time.time()
    url = 'https://blockchain.info/tobtc?currency=' + currency + '&value=' + str(value)
    r = requests.get(url)
    end_time = time.time()
    latency_sum_third_api = latency_sum_third_api + end_time - start_time
    return r.content.decode()

class myThread (threading.Thread):
   def __init__(self, request, country):
      threading.Thread.__init__(self)
      self.requestHandler = request
      self.country = country

   def run(self):
       global latency_sum
       start_time = time.time()
       currency = getCountryCurrency(self.country)
       amount = convertUSDToCurrency(currency)
       value = getBitcoinValue(currency, amount)
       end_time = time.time()
       now = datetime.datetime.now()
       request = self.requestHandler.path
       respons = "currency = " + currency + " amount = " + str(amount) + " value = " + str(value)
       latency = end_time - start_time
       latency_sum = latency_sum + latency

       logLine = "Time: " + str(now) + " Request: " + request + " Response: " + respons + " Latency: " + str(latency) + "\n"
       file = open("log.txt", "a")
       file.write(logLine)
       file.close()

       #self.requestHandler.wfile.write(json.dumps({
        #   'bitcoin': value
       #}).encode())

t = []
class RequestHandler(BaseHTTPRequestHandler):
    def do_GET(self):
        #print(self.path)
        if self.path == "/" or self.path == "/index":
            f = open("index.html")
            self.send_response(200)
            self.end_headers()
            self.wfile.write(f.read().encode())

        if re.search("endpoint1", self.path):
            global number_of_requests
            number_of_requests = number_of_requests + 1
            country = re.split("/", self.path)[2]
            if country:
                for i in range(1, 5):
                    thread1 = myThread(self, country)
                    thread1.start()
                    t.append(thread1)
                for thread in t:
                    thread.join()

                file = open("log.txt", "r")
                content = file.read()
                file.close()

                self.send_response(200)
                self.end_headers()
                self.wfile.write(content.encode())
                file = open("log.txt", "w")
                file.write("")

        if re.search("metrics", self.path):
            global latency_sum

            average_latency = latency_sum / (5 * number_of_requests)
            average_first = latency_sum_first_api / (5 * number_of_requests)
            average_secound = latency_sum_second_api / (5 * number_of_requests)
            average_third = latency_sum_third_api / (5 * number_of_requests)
            self.send_response(200)
            self.end_headers()
            self.wfile.write(json.dumps({
                'number of requests': number_of_requests,
                'average latency' : average_latency,
                'first api average' : average_first,
                'second api avergae' : average_secound,
                'third api avergae' : average_third
            }).encode())
        return


if __name__ == '__main__':
    server = HTTPServer(('localhost', 8000), RequestHandler)
    print('Starting server at http://localhost:8000')
    server.serve_forever()