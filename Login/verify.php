<?php
    session_start();
    include 'db.php';
?>
<!Doctype html>
<html>
    <body>
        <?php
            if (isset($_GET['email']) && isset($_GET['hash'])) {
                $email = $_GET['email'];
                $hash = $_GET['hash'];
                $check = mysqli_query($connection, "SELECT * FROM Users WHERE email='$email' AND hash='$hash';");
                if (mysqli_num_rows($check) > 0) {
                    $perm = 0;
                    if (explode("@", $email)[1] == "shipleyschool.org") {
                        $perm = 2;
                    }
                    else {
                        $perm = 1;
                    }
                    $update = mysqli_query($connection, "UPDATE Users SET active = 1, permissions = $perm WHERE email='$email';");
                    $_SESSION['message'] = "You have successfully activated your account. Happy studying!";
                    $_SESSION['allowed'] = true;
                    echo "<script> window.location.replace('../'); </script>";
                }
            }
            else {
                header('Location: index.php');
            }
        ?>
    </body>
</html>