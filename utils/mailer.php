<?php

function sendEmail($sendEmail, $first_name, $subject, $message)
{
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP(); // using SMTP protocol                                     
        $mail->Host = MAIL_HOST; // SMTP host as gmail 
        $mail->SMTPAuth = true;  // enable smtp authentication                             
        $mail->Username = MAIL_USERNAME;  // sender gmail host              
        $mail->Password = MAIL_PASSWORD; // sender gmail host password                          
        $mail->SMTPSecure = MAIL_ENCRYPTION;  // for encrypted connection                           
        $mail->Port = intval(MAIL_PORT);   // port for SMTP     

        $mail->setFrom("info@phira.com", "Phira"); // sender's email and name
        $mail->addAddress($sendEmail, $first_name);  // receiver's email and name

        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();


        echo 'Message has been sent';
    } catch (Exception $e) { // handle error.
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

sendEmail('info@phira.com', 'Quinn Hyatt', 'Test', 'Test');
