<?php
require_once 'config.php';
$key= filter_input(INPUT_POST, 'key');
$userToken = filter_input(INPUT_POST, 'userToken');
$userFollowed = filter_input(INPUT_POST, 'userFollowed');
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
        $db->where('userFollowed',$userFollowed);
        $db->delete('usersfollow');
        $dataProgress = [
            "userId" => $userSelected['id'],
            "progressType" => "unfollow_user",
            "progressId" => 3,
            "coin" => -10,
            "money" => 0
        ];
        $db->insert('usersprogress',$dataProgress);
        $results['result'] = 1;
    }
}
echo json_encode($results);
