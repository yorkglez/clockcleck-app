<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Subject.php');
  $code = json_decode(file_get_contents("php://input",true)); //Get id
  /*Call Class Teacher*/
  $subject = new Subject;
  $resp = $subject->validateCode($code); //Get data from database
  echo $resp; //Send data in json to frontend

?>
