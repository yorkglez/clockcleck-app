<?php

  class Connection{
    private $server;
    private $user;
    private $pass;
    private $dbname;
    private $charset;

    public function connect(){
      $this->server = 'localhost';
      $this->user = 'malastar';
      $this->pass = 'TAMALESfuckinglove123';
      $this->dbname = 'malastar_test';
      $this->charset = 'utf8mb4';
      try {
        $dsn = 'mysql:host='.$this->server.';dbname='.$this->dbname.';charset='.$this->charset;
        $pdo = new PDO($dsn, $this->user, $this->pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
      } catch (PDOException $e) {
        echo 'Connection failed: '.$e->getMessage();
      }
    }
  }

 ?>
