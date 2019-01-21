<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Auth.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));

  $auth = new Auth;
  $resp = $auth->createPassword($data);
  echo $resp;
 ?>
