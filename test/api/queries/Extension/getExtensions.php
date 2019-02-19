<?php
  /*Includes*/
 require('../../Headers.php');
 require('../../Classes/Extension.php');
 $status = $_GET['status'];

 /*Call Class Operations*/
 $ex = new Extension;
 $resp = $ex->getExtensions($status); //Get data from database
 echo $resp;
  //Send data in json to frontend
 ?>
