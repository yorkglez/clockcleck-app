<?php
  /*Includes*/
  include('../Headers.php');
  require('../conection.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  print_r($data);
  $sql = '';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
 ?>
