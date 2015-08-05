##   ##  ######   #####    #####
###  ##  ##  ##  ### ###  ### ###
#### ##  ##  ##  ##   ##  ##   ##
## ####  ##  ##  #######  #######
##  ###  ##  ##  ##   ##  ##   ##
##   ##  ######  ##   ##  ##   ##

# Main Valve Control File
# Written 2014
# Edited July 2015


import socket
import time
import sqlite3
import sys
import decimal as d
import haversine
import EvscoValveControl as valve

#Call the database file of port locations on the ship's route
conn = sqlite3.connect("/var/www/portLocations.db")
cursor = conn.cursor()
sql = "SELECT lat,lon,radius,port_name FROM port_locations"
rows = cursor.execute(sql)
listOfPorts = rows.fetchall()
lastState = "unk"
firstStart = "True"
list = []

### forever try to connect and complete the task
while True:
    try:
        #connect to a computer with a socket server
        s = socket.socket()
        s.connect(('192.168.10.1',4))
        time.sleep(.5)
        #grab something from the connection,
        allIn = s.recv(4096).split("\n")
        for line in allIn:
            if "RMC," in line:
                list = line.split(",")
                # list should now be a 2 dimensional array of locations
                break

 #       list = s.recv(4096).split(",")
         #picks out 1st, 2nd and (for lon) 3rd character of the lat/lon
        lat = (d.Decimal(list[3][0] + list[3][1]) + d.Decimal(list[3][2:len(list[3])])/60)
        lon = (d.Decimal(list[5][0]+list[5][1]+list[5][2]) + d.Decimal(list[5][3:len(list[5])])/60)
        #flips lat/long                                                                                                    
        if list[4].upper() == "S":
            lat = -1 * lat

        if list[6].upper() == "W":
            lon = -1 * lon

        currentPosition = lat,lon
        s.close()
        #valve is open
        #Compares distance to port and asks to close if too close
        open = True
        for x in listOfPorts:
            port = d.Decimal(x[0]),d.Decimal(x[1])
            distanceToPort = haversine.distance(currentPosition,port)
            if distanceToPort < d.Decimal(x[2]):
                open = False
#            if distanceToPort > d.Decimal(x[2]):
#                open = True
#            print x[3],distanceToPort

        #opens valve
        if open == True and lastState != "True":
            print "Opening Valve"
            lastState = "True"
            valve.open_evsco_valve()

        #closes valve
        if open == False and lastState != "False":
            print "Closing Valve"
            lastState = "False"
            valve.close_evsco_valve()
            
    #if socket can't connect
    except:
        print "Something aint right\n"
#        sys.exit(0)
#        pass
        if lastState != "unk" or firstStart == "True":
            valve.open_evsco_valve()
            lastState = "unk"
            firstStart = "False"


