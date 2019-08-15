<?php
require_once 'config.php';
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


        $db->join('users u','f.userFollowed=u.id','INNER');
        $db->where('userId',$userSelected['id']);
        $userFollowerList = $db->get('usersfollow f');
        $results['result'] = 1;
        $results['followers'] = $userFollowerList;
        $db->join('users u','f.userId=u.id','INNER');
        $db->where('userFollowed',$userSelected['id']);
        $userFollowingList = $db->get('usersfollow f');
        $results['following'] = $userFollowingList;



    }
}
echo json_encode($results);