<?php
    session_start();
    if (isset($_SESSION['allowed']) && $_SESSION['allowed'] == true) {
        //echo "<script> alert('you are logged in') </script>";
    }
    else {
        $_SESSION['message'] = "Please Log in or Sign up";
        echo "<script> window.location.replace('/Biology/Login/') </script>";
    }

	$classCookie = 1;
	if(isset($_COOKIE["classCookie"])) {
		$classCookie = $_COOKIE["classCookie"];
	}

	$userID;
	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION["userID"];
	}
?>
<!Doctype html>
<html>
    <body>
        <?php
            $id = $_GET['id'];
        
            $server = 'sql9.freemysqlhosting.net';
            $user = 'sql9262759';
            $pass = '4fE3cl8Jqm';
            $db = 'sql9262759';
            $connection = mysqli_connect($server, $user, $pass, $db);
        
            $result = mysqli_query($connection, "SELECT text, linebreaks FROM NotesData WHERE id = '$id' AND ClassID = '$classCookie' AND UserID = '$userID';");
            echo "ID: $id";
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "NEXT";
                echo $row['text'];
                echo "NEXT";
                echo $row['linebreaks'];
                echo "NEXT";
            }
        ?>
    </body>
</html>