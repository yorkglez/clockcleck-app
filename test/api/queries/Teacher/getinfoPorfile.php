<?php
  session_start();
  /*Includes*/
 require('../../Headers.php');
 require('../../Classes/Connection.php');
 require('../../Classes/Teacher.php');
 /*Call Class Operations*/
 $code = $_SESSION['id'];
 $teacher = new Teacher;
 $data = $teacher->getinfoPorfile($code); //Get data from database
 echo $data; //Send data in json to frontend
 ?>
