<?php
    /*Includes*/
   require('../../Headers.php');
   require('../../Classes/User.php');
   $data = json_decode(file_get_contents("php://input",true));
   $oldPassword = $data->oldpassword;
   $newPassword = $data->newpassword;
   /*Call Class users*/
   $user = new User;
   $resp = $user->changePassword($oldPassword, $newPassword); //Get data from database
   echo $resp; //Send data in json to frontend
 ?>
