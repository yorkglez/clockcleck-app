<?php

  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Schedule.php');
  /**/
  if(!isset($_GET['code'])){
    session_start();
    $code = $_SESSION['id'];
  }
  else
    $code = $_GET['code'];
  $schedule = new Schedule;
  $resp = $schedule->getScheduleConfig($code);
  echo $resp;
?>
