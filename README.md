# notnwork v2.0
notnwork WebService
# USER
## Create User
 
| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| createUser.php | `POST` | {'key':'1453', 'which':'student, 'userName':'Berke Onur', 'userLastName':'Süneçli', 'userMail':berke@ogr.edu.tr, 'userPass':"123", 'userPhone': 055555555, 'studentClass': 2, 'departmentId':1 } | {'result':1 => User Created Successfully, 'result':305 => Account Already Exists, 'result':300 => Not a student mail} | Create a new Student User. |

## Login User
 
| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| loginUser.php | `POST` | {'key':'1453', 'userMail':berke@ogr.edu.tr, 'userPass':"123"} | {'result':1 => Active User, 'result':400 => Banned User, 'result':404 => Unknown User} | Login User. |

# NOTES
## Add Notes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| addNotes.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'noteTitle':"Fizik 1 Vize Notu", 'noteLesson':"Fizik 1", 'noteDesc':"Fizik 1 Son hafta vize notları", 'noteType':"Vize", 'noteTeacherName':"Kaan Manisa", 'departmentID': 1, "noteActive":1 or 2, $_FILES['img']} | {'result':1 => Notes Added Succesfully, 'result':26 => Not Image, 'result':33 => No Images Selected, 'result':0  => Key or Token Failed} | Add Notes. |

## Get Home Notes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getHomeNotes.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb} | {'result':0  => Key or Token Failed} | Get Home Notes. |
 
