<?php
require_once 'config.php';
include 'lib/functions.php';

$key= @$_GET['key'];
$userToken = @$_GET['userToken'];
$results = ['result'=>0];

if ($key == '1453' && isset($userToken)) {
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

    $db->where('userId',$userSelected['id']);
    $studentSelectedArray = $db->get('students');
    $studentSelected = [];
    foreach ($studentSelectedArray as $keys => $values){
        $studentSelected['universityId'] = $values['universityId'];
        $studentSelected['departmentId'] = $values['departmentId'];
        $studentSelected['studentClass'] = $values['studentClass'];
    }


    if ($userSelected['userToken'] == $userToken){

        $data['userId'] = $userSelected['id'];
        $db->where('userId',$userSelected['id']);
        $userFollowList = $db->get('usersfollow',null,'userFollowed');
        $userFollowIdList = [];
        if ($db->count > 0){
            foreach ($userFollowList as $key => $value){
                $userFollowIdList[] += $value['userFollowed'];
            }
            $userFollowIdList[] += $userSelected['id'];
            $userId = $userSelected['id'];
            $studentUniversityId = $studentSelected['universityId'];


            $page = $_GET['page'];
            $sub = $db->subQuery();
            $sub->where('userId',$userId);
            $sub->get('usersfollow',null,'userFollowed');

            $db->orderBy('n.noteId','DESC');
            $db->groupBy('n.noteId');
            $db->join('department d','n.departmentId=d.departmentId','INNER');
            $db->join('notesimages i','n.noteId=i.notesId','INNER');
            $db->join('users u','n.userId=u.id','INNER');
            $db->where('n.userId',$sub,'in');
            $db->where('n.universityId',$studentUniversityId);
            $db->pageLimit = 3;
            $notesList = $db->arraybuilder()->paginate("notes n", $page);
            $note = makeArray($notesList,'noteId',['id','imageUrl','noteId']);
            $results = $note;


        }else{
            $results['result'] = 404; // Takip Ettiği kişi yok
        }



    }

}

echo json_encode($results);
