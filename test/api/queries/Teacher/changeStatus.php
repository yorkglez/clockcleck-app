<?php
    /*Includes*/
    require('../../Headers.php');
    require('../../Classes/Teacher.php');

    $data = json_decode(file_get_contents("php://input",true)); //Get id
    $id = $data->id;
    $status = $data->status;
    /*Call Class Teacher*/
    $op = new Teacher;
    $resp = $op->changeStatus('Teachers',$id,'codeTeacher',$status); //Get data from database
    echo $resp; //Send data in json to frontend
 ?>
