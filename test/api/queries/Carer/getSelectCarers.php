<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Carer.php');
  /**/
  $extension =  $_GET['extension'];
  $carer = new Carer;
  $resp = $carer->getSelectCarers($extension);
  echo $resp;
?>
