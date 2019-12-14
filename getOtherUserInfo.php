<?php
require_once 'config.php';
$key= filter_input(INPUT_POST, 'key');
$userToken = filter_input(INPUT_POST, 'userToken');
$userId = filter_input(INPUT_POST, 'userId');
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

        $db->join('students s','u.id=s.userId','INNER');
        $db->join('department d','s.departmentId=d.departmentId','INNER');
        $db->join('university c','s.universityId=c.universityId','INNER');
        $db->where('id',$userId);
        $userInfo = $db->get('users u',null,'u.userName,u.userLastName,u.userPhoto,u.userCreateDate,s.studentId,s.userId,s.studentClass,s.universityId,s.departmentId,d.departmentName,c.universityName,c.universityPhoto');
        $results['info'] = $userInfo;

        $db->join('users u','f.userFollowed=u.id','LEFT');
        $db->where('f.userId',$userId);
        $following = $db->get('usersfollow f');
        $results['following'] = $following;
        $results['following']['count'] = $db->count;

        $db->join('users u','f.userId=u.id','LEFT');
        $db->where('f.userFollowed',$userId);
        $followers = $db->get('usersfollow f');
        $results['followers'] = $followers;
        $results['followers']['count'] = $db->count;

        $results['result'] = 1;
    }
}
echo json_encode($results);
