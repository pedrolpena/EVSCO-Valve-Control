import socket
import time


while True:
    try:
        list = []
        s = socket.socket()
        s.connect(('172.16.107.53',4))
        time.sleep(.5)
        list = s.recv(4096).split(",")
        print list[3]+list[4]+" "+list[5]+list[6]
        s.close()
    except:
        pass
