 <?php

require_once "class.upload.php";
    
function imageUpload($upload) {
     
try {
  
  $upload->allowed = array('image/*');

  
  if($upload->uploaded){
	   
	  $rand = md5(uniqid(mt_rand(), true));
	  $upload->file_new_name_body = $rand; 
	  	 
			$upload->Process("upload/");
			 
	  
		    if($upload->processed){
							
				$upload->clean();
				return  $rand.'.'.$upload->image_src_type; // resim  kaydedildi
				    
				} 
			else{
				return 26; //  gelen resim değil
			}
			
 
  }
  else{
	  
	return  33;// fotoğraf seçerken bi hata oluştu
  }
  } 
  catch(PDOException $e) {
  return 37;  //  try cath hata fırlattı
}

}

