<?php //------            ESO (Email Send Object) Objeto de envio de Correo               ------------


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require("layouts/src/Exception.php");
require ("layouts/src/PHPMailer.php");
require ("layouts/src/SMTP.php");


class ESO{
  private $email="miancalo.lopez@gmail.com";
  private $password="ujczaqdrxscipcdn";
  public function reporte($CON){
    $mail = new PHPMailer(True);                //Instantiation and passing `true` enables exceptions

    try {                  //Enable verbose debug output                  //Enable verbose debug output

      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host = "ssl://smtp.gmail.com";                   //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = $this->email;                     //SMTP username
      $mail->Password   = $this->password;                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

      //Recipients
      $mail->setFrom($this->email, 'XIAN BOT');
      $mail->addAddress('miancalo.lopez@gmail.com', 'Administracion del Centro Comercial Calima');     //Add a recipient
      //$mail->addAddress('ronaldandresmh@gmail.com', 'Creador MOODIE');               //Name is optional
      //$mail->addReplyTo('info@example.com', 'Information');
      //$mail->addCC('cc@example.com');
      //$mail->addBCC('bcc@example.com');

      //Attachments
      $mail->addAttachment('reports/reporte.pdf');          //Add attachments
      //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');  //Optional name

      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = 'Reporte general del sistema MOODIE';
      $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      $mail->send();
      //echo 'Message has been sent';
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
      //return $promedio_dia;}
  }
}
?>
