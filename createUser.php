<?php
require_once 'config.php';

$key= filter_input(INPUT_POST, 'key');
$which = filter_input(INPUT_POST, 'which');
$results = ['result'=>0];

if ($key == '1453' && $_SERVER['REQUEST_METHOD'] == 'POST'){

    $db = getDbInstance();

    $data = array_filter($_POST);
    unset($data['key']);
    unset($data['studentClass']);
    unset($data['universityId']);
    unset($data['departmentId']);
    unset($data['which']);

    $data['userPass'] = md5($data['userPass']);

    $id = $db->insert ('users', $data);

    $dataStudent = array_filter($_POST);
    unset($dataStudent['key']);
    unset($dataStudent['userName']);
    unset($dataStudent['userLastName']);
    unset($dataStudent['userMail']);
    unset($dataStudent['userPass']);
    unset($dataStudent['userPhone']);
    unset($dataStudent['userPhoto']);
    unset($dataStudent['userToken']);
    unset($dataStudent['userActive']);
    if ($which == 'student'){
        $userId = "id";
        $dataStudent['userID'] = $id;
        unset($dataStudent['which']);

        $db->insert('students',$dataStudent);


    }

    $results['data']=$id;
    $results['result']=1;

}

echo json_encode($results);