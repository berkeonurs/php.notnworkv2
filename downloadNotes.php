<?php
require_once 'config.php';
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

        $db->where('noteId',$noteId);
        $noteSelectedArray = $db->get('notes',null,'userId');
        foreach ($noteSelectedArray as $key => $value){
            $noteSelectedUserId = $value['userId'];
        }

        if ($noteSelectedUserId == $userSelected['id']){
            $results['result'] = 20; // Kendi Notu İndirilemez
        }else{
            unset($data['key']);
            unset($data['userToken']);
            $data['userId'] = $userSelected['id'];
            $db->insert('notesdownload',$data);
            $results['result'] = 1;
        }


    }
}

echo json_encode($results);