<?php
  require_once('Connection.php');
  class User extends Connection{

    /**
     * [getData description]
     * @return [type] [description]
     */
    public function getData(){
      session_start();
      $id =  $_SESSION['id'];
      $sql ="SELECT * FROM View_Users WHERE NOT idUser = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_INT);
      $stmt->execute();
      while($row = $stmt->fetch(PDO::FETCH_ASSOC))
          $fetch[] = $row;
      $this->closeConnection();
      return  json_encode($fetch);
    }

    public function createUser($values){
      /*Encrypt password*/
      $encrypt = password_hash('Password', PASSWORD_DEFAULT);
      $token = bin2hex(random_bytes(20));
      $realToken = '_token'.$token;
      $values['token'] = $realToken;
      $sql = "INSERT INTO Users(name,lastname,email,password,type,token,Extensions_idExtension, genere)
      VALUES (:name,:lastname,:email,:password,:type,:token,:Extensions_idExtension, :genere)";
      $stmt = $this->connect()->prepare($sql);
      $resp = false;
      if ($stmt->execute($values)) {
        $resp = true;
      }
      return '{"resp": '.$resp.'}';
      $this->closeConnection();
    }

    public function deleteUser($id){
      /*verifict exits user*/
      $sql = 'SELECT * FROM Users WHERE idUser = :id';
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_INT);
      $stmt->execute();

      /*If User exits*/
      if($stmt->rowCount() > 0){
        /*Delete user*/
        $this->closeConnection();
        $sql ='DELETE FROM Users WHERE idUser = :id';
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
      }
      return '{"success": true}';
      $this->closeConnection();
    }
    /**/
    public function getUser($id){
      $sql = "SELECT * FROM Users WHERE idUser = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->closeConnection();
      return  json_encode($row);
    }
    /**/
    public function checkEmail($email){
      $sql = 'SELECT email FROM Users WHERE email = :email';
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':email',$email,PDO::PARAM_STR);
      $stmt->execute();
      if($stmt->rowCount() > 0)
        $resp = true;
      else{
        $this->closeConnection();
        $sql = 'SELECT email FROM Teachers WHERE email = :email';
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':email',$email,PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0)
          $resp = true;
        else
          $resp = false;
      }
      return  json_encode($resp);
      $this->closeConnection();
    }
    /**/
    public function searchUser($ter,$type){
      $sql = "CALL searchUsers(:ter,:type)";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':type',$type);
      $stmt->bindParam(':ter',$ter);
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
    /**/
    public function getUserForType($type){
      if($type == 'admin' || $type == 'normal'){
        $sql = 'SELECT * FROM View_Users WHERE type = :type';
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':type',$type);
      }else{
          $sql = 'SELECT * FROM View_Users ';
          $stmt = $this->connect()->prepare($sql);
      }
      $stmt->execute();
      $fetch = array();
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          $fetch[] = $row;
      }
      return  json_encode($fetch);
      $this->closeConnection();
    }
    /**
     * [getPorfile description]
     * @return [type] [description]
     */
    public function getPorfile(){
      session_start();
      $id =  $_SESSION['id'];
      $sql ="SELECT * FROM View_Users WHERE idUser = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_INT);
      $stmt->execute();
        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->closeConnection();
      return  json_encode($fetch);
    }
    /**
     * [changePassword description]
     * @param  [type] $oldPassword [description]
     * @param  [type] $newPassword [description]
     * @return [type]              [description]
     */
    public function changePassword($oldPassword, $newPassword){
      session_start();
      $id = $_SESSION['id'];
      $sql = "SELECT password FROM Users WHERE idUser = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_INT);
      $stmt->execute();
      $resp = false;
      if(password_verify($oldPassword, $stmt->fetchColumn())){
        $this->closeConnection();
        $sql = "UPDATE Users SET password = :password WHERE idUser = :id";
        $stmt = $this->connect()->prepare($sql);
        $encrypt = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->bindParam(':password',$encrypt,PDO::PARAM_STR);
        if($stmt->execute())
          $resp = true;
      }
      $this->closeConnection();
      return  json_encode($resp);
    }
    /**
     * [updatePorfile description]
     * @param  [type] $values [description]
     * @return [type]         [description]
     */
    public function updatePorfile($values){
      session_start();
      $id = $_SESSION['id'];
      $sql = "UPDATE Users SET name = :name, lastname = :lastname, email = :email WHERE idUser = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_INT);
      $stmt->bindParam(':name',$values['name'],PDO::PARAM_STR);
      $stmt->bindParam(':lastname',$values['lastname'],PDO::PARAM_STR);
      $stmt->bindParam(':email',$values['email'],PDO::PARAM_STR);
      if($stmt->execute())
        $resp = true;
      else
        $resp = false;
      $this->closeConnection();
      return  json_encode($resp);
    }
    /**/
    public function updateUser($values){
      $resp = false;
      $sql = 'UPDATE Users SET name=:name, lastname=:lastname, email=:email, type=:type,genere = :genere, Extensions_idExtension=:Extensions_idExtension WHERE idUser = :id';
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute($values)){
        $resp = true;
      }
      return json_encode($resp);
      $this->closeConnection();
    }

  }


 ?>
