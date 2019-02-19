<?php
    /*Includes*/
   require('../../Headers.php');
   require('../../Classes/User.php');
   /*Call Class users*/
   $user = new User;
   $resp = $user->getPorfile(); //Get data from database
   echo $resp; //Send data in json to frontend
 ?>
