<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Subject.php');
  /**/
  $values = [
    'ter'=> $_GET['ter'],
    'status'=> $_GET['status'],
    'sequence'=> $_GET['sequence']
  ];
  $subject = new Subject;
  $resp = $subject->getSubjects($values);
  echo $resp;
?>
