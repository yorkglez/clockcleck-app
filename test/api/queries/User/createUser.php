<?php
  /*includes*/
  include('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/User.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $values = [
    'name' => $data->name,
    'lastname' => $data->lastname,
    'email' => $data->email,
    'type' => $data->type,
    'Extensions_idExtension' => $data->extension
  ];
  $user = new User;
  $resp = $user->createUser($values);
  echo $resp;

?>
