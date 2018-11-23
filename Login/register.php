<?php

    $_SESSION['email'] = test_input($_POST['email']);
    $_SESSION['name'] = test_input($_POST['name']);

    $email = test_input($_POST['email']);
    $name = test_input($_POST['name']);
    $cPassword = test_input($_POST['cPassword']);
    $password = test_input($_POST['password']);
    if ($password != $cPassword) {
        $_SESSION['message'] = "Passwords do not match!";
        header('Location: index.php');
    }
    else {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $hash = test_input(md5(rand(0,1000)));

    

    //check if email is already used
    $existing = mysqli_query($connection, "SELECT * FROM Users WHERE email='$email'");
    if (mysqli_num_rows($existing) == 0) {
        $insert = mysqli_query($connection, "INSERT INTO Users (email, password, hash) VALUES ('$email', '$password', '$hash');");

        $to = $email;
        $subject = 'Biology Notes for ' . $name;
        $from = 'biologynotes@email.com';

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Create email headers
        $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // Compose a simple HTML email message
        $message = "<html> <body> <h1>Hello!</h1> <p>Someone has used your email to register on llamastampede.com.</p><br><p>To verify that you submitted the registration form, please click this <a href='llamastampede.com/Biology/Login/verify.php?email=$email&hash=$hash'>link</a><br><p>If you did not submit a registration form, please click this <a href='llamastampede.com/Biology/Login/remove.php?email=$email&hash=$hash'>link</a> to remove your email from the database</body> </html>";

        // Sending email
        if(mail($to, $subject, $message, $headers)){
            echo 'Your mail has been sent successfully.';
        } else{
            echo 'Unable to send email. Please try again.';
        }
        
        $_SESSION['message'] = "Thank you, $name, for signing up. Please check your email to activate your account.";
    }
    else {
        $_SESSION['message'] = "That email is already in use, try logging in or reseting your password";
        header('Location: index.php');
    }
    }
?>
