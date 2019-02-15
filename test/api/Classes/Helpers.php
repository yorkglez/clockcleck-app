<?php
  /**
   *
   */
   /*require('././libs/PHPMailer/src/PHPMailer.php');
   require('././libs/PHPMailer/src/SMTP.php');
   require('././libs/PHPMailer/src/Exception.php');
   require('././libs/PHPMailer/src/OAuth.php');*/
   require_once('Connection.php');
  class Helpers extends Connection
  {
    public function generateToken(){
      $token = bin2hex(random_bytes(20));;
      return $token;
    }

    public function checkEmail($email){
      $sql = "SELECT email FROM Users WHERE email = :email";
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
      $this->closeConnection();
      return  json_encode($resp);
    }

    public function sendMail($emailTo,$subject,$body){
      $mail = new PHPMailer\PHPMailer\PHPMailer();   // Passing `true` enables exceptions
      $emailFrom = '';
      try {
          /*Server settings*/
          $mail->SMTPDebug = 2;                                 // Enable verbose debug output
          $mail->isSMTP();                                      // Set mailer to use SMTP
          $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = $emailFrom;                 // SMTP username
          $mail->Password = 'secret';                           // SMTP password
          $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = 587;                                    // TCP port to connect to

          //Recipients
          $mail->setFrom($emailFrom, 'Mailer');
          $mail->addAddress($emailTo, 'Joe User');     // Add a recipient
          //$mail->addAddress('ellen@example.com');               // Name is optional
          //$mail->addReplyTo('info@example.com', 'Information');
      ///    $mail->addCC('cc@example.com');
        //  $mail->addBCC('bcc@example.com');

          //Attachments
      ///    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

          //Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = $subject;
          $mail->Body    = '
              <h2>Clock Check</h2>
              <h3>Bienvenid@:  a la plataforma!</h3>
              <p>Correo: '.$emailTo.'</p>
              <p>Si este no es tu correo haz caso omiso de este este correo y contactate con el administrador de la plataforma para que cambie el correo.</p>
              <p>Para poder activar tu cuenta es necesario validar tu correo, haz clic en el siguiente boton para ser enviado a la pagina de activacion.</p>
              <button>Activar cuenta</button>';
          $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

          $mail->send();
          echo 'Message has been sent';
          return true;
      } catch (Exception $e) {
          echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
          return false;
      }
    }

    public function getSelectsjbytc($date,$code){
      $timestamp = strtotime($date);
      $dayName = date("l", $timestamp);
      $nDay = date('N',strtotime($dayName));
      $sql = "SELECT sl.idSubjectlist AS id, sb.name  FROM Subjects_list sl
      INNER JOIN Subjects sb ON sl.Subjects_codeSubject = sb.codeSubject
      INNER JOIN schedule sc ON sc.Subjects_list_idSubjectlist = sl.idSubjectlist
      WHERE sc.day = ".$nDay." AND sl.Teachers_codeTeacher = :code";
      $stmt = $this->connect()->prepare($sql);
      // $stmt->bindParam(':day', $nDay, PDO::PARAM_INT);
      $stmt->bindParam(':code', $code, PDO::PARAM_STR);
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

   public function getSchedulelist($idsl, $code){
     $sql = "SELECT  at.Schedule_idSchedule FROM attendances at
     INNER JOIN Subjects_list sl ON sl.idSubjectlist = at.Subjects_list_idSubjectlist
     WHERE sl.Teachers_codeTeacher = :code AND at.date_At = '2019-02-11' AND sl.idSubjectlist = :idsl";
     $stmt = $this->connect()->prepare($sql);
     $stmt->bindParam(':idsl',$idsl,PDO::PARAM_INT);
     $stmt->bindParam(':code',$code,PDO::PARAM_STR);
     $stmt->execute();
     if($stmt->rowCount() > 0){
       while($row = $stmt->fetchColumn())
         $ids[] = $row;
       $cad =  implode(',',$ids);
       $this->closeConnection();

       $sql = "SELECT idSchedule, concat(startTime, ' - ', endTime) as hours FROM schedule WHERE idSchedule not in "."(".$cad.")";
       $stmt = $this->connect()->prepare($sql);
       $stmt->execute();
       if($stmt->rowCount() > 0){
         while($row = $stmt->fetch(PDO::FETCH_ASSOC))
           $fetch[] = $row;
       }
       else
         $fetch = false;
       $this->closeConnection();
     }
     else
       $fetch = false;
     return  json_encode($fetch);
   }
  }





 ?>
