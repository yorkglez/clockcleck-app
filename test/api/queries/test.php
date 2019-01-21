<?php
  /*Includes*/
  require('../Headers.php');
  // require('../Classes/Connection.php');
  // require('../Classes/Teacher.php');
  // $user = new Teacher;
  // $resp = $user->test();
  // echo $resp;

  $resp['username'] =  "user";
  $resp['extension'] =  "1";
  $resp = array($resp);
    echo   json_encode($resp);

?>
