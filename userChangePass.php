<?php
require_once 'config.php';
$key= filter_input(INPUT_POST, 'key');
$userToken = filter_input(INPUT_POST, 'userToken');
$oldPass = filter_input(INPUT_POST, 'oldPass');
$newPass = filter_input(INPUT_POST, 'newPass');
$results = ['result'=>0];

if ($key == '1453' &&  $_SERVER['REQUEST_METHOD'] == 'POST' && isset($userToken)) {
    //DB Bağlantısı
    $db = getDbInstance();


    //User Tablosu Sorgu
    $db->where('userToken', $userToken);
    $userSelectedArray = $db->get('users');
    $userSelected = [];
    foreach ($userSelectedArray as $k => $v){
        $userSelected['userToken'] = $v['userToken'];
        $userSelected['id'] = $v['id'];
        $userSelected['oldPass'] = $v['userPass'];
    }

    if ($userSelected['oldPass'] == md5($oldPass)){
        $datas['userPass'] = md5($newPass);
        $db->where('id',$userSelected['id']);
        if ($db->update('users',$datas)){
            $results['result'] = 1;
        }else{
            $results['result'] = 500; //Database Hatası
        }

    }else{
        $results['result'] = 40; // Eski Şifre Doğru Değil
    }


}
echo json_encode($results);
