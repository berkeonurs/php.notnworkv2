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

    if ($userSelected['userToken'] == $userToken){
        unset($data['key']);
        unset($data['userToken']);


        $db->join('notesimages i','n.noteId=i.notesId','INNER');
        $db->where('n.userId',$userSelected['id']);
        $getUploadNote = $db->get('notes n');
        $uploadNote = makeArray($getUploadNote,'noteId',['id','imageUrl','noteId']);
        $results = $uploadNote;

    }
}
echo json_encode($results);
