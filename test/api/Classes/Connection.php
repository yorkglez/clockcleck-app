<?php
  class Connection {
    private $server;
    private $user;
    private $pass;
    private $dbname;
    private $charset;
    private $pdo = null;
    /**
     * [connect to sql server]
     * @return [pdo] [return connection]
     */
    public function connect(){

      /*Server Db config*/
      $this->server = 'localhost';
      $this->user = 'root';
      $this->pass = 'root12';
      $this->dbname = 'attendancesclock_db';
      $this->charset = 'utf8mb4';

      /*Check if there is a connection*/
      if ($this->pdo != null ) {
        $this->closeConnection(); //Close connection
      }

      /*Create connetion to Database*/
      else{
        try {
          $dsn = 'mysql:host='.$this->server.';dbname='.$this->dbname.';charset='.$this->charset;
          $this->pdo = new PDO($dsn, $this->user, $this->pass);
          //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return $this->pdo;
        } catch (PDOException $e) {
          echo 'Connection failed: '.$e->getMessage();
          die();
        }
      }

    }

    /**
     * [this function close conection to sql server]
     * @return [type] [description]
     */
    public function closeConnection(){
      $this->pdo = null;
    }
    /**
     * [Insert description]
     * @param [type] $table  [description]
     * @param [type] $values [description]
     */
    public function Insert($table,$values){
      $exc = false;
      $sql = "INSERT INTO ".$table." (";
      foreach($values as $param=>$value)
        $sql .= $param.", ";
      $sql = substr($sql,0,-2).") VALUES (";
      foreach($values as $param=>$value)
        $sql .= ":".$param.", ";
      $sql = substr($sql,0,-2).")";
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute($values))
        $exc = true;
      return $exc;
    }


  }

 ?>
