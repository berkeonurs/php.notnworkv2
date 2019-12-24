<?php
require_once 'config.php';
require_once 'lib/functions.php';
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
        $db->where('noteId',$noteId);
        $noteArray = $db->get('notes');
        foreach ($noteArray as $noteKey => $noteValue){
            $noteUserId = $noteValue['userId'];
        }
        if ($noteUserId == $userSelected['id']){
            $db->where('noteId',$noteId);
            $db->delete('notes');
            $userIp = getIP();
            $dataProgress = [
                "userId" => $userSelected['id'],
                "progressType" => "delete_notes",
                "progressId" => 3,
                "coin" => -50,
                "money" => 0,
                "userIp" => $userIp
            ];
            $db->insert('usersprogress',$dataProgress);
            $results['result'] = 1;
        }else{
            $results['result'] = 40; //Not Sahibi değil
        }
    }
}
echo json_encode($results);
