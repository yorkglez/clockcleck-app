<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Operations.php');
  /**/
  $values = [
    'ter'=> $_GET['ter'],
    'status'=> $_GET['status']
  ];
  $op = new Operations;
  $resp = $op->Call('getSubjects',$values,true);
  echo $resp;
?>
