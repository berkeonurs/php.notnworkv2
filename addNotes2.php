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

        $img = $_POST['img'];

        unset($data['key']);
        unset($data['userToken']);
        unset($data['img']);
        $data['userId'] = $userSelected['id'];
        $id = $db->insert('notes',$data);
        if (isset($id)){

//            $images = array();
//            foreach ($img as $k => $l) {
//                foreach ($l as $i => $v) {
//                    if (!array_key_exists($i, $images))
//                        $images[$i] = array();
//                    $images[$i][$k] = $v;
//                }
//            }


            $dataImg['notesId'] = $id;
            foreach ($img as $image){

                $data = $image;

                $data = preg_replace('#^data:image/[^;]+;base64,#', '', $data);

                $data = str_replace(' ', '+', $data);

                $data = base64_decode($data);

                $code = md5(time());
                $write_dir = "upload/";
                $temp_code = "temp_".$code;

                $ifp = fopen($write_dir.$temp_code, "wb");
                fwrite($ifp, $data);
                fclose($ifp);


                $handle = new Upload($write_dir.$temp_code);
                if ($handle->uploaded) {
                    $rand = md5(uniqid(mt_rand(), true));
                    /* Resmi Yeniden Adlandır */
                    $handle->file_new_name_body = $rand;
                    $handle->file_new_name_ext = 'jpg';

                    /* Resim Yükleme İzni */
                    $handle->allowed = array('image/*');

                    /* Resim Uzantısını JPG Yap */
                    $handle->image_convert = 'jpg';
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
