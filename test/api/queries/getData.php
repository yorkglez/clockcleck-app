<?php
  /*Includes*/
  //require('../conection.php');
  include('../Headers.php');
  require('../Classes/Connection.php');
  require('../Classes/Operations.php');
  $table =  $_GET['table'];// Get url data
  $obj = new Operations;
  $data = $obj->getAllData('SELECT * FROM '.$table);
  echo $data;






 // $stmt = $dbh->prepare("SELECT * FROM ".$table);
 // $stmt->execute();
 // $fetch = array();
 // while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 //     $fetch[] = $row;
 // }
 // echo json_encode($fetch);
 // $dbh = null; //Close db conection
 ?>
