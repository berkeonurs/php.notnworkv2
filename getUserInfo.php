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

        $db->join('students s','u.id=s.userId','INNER');
        $db->join('department d','s.departmentId=d.departmentId','INNER');
        $db->join('university c','s.universityId=c.universityId','INNER');
        $db->where('id',$userSelected['id']);
        $userInfo = $db->get('users u',null,'u.userName,u.userLastName,u.userPhoto,u.userCreateDate,u.userLoginDate,u.userActive,s.studentId,s.userId,s.studentClass,s.universityId,s.departmentId,d.departmentName,c.universityName,c.universityPhoto');
        $results = $userInfo;
    }
}
echo json_encode($results);