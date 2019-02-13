<?php
    /*Includes*/
   require('../../Headers.php');
   require('../../Classes/Connection.php');
   require('../../Classes/Teacher.php');
   $data = json_decode(file_get_contents("php://input",true));
   /*Call Class Operations*/
   $teacher = new Teacher;
   $resp = $teacher->getSchedulelist($data->id,$data->code); //Get data from database
   echo $resp; //Send data in json to frontend
 ?>
