<?php
require_once 'config.php';
require_once 'lib/upload.php';

$key= filter_input(INPUT_POST, 'key');
$userToken = filter_input(INPUT_POST, 'userToken');
$results = ['result'=>0];

if ($key == '1453' &&  $_SERVER['REQUEST_METHOD'] == 'POST' && isset($userToken)){
    //DB Bağlantısı
    $db = getDbInstance();

    $data = array_filter($_POST);

    //User Tablosu Sorgu
    $db->where('userToken',$userToken);
    $userSelected = $db->getOne('users');

    if ($userSelected['userToken'] == $userToken){
        unset($data['key']);
        unset($data['userToken']);
        $data['userId'] = $userSelected['id'];
        $id = $db->insert('notes',$data);
        if (isset($id)){

            $images = array();
            foreach ($_FILES['img'] as $k => $l) {
                foreach ($l as $i => $v) {
                    if (!array_key_exists($i, $images))
                        $images[$i] = array();
                    $images[$i][$k] = $v;
                }
            }


            $dataImg['noteId'] = $id;
            foreach ($images as $image){

                $handle = new Upload($image);
                if ($handle->uploaded) {
                    $rand = md5(uniqid(mt_rand(), true));
                    /* Resmi Yeniden Adlandır */
                    $handle->file_new_name_body = $rand;


                    /* Resim Yükleme İzni */
                    $handle->allowed = array('image/*');

                    /* Resmi İşle */
                    $handle->Process("upload/");
                    if ($handle->processed) {
                        $urlImg['imgResult'] = $rand.'.'.$handle->image_src_type;
                        $dataImg['imageUrl'] = returnUrl().$urlImg['imgResult'];
                        $db->insert('notesimages',$dataImg);
                        //UserProgress Coin Hediyesi
                        $dataProgress = [
                            "userId" => $userSelected['id'],
                            "progressType" => "new_notes",
                            "progressId" => 2,
                            "coin" => 100,
                            "money" => 0.3
                        ];
                        $db->insert('usersprogress',$dataProgress);
                        $results['result'] = 1;
                    } else {
                        $results['img'] = 26;
                        $db->where('id',$id);
                        $db->delete('notes');
                        $results['result'] = 26; // Gelen resim değil
                    }

                    $handle-> Clean();

                } else {
                    $results['img'] = 33;
                    $db->where('id',$id);
                    $db->delete('notes');
                    $results['result'] = 33; // Resim Seçilemedi
                }

            }


        }


    }

}
echo json_encode($results);