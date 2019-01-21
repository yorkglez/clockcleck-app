<?php
  session_start();
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Auth.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $email = $data->email;
  $password = $data->password;
  $auth = new Auth;
  $resp = $auth->authTeacher($email, $password);
  echo $resp;
 ?>
