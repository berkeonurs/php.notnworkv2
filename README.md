# notnwork v2.0
'Notnwork' web services for the enthusiast.

[Create User](https://github.com/berkeonurs/notnworkv2#create-user)

[Login User](https://github.com/berkeonurs/notnworkv2#login-user)

[Get User Info](https://github.com/berkeonurs/notnworkv2#get-user-info)

[Get Other User Info](https://github.com/berkeonurs/notnworkv2#get-other-user-info)

[Get User Download Notes](https://github.com/berkeonurs/notnworkv2#get-user-download-notes)

[Get User Upload Notes](https://github.com/berkeonurs/notnworkv2#get-user-upload-notes)

[Block User](https://github.com/berkeonurs/notnworkv2#block-user)

[UnBlock User](https://github.com/berkeonurs/notnworkv2#unblock-user)

[Get User Block List](https://github.com/berkeonurs/notnworkv2#get-user-block-list)

[Follow User](https://github.com/berkeonurs/notnworkv2#follow-user)

[UnFollow User](https://github.com/berkeonurs/notnworkv2#unfollow-user)

[Change Password](https://github.com/berkeonurs/notnworkv2#change-password)

[Update Profile Photo](https://github.com/berkeonurs/notnworkv2#update-profile-photo)

[Get User Wallet Info](https://github.com/berkeonurs/notnworkv2#get-user-wallet-info)

[User Department Change](https://github.com/berkeonurs/notnworkv2#user-department-change)

[Get User Follow List](https://github.com/berkeonurs/notnworkv2#get-user-follow-list)

[Add Notes](https://github.com/berkeonurs/notnworkv2#add-notes)

[Get Home Notes](https://github.com/berkeonurs/notnworkv2#get-home-notes)

[Get Discovery Notes](https://github.com/berkeonurs/notnworkv2#get-discovery-notes)

[Get Department Discovery Notes](https://github.com/berkeonurs/notnworkv2#get-department-discovery-notes)

[Get Note Info](https://github.com/berkeonurs/notnworkv2#get-note-info)

[Download Notes](https://github.com/berkeonurs/notnworkv2#download-notes)

[Likes Notes](https://github.com/berkeonurs/notnworkv2#likes-notes)

[Get Note Likes](https://github.com/berkeonurs/notnworkv2#get-note-likes)

[Get Archive Note Info](https://github.com/berkeonurs/notnworkv2#get-archive-note)

[Get All Departments List](https://github.com/berkeonurs/notnworkv2#get-all-departments-list)

[Delete Note](https://github.com/berkeonurs/notnworkv2#delete-note)

[Add Product](https://github.com/berkeonurs/notnworkv2#add-product)

[Get Discovery Product](https://github.com/berkeonurs/notnworkv2#get-discovery-product)

# USER
## Create User
 
| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| createUser.php | `POST` | {'key':'1453', 'which':'student, 'userName':'Berke Onur', 'userLastName':'Süneçli', 'userMail':berke@ogr.edu.tr, 'userPass':"123", 'userPhone': 055555555, 'studentClass': 2, 'departmentId':1 } | {'result':1 => User Created Successfully, 'result':305 => Account Already Exists, 'result':300 => Not a student mail} | Create a new Student User. |

## Login User
 
| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| loginUser.php | `POST` | {'key':'1453', 'userMail':berke@ogr.edu.tr, 'userPass':"123"} | {'result':1 => Active User, 'result':400 => Banned User, 'result':404 => Unknown User} | Login User. |

## Get User Info

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getUserInfo.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb} | {'result':0  => Key or Token Failed} | Get User Info. |

## Get Other User Info

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getOtherUserInfo.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'userId':41} | {'result':0  => Key or Token Failed} | Get Other User Info. |

## Get User Download Notes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getUserDownload.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb} | {'result':0  => Key or Token Failed} | Get User Download Notes. |

## Get User Upload Notes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getUserUpload.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb} | {'result':0  => Key or Token Failed} | Get User Upload Notes. |

## Block User
 
| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| usersBlock.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'userBlocked':"41"=>engellenen kullanıcının idsi"} | {'result':1 => User Blocked Successfully, 'result':0  => Key or Token Failed} | Block User. |

## UnBlock User
 
| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| usersUnBlock.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'userBlocked':"41"=>engellenen kullanıcının idsi"} | {'result':1 => User UnBlocked Successfully, 'result':0  => Key or Token Failed} | UnBlock User. |

## Get User Block List

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getUserBlockList.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb} | {'result':0  => Key or Token Failed} | Get User Block List. |

## Follow User
 
| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| usersFollow.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'userFollowed':"41"=>takip edilen kullanıcının idsi"} | {'result':1 => User Followed Successfully, 'result':0  => Key or Token Failed} | Follow User. |

## UnFollow User
 
| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| usersUnFollow.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'userFollowed':"41"=>takipten çıkarılacak kullanıcının idsi"} | {'result':1 => User UnFollowed Successfully, 'result':0  => Key or Token Failed} | UnFollow User. |

## Get User Follow List

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getUserFollowList.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb} | {'result':0  => Key or Token Failed} | Get User Follow List. |

## Get User List

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getUsersList.php | `GET` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'page':'pagenumber'} | {'result':0  => Key or Token Failed} | Get User Info. |

## Change Password

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| userChangePass.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'oldPass':'eski şifre', 'newPass':'yenişifre'} | {'result':0  => Key or Token Failed, 'result':40 => Eski Şifre Doğru Değil, 'result':500 => Database Hatası, 'result':1 => Şifre Değiştirme Başarılı} | User Change Password. |

## Update Profile Photo

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| userUpdatePhoto.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'img[]':'base64 img'} | {'result':0  => Key or Token Failed, 'result':26 => Gelen Resim Değil, 'result':33 => Resim Seçilmedi, 'result':1 => Fotoğraf Güncelleme Başarılı} | Update Profile Photo. |

## Get User Wallet Info

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getUserWallet.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb} | {'result':0  => Key or Token Failed} | Get User Wallet Info. |

## User Department Change

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| userUpdateDep.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'departmentId':'bölüm id'} | {'result':0  => Key or Token Failed} | User Department Change. |

# NOTES
## Add Notes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| addNotes.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'noteTitle':"Fizik 1 Vize Notu", 'noteLesson':"Fizik 1", 'noteDesc':"Fizik 1 Son hafta vize notları", 'noteType':"Vize", 'noteTeacherName':"Kaan Manisa", 'departmentID': 1, "noteActive":1 or 2, $_FILES['img']} | {'result':1 => Notes Added Succesfully, 'result':26 => Not Image, 'result':33 => No Images Selected, 'result':0  => Key or Token Failed} | Add Notes. |

## Add 2 Notes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| addNotes2.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'noteTitle':"Fizik 1 Vize Notu", 'noteLesson':"Fizik 1", 'noteDesc':"Fizik 1 Son hafta vize notları", 'noteType':"Vize", 'noteTeacherName':"Kaan Manisa", 'departmentID': 1, "noteActive":1 or 2, $_FILES['img']} | {'result':1 => Notes Added Succesfully, 'result':26 => Not Image, 'result':33 => No Images Selected, 'result':0  => Key or Token Failed} | Add Notes. |

## Get Home Notes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getHomeNotes.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb} | {'result':0  => Key or Token Failed, 'result':404 => Doesn't Follow Any Users} | Get Home Notes. |

## Get 2 Home Notes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| get2HomeNotes.php | `GET` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'page':'pagenumber'} | {'result':0  => Key or Token Failed, 'result':404 => Doesn't Follow Any Users} | Get Home Notes. |

## Get Discovery Notes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getDiscNotes.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'noteType':'Vize or Final'} | {'result':0  => Key or Token Failed} | Get Discovery Notes |

## Get 2 Discovery Notes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| get2DiscNotes.php | `GET` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'noteType':'Vize or Final', 'page':'pagenumber'} | {'result':0  => Key or Token Failed} | Get Discovery Notes |

## Get Department Discovery Notes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getDiscDepartmentNotes.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'noteType':'Vize or Final'} | {'result':0  => Key or Token Failed} | Get Department Discovery Notes |

## Get 2 Department Discovery Notes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| get2DiscDepartmentNotes.php | `GET` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'noteType':'Vize or Final', 'page':'pagenumber'} | {'result':0  => Key or Token Failed} | Get Department Discovery Notes |

## Get Note Info

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getNoteInfo.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'noteId':'139'} | {'result':0  => Key or Token Failed} | Get Note Info |

## Download Notes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| downloadNotes.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'notesId':'145'} | {'result':0  => Key or Token Failed, 'result':20 => Note Owner Download Failed, 'result':1 => Note Download Succesfully} | Download Notes. |
 
## Likes Notes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| likesNotes.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'noteId':'145', 'likeType':'like' or 'dislike'} | {'result':0  => Key or Token Failed, 'result':1 => Note Like or Dislike Succesfully} | Likes Notes. | 

## Get Note Likes

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getNoteLikes.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'noteId':'145'} | {'result':0  => Key or Token Failed} | Get Note Likes Info. | 

## Get Achive Note

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getArchiveNotes.php | `POST` | {'key':'1453', 'universityId':'1'} | {'result':0  => Key Failed} | Get Archive Note Info |

## Get All Departments List

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getAllDepartments.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb} | {'result':0  => Key or Token Failed} | Get All Departments List. | 

## Delete Note

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| deleteNote.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb,'noteId':'silinecek notun idsi'} | {'result':0  => Key or Token Failed, 'result':1 => Note Delete Successfully} | Delete Note. | 

# Product
## Add Product
| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| addProduct.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'ProductTitle':"Hesap Makinesi", 'productPrice':"10", 'productDesc':"Hesap Makinesi", 'noteType':"Hesap Makinesi", $_FILES['img']} | {'result':1 => Product Added Succesfully, 'result':26 => Not Image, 'result':33 => No Images Selected, 'result':0  => Key or Token Failed} | Add Product. |

## Get Discovery Product

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getDiscProduct.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb} | {'result':0  => Key or Token Failed} | Get Discovery Products |

## Get Product Info

| Route | HTTP Verb | POST body | Result | Description |
| --- | --- | --- | --- | --- |
| getProductInfo.php | `POST` | {'key':'1453', 'userToken':5ebe96fc8d7e896f3b15adbe2941b0fb, 'productId':'139'} | {'result':0  => Key or Token Failed} | Get Product Info |
