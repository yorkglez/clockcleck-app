<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Auth.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $email = $data->email;
  $type = $data->type;
  $auth = new Auth;
  $resp = $auth->resetPassword($email,$type);
  echo $resp;
 ?>
