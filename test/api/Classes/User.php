<?php
  require_once('Connection.php');
  class User extends Connection{
    /**
     * [getUsers description]
     * @return [type] [description]
     */
    public function getUsers(){
      session_start();
      $id =  $_SESSION['id'];
      $values = ['id' => $id];
      return $this->getData('Users','WHERE NOT idUser = :id',$values);
    }

    public function createUser($values){
      /*Encrypt password*/
      $encrypt = password_hash('Password', PASSWORD_DEFAULT);
      $token = bin2hex(random_bytes(20));
      $realToken = '_token$'.$token;
      $values['token'] = $realToken;
      $sql = "INSERT INTO Users(name,lastname,email,password,type,token,Extensions_idExtension, genere)
      VALUES (:name,:lastname,:email,:password,:type,:token,:Extensions_idExtension, :genere)";
      $stmt = $this->connect()->prepare($sql);
      $resp = false;
      if ($stmt->execute($values)) {
        $resp = true;
        require_once('Helpers.php');
        $helper = new Helpers;
        $type = 'user';
        $email = $values['email'];
        $url = 'http://localhost:4200/confirmemail/'.$type.'/'.$token.'/'.$email.'/activate'; // url for activate email
        /* html message*/
        $body = '
          <h2>Clock Check</h2>
          <h3>Bienvenid@: User name a la plataforma!</h3>
          <p><b>Correo:</b> emal@</p>
          <p>Si este no es tu correo haz caso omiso de este este correo y contactate con el administrador de la plataforma para que cambie el correo.</p>
          <p>Para poder activar tu cuenta es necesario validar tu correo, haz clic en el siguiente boton para ser enviado a la pagina de activacion.</p>
          <a href=""
          style="
          text-decoration: none;
          background-color: #28a745;
          border-color: #1e7e34;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
          border: 1px solid transparent;
          color: white;
          font-weight: 400;
          text-align: center;
          white-space: nowrap;
          vertical-align: middle;
          padding: .600rem .85rem;
          font-size: 1rem;
          line-height: 1.5;
          border-radius: .25rem;
          transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
              "
          >Activar cuenta</a>
        ';
         // $resp = $helper->sendMail($email,'Restablecr contrasena',$body);
      }
      $this->closeConnection();
      return '{"resp": '.$resp.'}';
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
      $values = ['id' => $id];
      return $this->getFirst('Users','WHERE idUser = :id',$values);
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
