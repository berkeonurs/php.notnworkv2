<?php
require_once 'config.php';
include 'lib/functions.php';

$key= filter_input(INPUT_POST, 'key');
$userToken = filter_input(INPUT_POST, 'userToken');
$noteId = filter_input(INPUT_POST, 'noteId');
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
        $db->join('users u','n.userId=u.id','INNER');
        $db->join('notesimages i','n.noteId=i.notesId','INNER');
        $db->Where('noteId',$noteId);
        $notesList = $db->get('notes n',null,'n.noteId,n.userId,n.noteTitle,n.noteLesson,n.noteDesc,n.noteType,n.noteDate,n.noteTeacherListId,n.noteTeacherName,n.departmentId,n.noteActive,i.id,i.imageUrl,i.notesId,u.userName,u.userLastName,u.userPhoto');
        $note = makeArray($notesList,'noteId',['id','imageUrl','noteId']);
        $results = $note;
    }
}
echo json_encode($results);