<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');

  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $values = [
    'name' => $data->name,
    'city' => $data->city,
    'address' => $data->address,
  ];
  $op = new Connection;
  $resp = $op->Insert('Extensions',$values);
  echo json_encode($resp);

?>
