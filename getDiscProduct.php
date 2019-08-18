<?php
require_once 'config.php';
include 'lib/functions.php';

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

        $sub = $db->subQuery();
        $sub->where('userId',$userSelected['id']);
        $sub->get('usersblocked',null,'userBlocked');

        $sub2 = $db->subQuery();
        $sub2->where('userBlocked',$userSelected['id']);
        $sub2->get('usersblocked',null,'userId');

        $db->join('users u','p.userId=u.id','INNER');
        $db->join('productimage i','p.productId=i.productsId','INNER');
        $db->where (null, $sub, 'not exists');
        $db->where (null, $sub2, 'not exists');
        $notesList = $db->get('product p',null,'p.productId,p.userId,p.productTitle,p.productPrice,p.productDesc,p.productType,p.productDate,i.id,i.imageUrl,i.productsId,u.userName,u.userLastName,u.userPhoto');
        $note = makeArray($notesList,'productId',['id','imageUrl','productsId']);
        $results = $note;
    }
}
echo json_encode($results);
