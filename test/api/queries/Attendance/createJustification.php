<?php
    /*Includes*/
   require('../../Headers.php');
   require('../../Classes/Attendance.php');
   $data = json_decode(file_get_contents("php://input",true));
  
   // /*Call Class Operations*/
   $at = new Attendance;
   $resp = $at->createJustification($data); //Get data from database
   echo $resp; //Send data in json to frontend
 ?>
