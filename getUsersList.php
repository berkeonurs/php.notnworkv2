<?php
require_once 'config.php';
include 'lib/functions.php';

$key= @$_GET['key'];
$userToken = @$_GET['userToken'];
$results = ['result'=>0];

if ($key == '1453'  && isset($userToken)) {
    //DB Bağlantısı
    $db = getDbInstance();


    //User Tablosu Sorgu
    $db->where('userToken', $userToken);
    $userSelectedArray = $db->get('users');
    $userSelected = [];
    foreach ($userSelectedArray as $k => $v){
        $userSelected['userToken'] = $v['userToken'];
        $userSelected['id'] = $v['id'];
    }

    //Students Tablosu Sorgu
    $db->where('userId',$userSelected['id']);
    $studentSelectedArray = $db->get('students');
    $studentSelected = [];
    foreach ($studentSelectedArray as $key => $value){
        $studentSelected['departmentId'] = $value['departmentId'];
        $studentSelected['universityId'] = $value['universityId'];
    }

    if ($userSelected['userToken'] == $userToken){
        //takip etme etmeme durumunu joinle dene olmazsa subquery düşün (usersfollow)

        $userId = $userSelected['id'];
        $page=$_GET['page'];
//        //Followed
//        $sub = $db->subQuery();
//        $sub->where('userId',$userId);
//        $sub->get('usersfollow',null,'userFollowed');
//
//
//        $db->where('u.id',$sub,'in');
//        $db->pageLimit = 10;
//        $userArray['followed'] =$db->arraybuilder()->paginate("users u", $page);
//
//        //Not Followed
//        $sub2 = $db->subQuery();
//        $sub2->where('userId',$userId);
//        $sub2->get('usersfollow',null,'userFollowed');

        if (isset($_GET['all'])){
            //Kendi Profili Görüntülenmeme
            $sub3 = $db->subQuery();
            $sub3->where('id',$userId);
            $sub3->get('users',null,'id');

            //Sadece kendi üniversitesindeki üyeler
            $sub = $db->subQuery();
            $sub->where('universityId',$studentSelected['universityId']);
            $sub->get('students',null,'userId');


//
//        $db->where('u.id',$sub2,'not in');
            $db->where('u.id',$sub,'in');
            $db->where('u.id',$sub3,'not in');
            $userArray = $db->get('users u');

            $results = $userArray;
        }else{
            //Kendi Profili Görüntülenmeme
            $sub3 = $db->subQuery();
            $sub3->where('id',$userId);
            $sub3->get('users',null,'id');

            //Sadece kendi üniversitesindeki üyeler
            $sub = $db->subQuery();
            $sub->where('universityId',$studentSelected['universityId']);
            $sub->get('students',null,'userId');


//
//        $db->where('u.id',$sub2,'not in');
            $db->where('u.id',$sub,'in');
            $db->where('u.id',$sub3,'not in');
            $db->pageLimit = 10;
            $userArray = $db->arraybuilder()->paginate("users u", $page);

            $results = $userArray;
        }


    }
}
echo json_encode($results);
