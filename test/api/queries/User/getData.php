<?php
  /*Includes*/
 require('../../Headers.php');
 require('../../Classes/User.php');
 /*Call Class users*/
 $user = new User;
 $data = $user->getUsers(); //Get data from database
 echo $data; //Send data in json to frontend
 ?>
