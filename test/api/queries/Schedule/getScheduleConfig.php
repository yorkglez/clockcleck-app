<?php

  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Schedule.php');
  /**/
 if($_GET['code'] == 'null'){
    session_start();
    $code = $_SESSION['id'];
 }
 else
   $code = $_GET['code'];
  $schedule = new Schedule;
  $resp = $schedule->getScheduleConfig($code);
  echo $resp;
?>
