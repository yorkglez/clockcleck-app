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
  ];

  $user = new User;
  $resp = $user->updatePorfile($values);
  echo $resp;

 ?>
