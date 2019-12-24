<?php
require_once 'config.php';

$key= filter_input(INPUT_POST, 'key');
$userToken = filter_input(INPUT_POST, 'userToken');
$results = ['result'=>0];

if ($key == '1453' &&  $_SERVER['REQUEST_METHOD'] == 'POST' && isset($userToken)){
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
        //Toplam Yüklenen Not Sayısı
        $db->where('userId',$userSelected['id']);
        $db->get('notes');
        $results['notesCount'] = $db->count;

        //Toplam Kazanç
        $db->where('userId',$userSelected['id']);
        $userProgressArray = $db->get('usersprogress');
        $toplamKazanc = 0;
        foreach ($userProgressArray as $progressKey => $progressValue){
            $toplamKazanc += $progressValue['coin'];
        }
        $results['notcoin'] = $toplamKazanc;

        $results['notcointotl'] = round($toplamKazanc/3500,2);

        $results['result'] = 1;
    }
}
echo json_encode($results);
