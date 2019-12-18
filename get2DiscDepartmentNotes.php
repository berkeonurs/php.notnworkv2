<?php
require_once 'config.php';
include 'lib/functions.php';

$key= @$_GET['key'];
$userToken = @$_GET['userToken'];
$noteType = @$_GET['noteType'];
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
    if ($userSelected['userToken'] == $userToken){
        //Students Tablosu Sorgu
        $db->where('userId',$userSelected['id']);
        $studentSelectedArray = $db->get('students');
        $studentSelected = [];
        foreach ($studentSelectedArray as $key => $value){
            $studentSelected['departmentId'] = $value['departmentId'];
            $studentSelected['universityId'] = $value['universityId'];
        }
        //User Blocked Control
        $sub = $db->subQuery();
        $sub->where('userId',$userSelected['id']);
        $sub->get('usersblocked',null,'userBlocked');

        $sub2 = $db->subQuery();
        $sub2->where('userBlocked',$userSelected['id']);
        $sub2->get('usersblocked',null,'userId');

        $page = $_GET['page'];
        $db->groupBy ("noteId");
        $db->join('users u','n.userId=u.id','INNER');
        $db->join('notesimages i','n.noteId=i.notesId','INNER');
        $db->Where('noteType',$noteType);
        $db->Where('departmentId',$studentSelected['departmentId']);
        $db->where('universityId',$studentSelected['universityId']);
        $db->where (null, $sub, 'not exists');
        $db->where (null, $sub2, 'not exists');
        $db->pageLimit = 10;
        $notesList = $db->arraybuilder()->paginate("notes n", $page);
        $note = makeArray($notesList,'noteId',['id','imageUrl','noteId']);
        $results = $note;

    }


}
echo json_encode($results);
