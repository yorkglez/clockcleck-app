<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Teacher.php');

  $data= json_decode(file_get_contents("php://input",true)); //Get id
  /*Call Class Teacher*/
  $teacher = new Teacher;
  $resp = $teacher->changePorfile($data); //Get data from database
  echo $resp; //Send data in json to frontend

?>
