<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Carer.php');
  $code = json_decode(file_get_contents("php://input",true)); //Get id
  /*Call Class Teacher*/
  $carer = new Carer;
  $resp = $carer->validateCode($code); //Get data from database
  echo $resp; //Send data in json to frontend

?>
