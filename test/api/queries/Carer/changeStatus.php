<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Carer.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $code = $data->code;
  $status = $data->status;
  // echo $code;
  $carer = new Carer;
  $resp = $carer->changeStatus($code,$status);
  echo $resp;

 ?>
