<?php
    /*Includes*/
   require('../../Headers.php');
   require('../../Classes/Extension.php');
   $id = $_GET['id'];

   /*Call Class Operations*/
   $ex = new Extension;
   $resp = $ex->getExtensionbyId($id); //Get data from database
   echo $resp; //Send data in json to frontend
 ?>
