<?php
  include('./Headers.php');
  include('./Classes/Helpers.php');
  $help = new Helpers;
//  $help->sendMail('','','','');
//  include('./Headers.php');
  // require('./Classes/Connection.php');
  // require('./Classes/Operations.php');
  // require('./libs/PHPMailer/src/PHPMailer.php');
  // require('./libs/PHPMailer/src/SMTP.php');
  // require('./libs/PHPMailer/src/Exception.php');
  // require('./libs/PHPMailer/src/OAuth.php');

  // $mail = new PHPMailer\PHPMailer\PHPMailer();
  //
  // $mail->isSMTP();
  // /*
  // Enable SMTP debugging
  // 0 = off (for production use)
  // 1 = client messages
  // 2 = client and server messages
  // */
  // // $mail->SMTPDebug = 0;
  // // $mail->Host = 'smtp.gmail.com';
  // // $mail->Port = 587;
  // // $mail->SMTPSecure = 'tls';
  // // $mail->SMTPAuth = true;
  // $mail->SMTPDebug = 2;
  // $mail->Host = 'smtp.gmail.com';
  // $mail->Port = 465;
  // $mail->SMTPSecure = 'tls';
  // $mail->SMTPAuth = true;
  // $mail->Username = "jorgeglez.alva94@gmail.com";
  // $mail->Password = "Tamaleslove1226";
  // $mail->setFrom('jorgeglez.alva94a@gmail.com', 'Control de asistencias');
  // $mail->addAddress('anony6917@gmail.com', 'york');
  // $mail->Subject = 'Activa tu cuenta';
  // $mail->Body = "<a href='www.google.com'>Link</a>";
  // $mail->CharSet = 'UTF-8'; // Con esto ya funcionan los acentos
  // $mail->IsHTML(true);
  //
  // if (!$mail->send())
  // {
  // 	echo "Error al enviar el E-Mail: ".$mail->ErrorInfo;
  // }
  // else
  // {
  // 	echo "E-Mail enviado";
  // }
  //    <h3 style="font-family: Arial;">Bienvenid@: Jorge Gonzalez a la plataforma!</h3>
  //Si este no es tu correo haz caso omiso de este este correo y contactate con el administrador de la plataforma para que cambie el correo.
  echo '
    <img src="./public/images/logocc.png"  alt="imagen..."  style=" width: 150px;">
    <h3 style="font-family: Arial;">Restablecer contraseña</h3>
    <p style="font-family: Arial;"><b>Correo:</b> test@hot.com</p>
    <p style="font-family: Arial;">Para poder restablecer tu contraseña haz clic en el siguiente boton para ser eviado a la pagina de restablecimiento.</p>
    <p style="font-family: Arial;">Si no has solicitado el restablecimiento de tu contraseña, haz caso omiso de este mensaje.</p>
    <a href=""
    style="
    font-family: Arial;
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
    >Restablecer contraseña</a>


  ';

 ?>
