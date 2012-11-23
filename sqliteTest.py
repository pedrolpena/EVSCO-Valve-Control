import sqlite3
conn = sqlite3.connect("portLocations.db")
cursor = conn.cursor()
sql = "SELECT lat,lon FROM port_locations"
rows = cursor.execute(sql)

for x in rows:
    print x[0],x[1]


#print cursor.fetchall()
