<?php
    session_start();
    if (isset($_SESSION['allowed']) && $_SESSION['allowed'] == true) {
        //echo "<script> alert('you are logged in') </script>";
    }
    else {
        $_SESSION['message'] = "Please Log in or Sign up";
        echo "<script> window.location.replace('/Biology/Login/') </script>";
    }

    
    $email = $_GET['email'];
    $change = $_GET['change'];
    if (!isset($_GET['email']) && !isset($_GET['change'])) {
        echo "<script> window.location.replace('/Biology/Login/') </script>";
    }
    //echo "<script> alert('in log.php, Email:$email Change:$change'); </script>";
    $server = 'sql9.freemysqlhosting.net';
    $user = 'sql9262759';
    $pass = '4fE3cl8Jqm';
    $db = 'sql9262759';
    $connection = mysqli_connect($server, $user, $pass, $db);
    //echo "up top<br>";

    $userID = mysqli_query($connection, "SELECT id FROM Users WHERE email = '$email'");
    $userID = mysqli_fetch_assoc($userID)['id'];
    //echo "<script> alert('$userID'); </script>";
    $result = mysqli_query($connection, "INSERT INTO Logs (userId, `change`) VALUES ('$userID','$change');");
    /*$test = mysqli_query($connection, "SELECT * FROM Logs;");
    while($row = mysqli_fetch_array($test, MYSQLI_ASSOC)) {
        echo $row['userId'];
    }*/
    echo "at bottom";
    echo "<script> history.go(-1) </script>";

?>