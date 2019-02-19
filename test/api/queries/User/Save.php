<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/User.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $values = [
    'name' => $data->name,
    'lastname' => $data->lastname,
    'email' => $data->email,
    'password' =>'123456',
    'type' => $data->type,
    'genere' => $data->genere,
    'Extensions_idExtension' => $data->extension
  ];
  // $encrypt = password_hash($values['password'], PASSWORD_DEFAULT);
  // $values['password'] = $encrypt;
  // echo $values['password'];
  $user = new User;
  $resp = $user->createUser($values);
  echo $resp;

?>
