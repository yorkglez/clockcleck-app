<?php
  /**
   *
   */
  require_once('Connection.php');
  class Extension extends Connection
  {
    /**/
    public function getExtensions($status){
      $values = ['status' => $status];
      return $this->getData('Extensions','WHERE status = :status',$values);
    }
    public function getExtensionbyId($id){
      $values = ['id' => $id];
      return $this->getFirst("Extensions", "WHERE idExtension = :id", $values);
    }
    /**
     * [getExtension description]
     * @return [type] [description]
     */
    public function getExtension(){
      return $this->getData('Extensions',"WHERE status = '1'");
    }
    /**
     * [updateExtension description]
     * @param  [type] $values [description]
     * @return [type]         [description]
     */
    public function updateExtension($values){
      $sql ="UPDATE Extensions SET name = :name, city = :city, address = :address WHERE idExtension = :idExtension";
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute($values))
        $resp = true;
      else
        $resp = false;
      $this->closeConnection();
      return json_encode($resp);
    }
    /**
     * [createExtension description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function createExtension($data){
      return $this->Insert('Extensions',$values);
    }
    /**
     * [validateExtension description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function validateExtension($name){
      $values = ['name' => $name];
      $data = json_decode($this->getFirst('Extensions',' Extensions WHERE name = :name', $values));
      if(isset($data->name))
        $resp = false;
      else
        $resp = true;
      return  json_encode($resp);
    }
    /**
     * [changeStatus description]
     * @param  [type] $id     [description]
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    public function changeStatus($id,$status){
      return $this->changeSt('Extensions',$id,'idExtension',$status);
    }
    /**
     * [Search description]
     * @param [type] $ter    [description]
     * @param [type] $status [description]
     */
    public function Search($ter, $status){
      $values = [
        'ter' => $ter,
        'status' => $status
      ];
      return $this->getData('Extensions',"WHERE name LIKE concat(:ter,'%') AND status = :status",$values);
    }
  }



?>
