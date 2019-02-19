<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Helpers.php');
  $email = file_get_contents("php://input",true); //Get id

  /*Call Class Teacher*/
  $helper= new Helpers;
  $resp = $helper->checkEmail($email); //Get data from database
  echo $resp; //Send data in json to frontend

?>
