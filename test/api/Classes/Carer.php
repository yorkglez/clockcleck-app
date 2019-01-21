<?php
  /**
   *
   */
  require_once('Connection.php');
  class Carer extends Connection
  {
    /**
     * [getCarers description]
     * @return [type] [description]
     */
    public function getCarers($extension,$status){
      $sql = "CALL getCarers(:extension,:status)";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':extension', $extension, PDO::PARAM_INT);
      $stmt->bindParam(':status',$status, PDO::PARAM_STR);
      $stmt->execute();
      $fetch = [];
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          $fetch[] = $row;
      }
      $this->closeConnection();
      return  json_encode($fetch);
    }
    /**
     * [getCarer description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getCarer($id){
      $sql = 'SELECT * FROM Carers WHERE codeCarer = :id';
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_STR);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return  json_encode($row);
      $this->closeConnection();
    }
    /**
     * [validateCode description]
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function validateCode($code){
      $resp = false;
      $sql = "SELECT codeCarer FROM Carers WHERE codeCarer = :code";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':code',$code,PDO::PARAM_STR);
      $stmt->execute();
      if($stmt->rowCount() > 0)
        $resp = false;
      else
        $resp = true;
      $this->closeConnection();
      return  json_encode($resp);
    }
    /**
     * [createCarer description]
     * @param  [type] $values [description]
     * @return [type]         [description]
     */
    public function createCarer($values){
      $resp = false;
      $sql = 'INSERT INTO Carers (codeCarer,name,alias,Extensions_idExtension) VALUES (:codeCarer,:name,:alias,:Extensions_idExtension)';
      $stmt = $this->connect()->prepare($sql);
      if ($stmt->execute($values)) {
        $resp = true;
      }
      return '{"resp": '.$resp.'}';
      $this->closeConnection();
    }
    /**
     * [updateCarer description]
     * @param  [type] $values [description]
     * @return [type]         [description]
     */
    public function updateCarer($values){
      $resp = false;
      $sql = 'UPDATE Carers SET codeCarer=:code, name=:name, alias=:alias, Extensions_idExtension=:extension WHERE codeCarer = :id';
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute($values)){
        $resp = true;
      }
      $this->closeConnection();
      return json_encode(array('resp'=>$resp));
    }
    /**
     * [getSelectCarers description]
     * @param  [type] $extension [description]
     * @return [type]            [description]
     */

    public function getSelectCarers($extension){
      $sql = "SELECT * FROM view_carersselect WHERE idExtension = :extension";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':extension', $extension, PDO::PARAM_INT);
      $stmt->execute();
      if($stmt->rowCount() > 0){
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            $fetch[] = $row;
      }
      else
        $fetch = false;
      $this->closeConnection();
      return json_encode($fetch);
    }
    public function getSelectCarersTeacher($extension,$code){
      $sql = "SELECT * FROM view_getcarersteacher WHERE codeTeacher = :code AND idExtension = :extension ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':extension', $extension, PDO::PARAM_INT);
      $stmt->bindParam(':code', $code, PDO::PARAM_STR);
      $stmt->execute();
      if($stmt->rowCount() > 0){
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            $fetch[] = $row;
      }
      else
        $fetch = false;
      $this->closeConnection();
      return json_encode($fetch);
    }

    /**
     * [searchCarer description]
     * @param  [type] $ter       [description]
     * @param  [type] $extension [description]
     * @param  [type] $status    [description]
     * @return [type]            [description]
     */
    public function searchCarer($ter,$extension,$status){
      $sql = "CALL searchCarer(:ter,:extension,:status)";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':ter', $ter, PDO::PARAM_STR);
      $stmt->bindParam(':extension', $extension, PDO::PARAM_INT);
      $stmt->bindParam(':status',$status, PDO::PARAM_STR);
      $stmt->execute();
      $fetch = array();
      if($stmt->rowCount() > 0){
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            $fetch[] = $row;
      }
      else
        $fetch = false;
      $this->closeConnection();
      return  json_encode($fetch);
    }
    /**
     * [deleteCarer description]
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function changeStatus($code,$status){
      $resp = false;
      $sql = "UPDATE Carers Set status = :status WHERE codeCarer = :code";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':code',$code,PDO::PARAM_STR);
      $stmt->bindParam(':status',$status,PDO::PARAM_STR);
      if($stmt->execute())
        $resp = true;
      $this->closeConnection();
      return json_encode($resp);
    }

  }
 ?>
