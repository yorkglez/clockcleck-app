<?php
  /*Includes*/
  require('../../Headers.php');
  $file = json_decode(file_get_contents("php://input",true));
  $route = "C:/FingersServer/";
  unlink($route.$file."fpt");
?>
