<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Extension.php');

  $data = json_decode(file_get_contents("php://input",true));
  $id = $data->id;
  $status = $data->status;
  $ex = new Extension;
  $resp = $ex->changeStatus($id,$status);
  echo $resp;

?>
