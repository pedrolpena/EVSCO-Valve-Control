import socket
import time
import sqlite3
import sys
import decimal as d
import haversine
import EvscoValveControl as valve
conn = sqlite3.connect("/var/www/portLocations.db")
cursor = conn.cursor()
sql = "SELECT lat,lon,radius,port_name FROM port_locations"
rows = cursor.execute(sql)
listOfPorts = rows.fetchall()
lastState = "unk"
firstStart = "True"
list = []
while True:
    try:
        s = socket.socket()
        s.connect(('192.168.10.1',4))
        time.sleep(.5)
        allIn = s.recv(4096).split("\n")
        for line in allIn:
            if "RMC," in line:
                list = line.split(",")
                break

 #       list = s.recv(4096).split(",")
        lat = (d.Decimal(list[3][0] + list[3][1]) + d.Decimal(list[3][2:len(list[3])])/60)
        lon = (d.Decimal(list[5][0]+list[5][1]+list[5][2]) + d.Decimal(list[5][3:len(list[5])])/60)

        if list[4].upper() == "S":
            lat = -1 * lat

        if list[6].upper() == "W":
            lon = -1 * lon

        currentPosition = lat,lon
        s.close()
        open = True
        for x in listOfPorts:
            port = d.Decimal(x[0]),d.Decimal(x[1])
            distanceToPort = haversine.distance(currentPosition,port)
            if distanceToPort < d.Decimal(x[2]):
                open = False
#            if distanceToPort > d.Decimal(x[2]):
#                open = True
#            print x[3],distanceToPort
        if open == True and lastState != "True":
            print "Opening Valve"
            lastState = "True"
            valve.open_evsco_valve()

        if open == False and lastState != "False":
            print "Closing Valve"
            lastState = "False"
            valve.close_evsco_valve()    

    except:
        print "Something aint right\n"
#        sys.exit(0)
#        pass
        if lastState != "unk" or firstStart == "True":
            valve.open_evsco_valve()
            lastState = "unk"
            firstStart = "False"


