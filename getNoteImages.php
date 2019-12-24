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

        $db->where('notesId',$noteId);
        $noteImageArray = $db->get('notesimages',null,'imageUrl');
        $results = $noteImageArray;
    }
}

echo json_encode($results);