<?php
  /*Includes*/
  require('../../Headers.php');
  $uploads_dir = 'C:/FingersServer'; //Directory to save the file that comes from client application.
  if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
    $tmp_name = $_FILES["file"]["tmp_name"];
    $name = $_FILES["file"]["name"];
    move_uploaded_file($tmp_name, "$uploads_dir/$name");
  }
 ?>
