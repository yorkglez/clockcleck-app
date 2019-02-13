<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/User.php');

  $id = json_decode(file_get_contents("php://input",true)); //Get id
  /*Call Class users*/
  $obj = new User;
  $data = $obj->deleteUser($id); //Send id to function for delete user
  echo $data; //Send data in json to frontend

 ?>
