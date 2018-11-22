<?php

    $_SESSION['email'] = test_input($_POST['email']);

    $password = test_input($_POST['password']);

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    $existing = mysqli_query($connection, "SELECT * FROM Users;");// WHERE email='$email';");
    if (mysqli_num_rows($existing) > 0) { //check if there is a user with this email
        $data = mysqli_fetch_assoc($existing);
        if (password_verify($password, $data['password'])) {
            if ($data['active'] != 0) {
                $_SESSION['allowed'] = true;
                echo "<script> window.location.replace('../'); </script>";
            }
            else {
                $_SESSION['message'] = "Please verify your account";
                echo "<script> window.location.replace('index.php'); </script>";
            }
            
        }
        else {
            $_SESSION['message'] = "Incorrect password <br> pass: " . $password . "<br> dbpass: " . $data['password'];
            echo "<script> window.location.replace('index.php'); </script>";
        }
    }
    else {
        $_SESSION['message'] = "Incorrect email" . mysqli_num_rows($existing);
        header('Location: index.php');
    }

?>