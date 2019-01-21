<?php
  /*includes*/
  require('../conection.php');
  include('../Headers.php');
  require('saveData.php');

  $data = json_decode(file_get_contents("php://input",true));
  $sql = "INSERT INTO Users(name,lastname,email,password,type,Extensions_idExtension) VALUES (:name,:lastname,:email,:password,:type,:Extensions_idExtension)";
  $values = [
    'name' => $data->name,
    'lastname' => $data->lastname,
    'email' => $data->email,
    'password' => $data->password,
    'type' => $data->type,
    'Extensions_idExtension' => $data->extension
  ];



  saveData($sql, $values, $dbh);

  $dbh = null;
 ?>
