<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Auth.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $token = $data->token;
  $userType = $data->type;
  $id = $data->id;
  $action = $data->action;
  $auth = new Auth;
  $resp = $auth->verifyToken($userType,$token,$id,$action);
  echo $resp;
//  echo json_encode(true);
 ?>
