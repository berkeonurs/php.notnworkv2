<?php
require_once 'config.php';

$key= filter_input(INPUT_POST, 'key');
$which = filter_input(INPUT_POST, 'which');
$results = ['result'=>0];

if ($key == '1453' && $_SERVER['REQUEST_METHOD'] == 'POST'){
    // DB Bağlantısı
    $db = getDbInstance();

    $data = array_filter($_POST);
    unset($data['key']);
    unset($data['studentClass']);
    unset($data['universityId']);
    unset($data['departmentId']);
    unset($data['which']);

    $data['userPass'] = md5($data['userPass']);
    $data['userToken'] = md5(base64_encode(rand(0,9999999999999)+rand(0,99999)+$data['userName']));
    $userMail = $data['userMail'];
    $mailCheckLast = explode("@",$userMail);
    $mailCheck = end($mailCheckLast);
    $mailList = [
        "1"=>"ogr.dpu.edu.tr",
        "2"=>"ogr.iu.edu.tr",
        "3"=>"stud.sdu.edu.tr",
        "4"=>"ogrenci.ogu.edu.tr",
        "5"=>"ogrenci.karabuk.edu.tr",
        "6"=>"ogr.mersin.edu.tr",
        "7"=>"ogr.mehmetakif.edu.tr"];
    if (in_array($mailCheck,$mailList)){
        $db->where("userMail",$data['userMail']);
        $mailSelected = $db->getOne("users");
        if ($mailSelected['userMail'] == $data['userMail']){
            $results['result'] = 305; // Account Already Exists
        }else{


        // Users Tablosuna Insert
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
        if ($which == 'student'){
            $university = array_search($mailCheck,$mailList);
            $dataStudent['userID'] = $id;
            $dataStudent['universityId'] = $university;
            unset($dataStudent['which']);
            // Student Tablosuna Insert
            $db->insert('students',$dataStudent);

        }

        $mailToken = md5(base64_encode($data['userName']+rand(0,999999)));
        $dataMail['mailToken'] = $mailToken;
        $dataMail['usersId'] = $id;
        // Mail Onay Tablosuna insert
        $db->insert('usersMailSuccess',$dataMail);

        sendMail($data['userMail'],$data['userName'],$id,$mailToken);


        //Oluşturulan Kullanıcının Tokeni
        $db->where("id",$id);
        $userSelected = $db->getOne("users");
        $results['token'] = $userSelected['userToken'];

        //UserProgress Coin Hediyesi
        $dataProgress = [
            "userId" => $id,
            "progressType" => "new_user",
            "progressId" => 1,
            "coin" => 10,
            "money" => 0
        ];
        $db->insert('usersProgress',$dataProgress);


        $results['data']=$id;
        $results['result']=1;
        }
    }else{
        $results['result'] = 300; //Not Student Mail
    }



}

echo json_encode($results);