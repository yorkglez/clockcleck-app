<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Teacher.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $oldpassword = $data->oldpassword;
  $newpassword = $data->newpassword;
  $teacher = new Teacher;
  $resp = $teacher->changePassword($oldpassword,$newpassword);
  echo $resp;
?>
