<?php
require_once 'config.php';
$key= filter_input(INPUT_POST, 'key');
$userToken = filter_input(INPUT_POST, 'userToken');
$userBlocked = filter_input(INPUT_POST, 'userBlocked');
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

        $db->where('userId',$userSelected['id']);
        $db->where('userBlocked',$userBlocked);
        if ($db->delete('usersblocked')){
            $results['result'] = 1;
        }else{
            $results['result'] = 3; //Engel Kaldırılamadı
        }

    }
}
echo json_encode($results);