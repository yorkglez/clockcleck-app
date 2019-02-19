<?php
    /*Includes*/
    session_start();
    require('../../Headers.php');
    require('../../Classes/Auth.php');
    if(isset($_SESSION['username']))
      $resp = true;
    else
      $resp = false;
    echo json_encode($resp);
 ?>
