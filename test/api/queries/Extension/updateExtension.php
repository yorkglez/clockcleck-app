<?php
  include('../../Headers.php');
  require('../../Classes/Extension.php');

  $op = new Extension;
  $data = json_decode(file_get_contents("php://input",true));
  $values = [
    'name'=> $data->name,
    'city'=> $data->city,
    'address'=> $data->address,
    'idExtension'=> $data->id
  ];
  $resp = $op->updateExtension($values);
  echo $resp;
 ?>
