<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Extension.php');
  $name = json_decode(file_get_contents("php://input",true)); //Get id
  /*Call Class Teacher*/
  $extension = new Extension;
  $resp = $extension->validateExtension($name); //Get data from database
  echo $resp; //Send data in json to frontend

?>
