<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class sendController extends Controller {

	public function sendEmail (Request $request) {

  	// is method a POST ?
  	if($request->isMethod('post')) {
															// load Composer's autoloader

			$mail = new PHPMailer(true);                            // Passing `true` enables exceptions

			try {
				// Server settings
	    	$mail->SMTPDebug = 2;                                	// Enable verbose debug output
				$mail->isSMTP();                                     	// Set mailer to use SMTP
				//$mail->SMTP = true;											// Specify main and backup SMTP servers
				$mail->SMTPAuth = true; 
				$mail->SMTPKeepAlive = true;   
				$mail->Mailer = "smtp"; // don't change the quotes!    
				$mail->Host = 'smtp.office365.com';	                         	// Enable SMTP authentication
				$mail->Username = 'email@carvajal.com';             // SMTP username
				$mail->Password = '';              // SMTP password
				//$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587;                                    // TCP port to connect to
				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);

				//Recipients
				$mail->setFrom('cavasdyw@gmail.com', 'Mailer');
				$mail->addAddress('shamir.saa@carvajal.com', 'Shamir Saa');	// Add a recipient, Name is optional
				$mail->addReplyTo('shamirsaa@gmail.com', 'Mailer');
				// $mail->addCC('his-her-email@gmail.com');
				// $mail->addBCC('his-her-email@gmail.com');

				//Attachments (optional)
				// $mail->addAttachment('/var/tmp/file.tar.gz');			// Add attachments
				// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');	// Optional name

				//Content
				$mail->isHTML(true); 																	// Set email format to HTML
				$mail->Subject = $request->input('subject');
				$mail->Body    = $request->input('message');						// message

				$mail->send();
				return 'Message has been sent!';
			} catch (Exception $e) {
				return 'Message could not be sent'.$mail->ErrorInfo;;
			}
		}
    	//return view('phpmailer');
  }
} 