<?php
    /*Includes*/
   require('../../Headers.php');
   require('../../Classes/Teacher.php');
   /*Call Class Operations*/
   $id = $_GET['id'];
   $teacher = new Teacher;
   $data = $teacher->getTeacher($id); //Get data from database
   echo $data; //Send data in json to frontend
 ?>
