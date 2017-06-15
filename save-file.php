<?php
  $imagePath = "temp/";

if($_FILES['img']['size'] <= 10485760) {

    $allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
    $temp = explode(".", $_FILES["img"]["name"]);
    $extension = end($temp);

    if(!is_writable($imagePath)){
        		$response = Array(
        			"status" => 'error',
        			"message" => 'Can`t upload File; no write Access'
        		);
        		print json_encode($response);
        		return;
    }

	  if ( in_array($extension, $allowedExts)) {
	     if ($_FILES["img"]["error"] > 0) {
      			 $response = array(
      				"status" => 'error',
      				"message" => 'ERROR Return Code: '. $_FILES["img"]["error"],
      			);
		   } else {
	       $filename = $_FILES["img"]["tmp_name"];
         $exif = exif_read_data($filename);
               if (isset($exif['Orientation']))
               {
                   switch ($exif['Orientation'])
                   {
                       case 3:
                           // Need to rotate 180 deg
                           $source = imagecreatefromjpeg($filename);
                           $rotate = imagerotate($source, -180, 0);
                           imagejpeg($rotate, $filename);
                           break;

                       case 6:
                           // Need to rotate 90 deg clockwise
                           $source = imagecreatefromjpeg($filename);
                           $rotate = imagerotate($source, -90, 0);
                           imagejpeg($rotate, $filename);
                           break;

                       case 8:
                           // Need to rotate 90 deg counter clockwise
                           $source = imagecreatefromjpeg($filename);
                           $rotate = imagerotate($source, 90, 0);
                           imagejpeg($rotate, $filename);
                           break;
                   }
               }

    		  list($width, $height) = getimagesize( $filename );

    		  move_uploaded_file($filename,  $imagePath . $_FILES["img"]["name"]);

    		  $response = array(
    			"status" => 'success',
    			"url" => $imagePath.$_FILES["img"]["name"],
    			"width" => $width,
    			"height" => $height
    		  );
        }
     } else  {
    	   $response = array(
    			"status" => 'error',
    			"message" => 'something went wrong, most likely file is to large for upload. check upload_max_filesize, post_max_size and memory_limit in you php.ini',
    		);
	  }
} else {
          $response = array(
              "status" => 'error',
              "message" => 'Le fichier excède 10Mo.',
          );
}

print json_encode($response);

?>
