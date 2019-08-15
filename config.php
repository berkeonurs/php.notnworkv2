<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
header('Access-Control-Allow-Origin: *');

require_once 'lib/MysqliDb.php';
include "lib/class.phpmailer.php";

/*
|--------------------------------------------------------------------------
| DATABASE CONFIGURATION
|--------------------------------------------------------------------------
 */

define('DB_HOST', "localhost");
define('DB_USER', "root");
define('DB_PASSWORD', "");
define('DB_NAME', "notnworkv2");


/**
 * Get instance of DB object
 */
function getDbInstance() {
    return new MysqliDb(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}

function returnUrl(){
    return 'https://notnwork.com/notnworkv2/upload/';
}

function sendMail($userMail,$userName,$id,$mailToken){
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
    $mail->AddAddress($userMail,$userName);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'notnwork Öğrenci Mail Onay';
    $content = '<div style="background: #eee; padding: 10px; font-size: 14px"><h3>Merhaba '.$userName.'</h3><p>Mailini onaylamak için lütfen linke tıkla!</p><p>Onay Linki: <a href="https://notnwork.com/onay.php?eposta='.$id.'&kod='.$mailToken.'" target="_blank">Mailini onaylamak için buraya tıkla!</a></p><p>Eğer link çalışmıyorsa aşağıdaki bağlantıyı adres çubuğuna yapıştır!</p><p>https://notnwork.com/onay.php?eposta='.$id.'&kod='.$mailToken.'</p></div>';
    $mail->MsgHTML($content);
    if($mail->Send()) {
        $results['mail']="Success";
    } else {
        // bir sorun var, sorunu ekrana bastıralım
        $results['mail'] = $mail->ErrorInfo;
    }
}