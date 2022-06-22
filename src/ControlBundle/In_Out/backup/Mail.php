<?php
require "mail/class.phpmailer.php";
require "mail/class.smtp.php";

class Mail
{

    public function __construct($s)
    {

        $sensores = array("Sensor de Humo", "Sensor de Movimiento #1", "Sensor de Movimiento #2");

        $fecha2 = time() + 86400 * 0;

        $fecha = date('d/m/Y h:i:s A', $fecha2);

        try {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 3;
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465;

            $mail->Username = "horariotps@gmail.com";
            $mail->Password = "horariotps39";
            $mail->From = "horariotps@gmail.com";
            $mail->FromName = "Servidor Sensores";
            $mail->Subject = $sensores[$s] . " Activado";
            $mail->AltBody = "El " . $sensores[$s] . " ha sido Activado el dia (" . $fecha . ")";
            $mail->MsgHTML("<center><font face='sans-serif' color='#795548' size='7'>El " . $sensores[$s] . "</font></br></br>
<font face='sans-serif' color='#607D8B' size='5'>ha sido Activado el dia</font></br></br><font face='sans-serif' color='#009688' size='5'>" . $fecha . "</font></center>");

            $mail->AddAddress("balantajaiver@gmail.com", "Administrador");
            $mail->AddAddress("jaiver0.1@hotmail.com", "Administrador");
            $mail->AddAddress("horariotps@gmail.com", "Administrador");
            $mail->IsHTML(true);
            $mail->Send();
            echo "<script language='JavaScript'> alert('El Mensaje Ha Sido Enviado'); </script>";
        } catch (Exception $e) {
            echo "<script language='JavaScript'> alert('" . $mail->ErrorInfo . "'); </script>";
        }
    }
}
