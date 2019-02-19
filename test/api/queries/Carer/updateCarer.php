<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Carer.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $model = json_decode($data->model);
  $values = [
    'id'=> $data->id,
    'code'=> $model->code,
    'name' => $model->name,
    'alias' => $model->alias,
    'extension' => $model->extension
  ];
  $carer = new Carer;
  $resp = $carer->updateCarer($values);
  echo $resp;
 ?>
