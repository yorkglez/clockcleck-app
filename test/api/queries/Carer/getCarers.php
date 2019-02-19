<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Carer.php');
  /**/
  $extension = $_GET['extension'];
  $status = $_GET['status'];
  $carer = new Carer;
  $resp = $carer->getCarers($extension,$status);
  echo $resp;
?>
