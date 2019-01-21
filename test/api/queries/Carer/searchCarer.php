<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Carer.php');
  /**/
  $ter = $_GET['ter'];
  $extension = $_GET['extension'];
  $status= $_GET['status'];

  /*Call Class Carer*/
  $carer = new Carer;
  $resp = $carer->searchCarer($ter,$extension,$status); //Get data from database
  echo $resp; //Send data in json to frontend
?>
