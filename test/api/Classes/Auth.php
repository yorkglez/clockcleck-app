<?php
  /**
   * [Auth description]
   */
  require_once('Connection.php');
  class Auth extends Connection
  {
      public function authFingerTeacher(){

      }
      public function authUserDesk($email, $password){
          $resp  = false;
          $sql ='SELECT * FROM View_authUser WHERE email = :email';
          $stmt = $this->connect()->prepare($sql);
          $stmt->bindParam(':email',$email,PDO::PARAM_STR);
          if($stmt->execute()){
            if($stmt->rowCount() > 0){
              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              if(password_verify($password, $row['password'])  AND $row['status'] == '1'){
                $resp['username'] =  $row['username'];
                $resp['extension'] =  $row['extension'];
                $resp['genere'] =  $row['genere'];
                $resp = array($resp);
              }
            }
          }
          $this->closeConnection();
          return  json_encode($resp);
      }
      public function authTeacherDesk($email, $password){
          $resp  = false;
          $sql ='SELECT * FROM ViewAuthteacher WHERE email = :email';
          $stmt = $this->connect()->prepare($sql);
          $stmt->bindParam(':email',$email,PDO::PARAM_STR);
          if($stmt->execute()){
            if($stmt->rowCount() > 0){
              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              if(password_verify($password, $row['password'])  AND $row['status'] == '1'){
                $resp['username'] =  $row['username'];
                $resp['fingerName'] =  $row['fingerRoute'];
                $resp['code'] =  $row['code'];
                $resp = array($resp);
              }
            }
          }
          $this->closeConnection();
          return  json_encode($resp);
      }
      /**
       * [authUser description]
       * @param  [type] $email    [description]
       * @param  [type] $password [description]
       * @return [type]           [description]
       */
      public function authUser($email, $password){
        $sql ="SELECT * FROM View_authUser WHERE email = :email AND (status = '1' AND validate = '1')";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':email',$email,PDO::PARAM_STR);
        if($stmt->execute()){
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          /*if data exists*/
          if($stmt->rowCount() > 0){
            /*User type admin*/
            if (password_verify($password, $row['password'])) {
              /*Create sessions varibles*/
              $_SESSION['username'] =  $row['username'];
              $_SESSION['email'] =  $row['email'];
              $_SESSION['type'] =  $row['type'];
              $_SESSION['id'] =  $row['idUser'];
              $_SESSION['extension'] =  $row['extension'];
              /*create array for response*/
              $resp['username'] =  $row['username'];
              $resp['email'] =  $row['email'];
              $resp['type'] =  $row['type'];
              $resp['extension'] =  $row['extension'];
              $resp['success'] = true;
            }
            else
            $resp['success'] = false;
          }
          else
            $resp['success'] = false;
        }
        // else{
        //   $resp['success'] = false;
        //   $resp['message'] = 'error in conect to DB!:(';
        // }
        $this->closeConnection();
        return  json_encode($resp);
      }
      /**
       * [authTeacher description]
       * @param  [type] $email    [description]
       * @param  [type] $password [description]
       * @return [type]           [description]
       */
      public function authTeacher($email, $password){
        $sql ="SELECT * FROM ViewAuthteacher WHERE email = :email AND (status = '1' AND validate = '1')";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':email',$email,PDO::PARAM_STR);
        if($stmt->execute()){
          /*if data exists*/
          if($stmt->rowCount() > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password'])) {
              $_SESSION['email'] =  $row['email'];
              $_SESSION['id'] =  $row['code'];
              $_SESSION['username'] =  $row['username'];
              $_SESSION['type'] =  'teacher';
              /*create array for response*/
              $resp['username'] =  $row['username'];
              $resp['email'] =  $row['email'];
              $resp['extension'] =  $row['extension'];
              $resp['type'] = 'teacher';
              $resp['success'] = true;
            }
            else
              $resp = false;
          }
          else
            $resp = false;
        }
        // else{
        //   $resp['success'] = false;
        //   $resp['message'] = 'error in conect to DB!:(';
        // }
        $this->closeConnection();
        return  json_encode($resp);
      }

      public function getUserInfo(){
        session_start();
        $user = $_SESSION['email'];
        echo 'sesion: '.$user;
      }
      /**
       * [createPassword description]
       * @param  [type] $values [description]
       * @return [type]         [description]
       */
      public function createPassword($values){
        $resp = false;
        $token = $values->token;
        $id = $values->id;
        $type = $values->type;
        $action = $values->action;
        $password = $values->password;
        $encrypt = password_hash($password, PASSWORD_DEFAULT);
        $sql = "CALL createPassword(:type,:password,:id,:action)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':type',$type);
        $stmt->bindParam(':password',$encrypt);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':action',$action);

        if($stmt->execute())
          $resp = true;
        $this->closeConnection();
        return json_encode($resp);
      }
      /**
       * [Validate if token exists in db]
       * @param  [type] $userType [type user]
       * @param  [type] $token    [existent token]
       * @param  [type] $id       [id user]
       * @return [type]           [response json]
       */
      public function verifyToken($userType,$token,$id,$action){
        $resp = false;
          /*If action is reset password*/
        if($action == 'reset'){
          if($userType == 'user')
            $sql = "SELECT token FROM Users WHERE email = :id AND (status = '1' AND validate = '1')";
          else if($userType == 'teacher')
            $sql = "SELECT token FROM Teachers WHERE email = :id AND status = '1' AND validate = '1'";
        }
        /*If action is validate email*/
        else if($action == 'validate'){
          if($userType == 'user')
            $sql = "SELECT token FROM Users WHERE email = :id AND status = '1' AND validate = '0'";
          else if($userType == 'teacher')
            $sql = "SELECT token FROM Teachers WHERE email = :id AND status = '1' AND validate = '0'";
        }
        /*Prepare connection*/
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        /*If email exists*/
        if($stmt->rowCount() > 0){
          $tokendb = $stmt->fetchColumn(); //Get token from consult
          /*Validate token*/
          if($tokendb == '_token$'.$token)
            $resp = true;
        }
        $this->closeConnection(); //close conection
        return json_encode($resp); // convert to json and return this
      }

      /**
       * [verifyEmail description]
       * @param  [type] $userType [description]
       * @param  [type] $email    [description]
       * @return [type]           [description]
       */
    /*  public function verifyEmail($userType,$email){
        $resp = false;
        if($userType == 'user')
          $sql ="SELECT email FROM view_authuser WHERE email = :email AND (validate = '1' AND status = '1')";
        else if($userType == 'teacher')
          $sql ="SELECT email FROM Teachers WHERE email = :email AND (validate = '1' AND status = '1')";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':email',$email);
        if($stmt->execute())
          if($stmt->rowCount() > 0)
            $resp = true;
        $this->closeConnection();
        return json_encode($resp);
      }*/

      public function resetPassword($email,$type){
        $token = bin2hex(random_bytes(20));
        $realToken = '_token$'.$token;
        $sql = "CALL resetPassword(:type,:email,:token)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':email',$email,PDO::PARAM_STR);
        $stmt->bindParam(':type',$type,PDO::PARAM_STR);
        $stmt->bindParam(':token',$realToken,PDO::PARAM_STR);

        if($stmt->execute()){
          $resp = true;
          require_once('Helpers.php');
          $helper = new Helpers;
          $url = 'http://localhost:4200/confirmemail/'.$type.'/'.$token.'/'.$email.'/reset';
          echo $url;
          $body = '
          <h2>Clock Check</h2>
          <h3>Restablecimiento de contrasena</h3>
          <p><b>Correo:</b> emal@</p>
          <p>Si este no es tu correo haz caso omiso de este este correo y contactate con el administrador de la plataforma para que cambie el correo.</p>
          <p>Para poder restablecer tu contrasena haz clic en boton y sigue los pasos.</p>
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
          >Restablecer contrasena</a>



          ';
        //  $resp = $helper->sendMail($email,'Restablecr contrasena',$body);
        }

        else
          $resp = false;
        $this->closeConnection();
        return json_encode($resp);
      }
  }
 ?>
