<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Teacher.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $id = $data->id;
  $model = json_decode($data->model,true);
  $values = [
    'oldCode' => $id,
    'code' => $model['code'],
    'name' => $model['name'],
    'lastname' => $model['lastname'],
    'type' => $model['type'],
    'email' => $model['email'],
    'phone' => $model['phone'],
    'extension' => $model['extension'],
  ];
  $teacher = new Teacher;
  $resp = $teacher->updateTeacher($values);
  echo $resp;
?>
