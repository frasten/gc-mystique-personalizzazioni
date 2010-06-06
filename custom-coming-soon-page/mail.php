<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$email = $_REQUEST['semail'];
$sto = $_REQUEST['sto'];
$subject = $_REQUEST['ssubject'];
$thankyou = $_REQUEST['sthankyou'];
if($email != "" || $email != "Enter your email address"){
	$to = $sto;
	$subject = "{$subject}";
	$headers = "From: {$email}\r\n";
	$headers .= "Reply-To: {$email}\r\n";
	$headers .= "Return-Path: {$email}\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$msg = '
	A user has subscribed to Launch Announcement email list. Please save this email address.<br />
	<b>Email:</b> '.$email.'
	';
	$message = "<html><body>";
	$message .= $msg;
	$message .= "</body></html>";

	if (mail($to, $subject, $message, $headers)) {
	    echo "<b>".$thankyou."</b>";
	} else {
	    echo 'Something went wrong! Please try to send this message again.';
	}
}
?>