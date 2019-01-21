<?php
    /*Includes*/
   require('../../Headers.php');
   require('../../Classes/Connection.php');
   require('../../Classes/Extension.php');
   $ter = $_GET['ter'];
   $status = $_GET['status'];

   /*Call Class Operations*/
   $ex = new Extension;
   $resp = $ex->Search($ter,$status); //Get data from database
   echo $resp; //Send data in json to frontend
 ?>
