<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Subject.php');
  /**/
  $subject = new Subject;
  $resp = $subject->getSubjectsList();
  echo $resp;
?>
