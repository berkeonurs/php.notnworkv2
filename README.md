# notnwork v2.0
notnwork WebService

# Create User
 
| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| /ws/createUser.php | `POST` | {'key':'1453', 'which':'student, 'userName':'Berke Onur', 'userLastName':'Süneçli', 'userMail':berke@ogr.edu.tr, 'userPass':"123", 'userPhone': 055555555, 'studentClass': 2, 'departmentId':1 } | {'result':1 => User Created Successfully, 'result':305 => Account Already Exists, 'result':300 => Not a student mail} | Create a new Student User. |

# Login User
 
| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| /ws/loginUser.php | `POST` | {'key':'1453', 'userMail':berke@ogr.edu.tr, 'userPass':"123"} | {'result':1 => Active User, 'result':400 => Banned User, 'result':404 => Unknown User} | Login User. |
 
