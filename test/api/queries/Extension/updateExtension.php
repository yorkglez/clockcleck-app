<?php
  include('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Operations.php');

  $op = new Operations;
  $data = json_decode(file_get_contents("php://input",true));
  $values = [
    'name'=> $data->name,
    'city'=> $data->city,
    'address'=> $data->address,
    'idExtension'=> $data->id
  ];
  $resp = $op->Update('Extensions',$values);
  echo $resp;
 ?>
