<?php
    /*Includes*/
   require('../../Headers.php');
   require('../../Classes/Connection.php');
   require('../../Classes/Operations.php');
   /*Call Class Operations*/
   $ter = $_GET['ter'];
   $type = $_GET['type'];
   $extension = $_GET['extension'];
   $values = [
     'ter'=>$ter,
     'type'=>$type,
     'extension'=>$extension
   ];
   // print_r($values);
   $op = new Operations;
   $resp= $op->Call('getTeachers',$values,true); //Get data from database
   echo $resp; //Send data in json to frontend

  // CALL getTeachers('juan','B',2);
 ?>
