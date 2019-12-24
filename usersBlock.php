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

        $data['userId'] = $userSelected['id'];
        $db->insert('usersblocked',$data);

        //Follow Kontrol
        $db->where('userId',$userSelected['id']);
        $db->where('userFollowed',$userBlocked);
        $followCheck = $db->get('usersfollow');
        $followCheckCount = $db->count;
        if ($followCheckCount > 0) {
            $db->where('userId', $userSelected['id']);
            $db->where('userFollowed', $userBlocked);
            $db->delete('usersfollow');

            $db->where('userId',$userBlocked);
            $db->where('userFollowed',$userSelected['id']);
            $db->get('usersfollow');
            $checkCount = $db->count;

            if ($checkCount > 0){
                $db->where('userId', $userBlocked);
                $db->where('userFollowed', $userSelected['id']);
                $db->delete('usersfollow');
            }
            $dataProgress = [
                "userId" => $userSelected['id'],
                "progressType" => "unfollow_user",
                "progressId" => 3,
                "coin" => -10,
                "money" => 0
            ];
        }
        $results['result'] = 1;

    }
}
echo json_encode($results);
