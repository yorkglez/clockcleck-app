<?php
    /*Includes*/
   require('../../Headers.php');
   require('../../Classes/Connection.php');
   require('../../Classes/Attendance.php');
   $data = json_decode(file_get_contents("php://input",true));
   $id = $data->id;
   $note = $data->note;
   $type = $data->type;

   /*Call Class Operations*/
   $at = new Attendance;

   $resp = $at->saveChanges($id,$note,$type); //Get data from database
   echo $resp; //Send data in json to frontend
 ?>
