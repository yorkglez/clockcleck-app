<?php
header("Access-Control-Allow-Origin: *");
/*Database configuration*/
$user = 'malastar';
$pass = 'TAMALESfuckinglove123';
$dbname = 'malastar_test';
$status = false;

/*Conection to database*/
try {
    $dbh = new PDO('mysql:host=localhost;dbname='.$dbname.';charset=utf8', $user, $pass);
    $status = true;
} catch (\Exception $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}


?>
