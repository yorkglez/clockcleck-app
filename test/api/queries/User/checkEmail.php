<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/User.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $email = $data->email;
  $user = new User;
  $resp = $user->checkEmail($email);
  echo $resp;

?>
