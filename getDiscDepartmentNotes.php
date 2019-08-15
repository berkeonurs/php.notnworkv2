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

        $db->join('users u','n.userId=u.id','INNER');
        $db->join('notesimages i','n.noteId=i.noteId','INNER');
        $db->Where('noteType',$noteType);
        $db->Where('departmentId',$studentSelected['departmentId']);
        $notesList = $db->get('notes n');
        $note = makeArray($notesList,'noteId',['id','imageUrl','noteId']);
        $results = $note;

    }


}
echo json_encode($results);