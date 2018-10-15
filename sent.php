<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';



$sender=$_POST['sender'];
$password=$_POST['senderpass'];
$receiver=$_POST['receiver'];
$cc=$_POST['cc'];
$bcc=$_POST['bcc'];
$subject=$_POST['subject'];
$body=$_POST['body'];
//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
   // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'ssl://smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = "$sender";                 // SMTP username
    $mail->Password = "$password";                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to
    //Recipients
    $mail->setFrom("$sender", "$sender");
    $mail->addAddress("$receiver", 'receiver');     // Add a recipient
 //   $mail->addReplyTo('info@example.com', 'Information');
    for($x=1;$x<=$cc;$x++)
    {
        $abc="cc".$x;
        $xyz=$_POST["$abc"];
        $mail->addCC("$xyz");

    }
    for($x=1;$x<=$bcc;$x++)
    {
        $abc="bcc".$x;
       $xyz=$_POST["$abc"];
        $mail->addBCC("$xyz");
    }
    $var=$_POST["uploaded_file"];
    $mail->AddAttachment("$var",'attachment');
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = "$subject";
    $mail->Body    = "$body";
   // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo "<script>alert('Message has been sent');window.location.assign('index.html');</script>";
} catch (Exception $e) {
    echo "<script>alert('Message could not be sent. Mailer Error: $mail->ErrorInfo;');window.location.assign('index.html');</script>";

}
