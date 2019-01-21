<?php
  session_start();
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Carer.php');
  $resp['type'] = $_SESSION['type'];
  $_SESSION = array();
  if(session_destroy())
    $resp['success'] = true;
  else
    $resp['success'] = false;
  echo json_encode($resp);
  ?>
