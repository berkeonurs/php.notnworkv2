<?php
require_once 'config.php';

$key= filter_input(INPUT_POST, 'key');
$results = ['result'=>0];

if ($key == '1453' && $_SERVER['REQUEST_METHOD'] == 'POST'){
    //DB Bağlantısı
    $db = getDbInstance();

    $data = array_filter($_POST);
    // Users Tablosu Sorgu
    $db->where("userMail",$data['userMail']);
    $userSelected = $db->getOne("users");

    if ($userSelected['userMail'] == $data['userMail'] && $userSelected['userPass'] == md5($data['userPass'])){
        if ($userSelected['userActive'] == 0){
            $results['result'] = 400; // Banned User
            $results['active'] = $userSelected['userActive'];
        }else{
            $results['result'] = 1;
            $results['token'] = $userSelected['userToken'];
            $results['active'] = $userSelected['userActive'];
            $loginDate['userLoginDate'] = date('Y.m.d');
            $db->where("userToken",$userSelected['userToken']);
            $db->update('users',$loginDate);

        }
    }else{
        $results['result'] = 404; // Unknown User
    }
}

echo json_encode($results);