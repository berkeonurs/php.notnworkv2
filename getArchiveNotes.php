<?php
require_once 'config.php';
include 'lib/functions.php';

$key= filter_input(INPUT_POST, 'key');
$universityId = filter_input(INPUT_POST, 'universityId');
$results = ['result'=>0];

if ($key == '1453' &&  $_SERVER['REQUEST_METHOD'] == 'POST') {
    //DB Bağlantısı
    $db = getDbInstance();

    $data = array_filter($_POST);

    $db->join('users u','n.userId=u.id','INNER');
    $db->join('notesimages i','n.noteId=i.notesId','INNER');
    $db->Where('universityId',$universityId);
    $notesList = $db->get('notes n',null,'n.noteId,n.noteTitle,n.noteLesson,n.noteDesc,n.noteType,n.noteDate,n.noteTeacherListId,n.noteTeacherName,n.departmentId,n.noteActive,n.universityId,i.id,i.imageUrl,i.notesId,u.userName,u.userLastName,u.userPhoto');
    $note = makeArray($notesList,'noteId',['id','imageUrl','noteId']);
    $results = $note;
}

echo json_encode($results);