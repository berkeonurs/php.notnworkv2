<?php
require_once 'config.php';

$key= filter_input(INPUT_POST, 'key');
$results = ['result'=>0];

if ($key == '1453' &&  $_SERVER['REQUEST_METHOD'] == 'POST'){
    //DB Bağlantısı
    $db = getDbInstance();

        $departments = $db->get('department');
        $results = $departments;

}
echo json_encode($results);
