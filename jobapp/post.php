<?php
if(!$_POST['review-info']) exit('silence is golden :)');
require_once('./config.php');

$content = $_POST['review-info'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host       = 'mail.wholeroute.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'triprequests@wholeroute.com';
    $mail->Password   = 'ChickenWings1989!';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    
    //Recipients
    $mail->setFrom('triprequests@wholeroute.com', 'WholeRoute');
    foreach($sendApplicationTo as $x) $mail->addAddress($x);
    if($_POST['email']!='') {
        $mail->ClearReplyTos();
        $mail->addReplyTo($_POST['email'], $_POST['first-name'].' '.$_POST['last-name']);
    }
    //Content
    $mail->isHTML(true);
    $mail->Subject = 'New Job Application From '.$_POST['first-name'].' '.$_POST['last-name'];
    $mail->Body = $content;
    if($_FILES['resume']['name']) {
        $mail->AddAttachment($_FILES['resume']['tmp_name'], $_FILES['resume']['name']);
    }
    $mail->send();
    echo 'success';
    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>