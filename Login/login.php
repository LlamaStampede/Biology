<?php

    $_SESSION['email'] = test_input($_POST['email']);

    $password = test_input($_POST['password']);
    $email = test_input($_POST['email']);

    

    $existing = mysqli_query($connection, "SELECT * FROM Users WHERE email = '$email';");
    if (mysqli_num_rows($existing) > 0) { //check if there is a user with this email
        $data = mysqli_fetch_assoc($existing);
        if (password_verify($password, $data['password'])) {
            if ($data['active'] != 0) {
                $_SESSION['allowed'] = true;
                $_SESSION['perms'] = $data['permissions'];
                include 'db.php';
                $result = mysqli_query($connection, "INSERT INTO Users (email, change) VALUES ('$email','Logged In!');");
                
                echo "<script> window.location.replace('../'); </script>";
            }
            else {
                $_SESSION['message'] = "Please activate your account by checking your email for a activation link";
                echo "<script> window.location.replace('index.php'); </script>";
            }
            
        }
        else {
            $_SESSION['message'] = "Incorrect password";
            echo "<script> window.location.replace('index.php'); </script>";
        }
    }
    else {
        $_SESSION['message'] = "Incorrect email OR the database is down, sorry";
        header('Location: index.php');
    }

?>