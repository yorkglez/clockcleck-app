<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Carer.php');
  /**/
  $extension =  $_GET['extension'];
  $code =  $_GET['code'];
  $carer = new Carer;
  $resp = $carer->getSelectCarersTeacher($extension,$code);
  echo $resp;
?>
