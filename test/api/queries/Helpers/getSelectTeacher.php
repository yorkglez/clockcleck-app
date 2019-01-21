<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Teacher.php');
  $ex = $_GET['ex'];
  /*Call Class Teacher*/
  $teacher = new Teacher;
  $resp = $teacher->getSelect($ex); //Get data from database
  echo $resp; //Send data in json to frontend

?>
