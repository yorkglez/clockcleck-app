<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Carer.php');
  /**/
  $id = $_GET['id'];
  $carer = new Carer;
  $resp = $carer->getCarer($id);
  echo $resp;

?>
