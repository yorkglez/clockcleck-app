<?php
  /**
   *
   */
  require_once('Connection.php');
  class Extension extends Connection
  {
    /**/
    public function getExtensions($status){
      $sql = "SELECT  * FROM Extensions WHERE status = :status";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':status',$status,PDO::PARAM_STR);
      $stmt->execute();
      while($row = $stmt->fetch(PDO::FETCH_ASSOC))
          $fetch[] = $row;
      return  json_encode($fetch);
      $this->closeConnection();
    }
    public function getExtensionbyId($id){
      $sql = "SELECT * FROM Extensions WHERE idExtension = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_INT);
      $stmt->execute();
  //    $fetch = array();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->closeConnection();
      return json_encode($row);
    }
    /**
     * [getExtension description]
     * @return [type] [description]
     */
    public function getExtension(){
      $sql = "SELECT idExtension, name FROM Extensions WHERE status = '1'";
      $stmt = $this->connect()->query($sql);
      while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $fetch[] = $row;
      $this->closeConnection();
      return  json_encode($fetch);
    }
    /**/
    public function createExtension($values){
      $sql = 'INSERT INTO Extensions(name,address,city) VALUES (:name,:address,:city)';
      $stmt = $this->connect()->prepare($sql);
      $resp = false;
      if ($stmt->execute($values)) {
        $resp = true;
      }
      return '{"resp": '.$resp.'}';
      $this->closeConnection();
    }

    public function validateExtension($name){
      $sql = "SELECT name FROM Extensions WHERE name = :name";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':name',$name,PDO::PARAM_STR);
      $stmt->execute();
      if($stmt->rowCount() > 0)
        $resp = false;
      else
        $resp = true;
      $this->closeConnection();
      return  json_encode($resp);
    }
    /**
     * [changeStatus description]
     * @param  [type] $id     [description]
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    public function changeStatus($id,$status){
      $resp = false;
      $sql = "UPDATE Extensions Set status = :status WHERE idExtension = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_STR);
      $stmt->bindParam(':status',$status,PDO::PARAM_STR);
      if($stmt->execute())
        $resp = true;
      $this->closeConnection();
      return json_encode($resp);
    }
    public function Search($ter, $status){
      $sql = "SELECT * FROM Extensions WHERE name LIKE concat(:ter,'%') AND status = :status";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':ter', $ter, PDO::PARAM_STR);
      $stmt->bindParam(':status',$status, PDO::PARAM_STR);
      $stmt->execute();
      if($stmt->rowCount() > 0){
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            $fetch[] = $row;
      }
      else
        $fetch = false;
      $this->closeConnection();
      return  json_encode($fetch);
    }
  }



?>
