<?php
  /*includes*/
  include('../Headers.php');
  require('../conection.php');
  require('getSelect.php');

  /**/
  $table =  $_GET['table'];// Get url data
  $id =  $_GET['id'];// Get url data
  $sql = 'SELECT * FROM '.$table.' WHERE idUser = :id';
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':id',$id);
  getData($stmt);
  $dbh = null; //Close db conection




?>
