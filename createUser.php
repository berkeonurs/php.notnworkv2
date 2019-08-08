<?php
require_once 'config.php';
include "lib/class.phpmailer.php";

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
    $data['userToken'] = md5(base64_encode(rand(0,9999999999999)+rand(0,99999)));
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

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug  = 1;
        $mail->Host = 'srvc75.turhost.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->Username = 'info@notnwork.com';
        $mail->Password = 'lmG3$S^N],J]';
        $mail->SetFrom($mail->Username, 'notnwork');
        $mail->AddAddress($data['userMail'],$data['userName']);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'notnwork Öğrenci Mail Onay';
        $content = '<div style="background: #eee; padding: 10px; font-size: 14px"><h3>Merhaba '.$data['userName'].'</h3><p>Mailini onaylamak için lütfen linke tıkla!</p><p>Onay Linki: <a href="https://notnwork.com/onay.php?eposta='.$id.'&kod='.$mailToken.'" target="_blank">Mailini onaylamak için buraya tıkla!</a></p><p>Eğer link çalışmıyorsa aşağıdaki bağlantıyı adres çubuğuna yapıştır!</p><p>https://notnwork.com/onay.php?eposta='.$id.'&kod='.$mailToken.'</p></div>';
        $mail->MsgHTML($content);
        if($mail->Send()) {
            $data['mail']="gönderildi";
        } else {
            // bir sorun var, sorunu ekrana bastıralım
            $data['mail'] = $mail->ErrorInfo;
        }

        //Oluşturulan Kullanıcının Tokeni
        $db->where("id",$id);
        $userSelected = $db->getOne("users");
        $results['token'] = $userSelected['userToken'];

        $results['data']=$id;
        $results['result']=1;
    }else{
        $results['result'] = 300; //Not Student Mail
    }



}

echo json_encode($results);