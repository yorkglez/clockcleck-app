<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Auth.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $email = $data->email;
  $password = $data->password;
  $auth = new Auth;
  $resp = $auth->authTeacherDesk($email, $password);
  echo $resp;
 ?>
