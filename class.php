<?php
    session_start();
    if (isset($_SESSION['allowed']) && $_SESSION['allowed'] == true) {
        //echo "<script> alert('you are logged in') </script>";
    }
    else {
        $_SESSION['message'] = "Please Log in or Sign up";
        echo "<script> window.location.replace('/Biology/Login/') </script>";
    }
?>
<!Doctype html>
<html>
    <body>
        <?php
            $email = $_GET['email'];
            echo "<script>alert('here');</script>";
            $server = 'sql9.freemysqlhosting.net';
            $user = 'sql9262759';
            $pass = '4fE3cl8Jqm';
            $db = 'sql9262759';
            $connection = mysqli_connect($server, $user, $pass, $db);
        
            $userID = mysqli_query($connection, "SELECT id FROM Users WHERE email = '$email'");
            $userID = mysqli_fetch_assoc($userID)['id'];
        
            $result = mysqli_query($connection, "SELECT ClassID FROM ClassUsers WHERE UserID = '$userID';");
        
            $resultArray = array();
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    array_push($resultArray, $row['ClassID']);
                }
            }
            else {
                echo "You aren't in any classes";
            }
            
            if (count($resultArray) > 0) {
                for ($i=0;$i<count($resultArray);$i++) {
                    $class = mysqli_query($connection, "SELECT Name, Description, CreatorID FROM Classes WHERE ClassID = '" . $resultArray[$i] . "';");
                    $name; $desc; $creatorID; $creator;
                    while($row = mysqli_fetch_array($class, MYSQLI_ASSOC)) {
                        $name = $row['Name'];
                        $desc = $row['Description'];
                        $creatorID = $row['CreatorID'];
                    }
                    $theUser = mysqli_query($connection, "SELECT email FROM Users WHERE id = '" . $creatorID . "';");
                    while($row = mysqli_fetch_array($theUser, MYSQLI_ASSOC)) {
                        $creator = explode("@", $row['email'])[0];
                    }
                    echo "<div id='resultedClass'>$name - $desc - Created by: $creator</div>";
                }
            }
        ?>
    </body>
</html>