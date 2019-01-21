<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Carer.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $values = [
    'codeCarer' => $data->code,
    'name' => $data->name,
    'alias' => $data->alias,
    'Extensions_idExtension' => $data->extension
  ];
  $carer = new Carer;
  $resp = $carer->createCarer($values);
  echo $resp;

 ?>
