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

        $db->join('notesimages i','n.noteId=i.notesId');
        $db->where('userId',$userSelected['id']);
        $uploadNote = $db->get('notes n');
        $getUploadNote =  makeArray($uploadNote,'noteId',['id','imageUrl','noteId']);
        $results = $getUploadNote;

    }
}
echo json_encode($results);