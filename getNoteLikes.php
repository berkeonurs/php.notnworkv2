<?php
require_once 'config.php';
include 'lib/functions.php';
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

        $db->join('users u','l.usersId=u.id','INNER');
        $db->where('noteId',$noteId);
        $db->where('likeType','like');
        $getLikeNote = $db->get('noteslikes l',null,'l.id,l.usersId,l.noteId,l.likeDate,l.likeType,u.userName,u.userLastName,u.userPhoto');
        $count = $db->count;
        $results['like'] = $getLikeNote;
        $results['like']['count'] = $count;

        $db->join('users u','l.usersId=u.id','INNER');
        $db->where('noteId',$noteId);
        $db->where('likeType','dislike');
        $getDislikeNote = $db->get('noteslikes l',null,'l.id,l.usersId,l.noteId,l.likeDate,l.likeType,u.userName,u.userLastName,u.userPhoto');
        $count = $db->count;
        $results['dislike'] = $getDislikeNote;
        $results['dislike']['count'] = $count;

        $results['result'] = 1;

    }
}
echo json_encode($results);