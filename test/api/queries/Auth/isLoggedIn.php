
<?php
  session_start();
  /*Includes*/
  require('../../Headers.php');
  if(isset($_SESSION['username'])){
    if($_SESSION['type'] == 'admin')
      $resp['type'] = 'admin';
    else if($_SESSION['type'] == 'normal')
      $resp['type'] = 'normal';
    else if($_SESSION['type'] == 'teacher')
      $resp['type'] = 'teacher';
    $resp['logged'] = true;
  }
  else
    $resp['logged'] = false;
  echo json_encode($resp);
 ?>
