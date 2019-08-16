<?php
require_once 'config.php';
include 'lib/functions.php';

$key= filter_input(INPUT_POST, 'key');
$userToken = filter_input(INPUT_POST, 'userToken');
$noteType = filter_input(INPUT_POST, 'noteType');
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
    if ($userSelected['userToken'] == $userToken){
        unset($data['key']);
        unset($data['userToken']);
        //Students Tablosu Sorgu
        $db->where('userId',$userSelected['id']);
        $studentSelectedArray = $db->get('students');
        $studentSelected = [];
        foreach ($studentSelectedArray as $key => $value){
            $studentSelected['departmentId'] = $value['departmentId'];
        }
        //User Blocked Control
        $sub = $db->subQuery();
        $sub->where('userId',$userSelected['id']);
        $sub->get('usersblocked',null,'userBlocked');

        $sub2 = $db->subQuery();
        $sub2->where('userBlocked',$userSelected['id']);
        $sub2->get('usersblocked',null,'userId');


        $db->join('users u','n.userId=u.id','INNER');
        $db->join('notesimages i','n.noteId=i.noteId','INNER');
        $db->Where('noteType',$noteType);
        $db->Where('departmentId',$studentSelected['departmentId']);
        $db->where (null, $sub, 'not exists');
        $db->where (null, $sub2, 'not exists');
        $notesList = $db->get('notes n',null,'n.noteId,n.userId,n.noteTitle,n.noteLesson,n.noteDesc,n.noteType,n.noteDate,n.noteTeacherListId,n.noteTeacherName,n.departmentId,n.noteActive,i.id,i.imageUrl,i.noteId,u.userName,u.userLastName,u.userPhoto');
        $note = makeArray($notesList,'noteId',['id','imageUrl','noteId']);
        $results = $note;

    }


}
echo json_encode($results);