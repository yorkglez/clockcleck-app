<?php
  /*Includes*/
 require('../../Headers.php');
 require('../../Classes/Connection.php');
 require('../../Classes/Teacher.php');
 $code = json_decode(file_get_contents("php://input",true));
 /*Call Class Operations*/
 $teacher = new Teacher;
 $data = $teacher->getSubjectsList('1414'); //Get data from database
 echo $data; //Send data in json to frontend
 ?>
