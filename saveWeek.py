#!/usr/bin/python

import sys
import mysql.connector

mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="",
    database="felstedreq"
)

date = sys.argv[1]+sys.argv[2][:8].replace("/", ".")+"-"+sys.argv[2][8:].replace("/", ".")
lessonquery = "SELECT * from lesson WHERE teacher_id IN (SELECT DISTINCT teacher_id from lesson WHERE subject='CHEM') AND week='"+sys.argv[1]+"';"
db = mydb.cursor()
db.execute(lessonquery)
lessons = db.fetchall()
list_lessons=[]


filelocation="history\\"+date+".sql"
f = open(filelocation,'x')

f.write("DELETE FROM history_requisition;")
f.write("DELETE FROM history_lesson;\")

for lesson in lessons:
   list_lessons.append(lesson[6])
   f.write("INSERT INTO history_lesson VALUES"+str(lesson)+";")

requisitionquery = "SELECT * FROM requisition WHERE lesson_id IN ("+','.join(map(str, list_lessons))+");"
db.execute(requisitionquery)
reqs = db.fetchall()

for req in reqs:
    f.write("INSERT INTO history_requisition VALUES"+str(req)+";")

f.close()

f = open("/var/www/main/history.php", 'w')

weekOption = "<form class='historyLink' method='GET' action=''>\
<input type='hidden' name='view' value='"+date+"'/><input type=submit value='"+date+"'/>\
</form>"

f.write(weekOption+"\n")
f.close()

