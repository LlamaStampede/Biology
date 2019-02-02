<?php


	session_start();
    $email = $_GET['email'];

	 $server = 'sql9.freemysqlhosting.net';
            $user = 'sql9262759';
            $pass = '4fE3cl8Jqm';
            $db = 'sql9262759';
            $connection = mysqli_connect($server, $user, $pass, $db);
	
	if (isset($_GET['hash'])) {
		$hash = $_GET['hash'];

		$check = mysqli_query($connection, "SELECT * FROM Users WHERE email='$email' AND hash='$hash';");
        if (mysqli_num_rows($check) > 0) {
			echo "Checked out";
			
			//Here add a passcode text box to update pass and hash
		}
		else {
			$_SESSION['message'] = "Incorrect Information!";
			echo "not";
        	///header('Location: index.php');
		}
	}
	else {
		if ($email == null) {
			 $_SESSION['message'] = "Please enter an email!";
			//header('Location: index.php');
		}

		//check if email is already used
		$existing = mysqli_query($connection, "SELECT * FROM Users WHERE email='$email'");
		if (mysqli_num_rows($existing) > 0) {

			$getHash = mysqli_query($connection, "SELECT hash FROM Users WHERE email='$email'");
			$hash = mysqli_fetch_assoc($getHash)['hash'];

			$to = $email;
			$subject = 'Biology Notes for ' . $name;
			$from = 'admin@classknowtes.com';

			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			// Create email headers
			$headers .= 'From: '.$from."\r\n".
				'Reply-To: '.$from."\r\n" .
				'X-Mailer: PHP/' . phpversion();

			// Compose a simple HTML email message
			$message = "<html> <body> <h1>Hello!</h1> <p>Click this link to reset your password</p><br> <a href='llamastampede.com/Biology/Login/forgot.php?email=$email&hash=$hash'>link</a><br> </body> </html>";

			// Sending email
			if(mail($to, $subject, $message, $headers)){
				echo 'Your mail has been sent successfully.';
			} else{
				echo 'Unable to send email. Please try again.';
			}

			$_SESSION['message'] = "An email to reset your password has been sent";
		}
		else {
			//console.log("<script> alert($email); </script>");
			$_SESSION['message'] = "That email: $email isn't found. Please check it is spelled correctly";
			header('Location: index.php');
		}
	}
?>
