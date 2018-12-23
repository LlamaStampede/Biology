<?php
    session_start();
    if (isset($_SESSION['perms']) && $_SESSION['perms'] == "2") {
        echo "<script> alert('you are allowed here') </script>";
    }
    else {
        if (isset($_SESSION['allowed']) && $_SESSION['allowed'] == true) {
            echo "<script> window.location.replace('/Biology/') </script>";
        }
        else {

            echo "<script> window.location.replace('/Biology/Login/') </script>";
        }
    }
?>
<!Doctype html>
<html>
    <body>
        <?php

            $server = 'sql9.freemysqlhosting.net';
            $user = 'sql9262759';
            $pass = '4fE3cl8Jqm';
            $db = 'sql9262759';
            $connection = mysqli_connect($server, $user, $pass, $db);
        
            $result = mysqli_query($connection, "SELECT email, active, permissions FROM Users;");
            echo "<table style='width:100%'><tr><th>Email</th><th>Active</th><th>Permission Level</th></tr>";
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<tr>";
                echo "<th>" . $row['email'] . "</th>";
                echo "<th>" . $row['active'] . "</th>";
                echo "<th>" . $row['permissions'] . "</th>";
                echo "</tr>";
            }
            echo "</table>";
        ?>
    </body>
</html>