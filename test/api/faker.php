<?php
  include('./Headers.php');
  require('./Classes/Connection.php');
  require('./Classes/Operations.php');

  $op = new  Operations;
  $op->fakerUsers();
 ?>
