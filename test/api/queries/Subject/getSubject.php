<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Subject.php');
  /**/
  $id = $_GET['id'];
  $subject = new Subject;
  $resp = $subject->getSubject($id);
  echo $resp;
?>
