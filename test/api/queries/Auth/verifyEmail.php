<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Auth.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $email = $data->email;
  echo $email;

  $auth = new Auth;
  $resp = $auth->verifyEmail($email);
  echo $resp;
 ?>
