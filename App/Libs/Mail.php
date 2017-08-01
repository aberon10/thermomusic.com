<?php

namespace App\Libs;

use PHPMailer;

class Mail
{	
	private $email = ''; 
	private $name = ''; 
	private $subject = ''; 
	private $content = ''; 
	private $alt_message = '';

	public function __construct($email, $name, $subject, $content, $alt_message) {
		$this->email = $email;
		$this->name = $name;
		$this->subject = $subject;
		$this->content = $content;
		$this->alt_message = $alt_message;
	}

	/**
	 * send
	 * @return boolean
	 */
	public function send() {
		try {
			$mail = new PHPMailer;

			// Set mailer to use SMTP
			$mail->isSMTP();

			// Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail->SMTPDebug = 0;

			//Ask for HTML-friendly debug output
			//$mail->Debugoutput = 'html';

			// Set the hostname of the mail server 							
			$mail->Host = getenv('SMTP_HOST');

			// TCP port to connect to		
			$mail->Port = getenv('SMTP_PORT');

			// Set the encryption system to use
			$mail->SMTPSecure = 'tls';

			// Whether to use SMTP authentication					
			$mail->SMTPAuth = true;

			// Username to use for SMTP authentication 				
			$mail->Username = getenv('SMTP_USER');

			// Password to use for SMTP authentication		
			$mail->Password = getenv('SMTP_PASS');

			// Set who the message is to be sent from
			$mail->setFrom(getenv('APP_CONTACT_EMAIL'), getenv('APP_NAME'));

			// Set an alternative reply-to address 	  
			$mail->addReplyTo(getenv('APP_CONTACT_EMAIL'), getenv('APP_NAME'));

			// Set who the message is to be sent to  
			$mail->addAddress($this->email, $this->name);

			//Set the subject line
			$mail->Subject = $this->subject;

			// Read an HTML message body from an external file, convert referenced images to embedded,
			// convert HTML into a basic plain-text alternative body
			$mail->msgHTML($this->content);

			// Replace the plain text body with one created manually
			$mail->AltBody = $this->alt_message;

			// send the message, check for errors
			if (!$mail->send()) {
			    return 'Mailer Error: '.$mail->ErrorInfo;
			} else {
			    return true;
			}
		} catch (\phpmailerException $e) {
			die($e->errorMessage());
		}
	}
}