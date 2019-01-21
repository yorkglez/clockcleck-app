<?php
  /*Includes*/
  include('../Headers.php');
  require('../conection.php');
  require('filterData.php');
  /**/
  $table =  $_GET['table'];// Get url data
  $type =  $_GET['type'];// Get url data
  $sql = 'SELECT * FROM '.$table.' WHERE type = :type';
  filterData($sql, $dbh, $type, $table);



?>
