<?php
require_once 'config.php';
include 'lib/functions.php';

$key= filter_input(INPUT_POST, 'key');
$userToken = filter_input(INPUT_POST, 'userToken');
$results = ['result'=>0];

if ($key == '1453' &&  $_SERVER['REQUEST_METHOD'] == 'POST' && isset($userToken)) {
    //DB Bağlantısı
    $db = getDbInstance();

    $data = array_filter($_POST);

    //User Tablosu Sorgu
    $db->where('userToken', $userToken);
    $userSelectedArray = $db->get('users');
    $userSelected = [];
    foreach ($userSelectedArray as $k => $v){
        $userSelected['userToken'] = $v['userToken'];
        $userSelected['id'] = $v['id'];
    }

    $db->where('userId',$userSelected['id']);
    $studentSelectedArray = $db->get('students');
    $studentSelected = [];
    foreach ($studentSelectedArray as $keys => $values){
        $studentSelected['universityId'] = $values['universityId'];
        $studentSelected['departmentId'] = $values['departmentId'];
        $studentSelected['studentClass'] = $values['studentClass'];
    }


    if ($userSelected['userToken'] == $userToken){

        unset($data['key']);
        unset($data['userToken']);
        $data['userId'] = $userSelected['id'];
        $db->where('userId',$userSelected['id']);
        $userFollowList = $db->get('usersfollow',null,'userFollowed');
        $userFollowIdList = [];
        if ($db->count > 0){
            foreach ($userFollowList as $key => $value){
                $userFollowIdList[] += $value['userFollowed'];
            }
            $userFollowIdList[] += $userSelected['id'];
            $userId = $userSelected['id'];
            $studentUniversityId = $studentSelected['universityId'];

            //Notları Çek
//            $db->join('users u','n.userId=u.id','INNER');
//            $db->join('notesimages i','n.noteId=i.noteId','INNER');
//            $db->joinWhere('userId',$userFollowIdList);
//            $notesList = $db->get('notes n');
            $sorgu = "SELECT notes.noteId,notes.userId,notes.noteTitle,notes.noteLesson,notes.noteDesc,notes.noteType,notes.noteDate,notes.noteTeacherListId,notes.noteTeacherName,notes.departmentId,notes.noteActive,notesimages.id,notesimages.imageUrl,notesimages.notesId,users.userName,users.userLastName,users.userPhoto,department.departmentName FROM notes INNER JOIN department ON notes.departmentId = department.departmentId INNER JOIN notesimages ON notes.noteId = notesimages.notesId  INNER JOIN users ON notes.userId = users.id WHERE userId IN (SELECT userFollowed FROM usersfollow WHERE userId=$userId) AND universityId=$studentUniversityId GROUP BY notes.noteId ORDER BY notes.noteID DESC LIMIT 20";
            $notesList = $db->rawQuery($sorgu);

            $note = makeArray($notesList,'noteId',['id','imageUrl','noteId']);
            $results = $note;


        }else{
            $results['result'] = 404; // Takip Ettiği kişi yok
        }



    }

}

echo json_encode($results);
