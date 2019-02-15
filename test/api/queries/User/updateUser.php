<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/User.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $model = json_decode($data->model);
  $values = [
    'name' => $model->name,
    'lastname' => $model->lastname,
    'email' => $model->email,
    'type' => $model->type,
    'genere' => $model->genere,
    'Extensions_idExtension' => $model->extension,
    'idUser'=> $data->id
  ];

  $user = new User;
  $resp = $user->updateUser($values);
  echo $resp;

 ?>
