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
            $type = $_GET['type'];
        
            $server = 'sql9.freemysqlhosting.net';
            $user = 'sql9262759';
            $pass = '4fE3cl8Jqm';
            $db = 'sql9262759';
            $connection = mysqli_connect($server, $user, $pass, $db);
        
            $result = mysqli_query($connection, "SELECT UserID FROM ClassUsers WHERE ClassID = '$classCookie' AND UserID <> '$userID';");
		
			$userID = array();
			$increment = 0;
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $userID[$increment] = $row['UserID'];
                $increment++;
            }
			
			$where = "";
			for ($i=0; $i<count($userID); $i++) {
				if ($i != 0) {
					$where .= "OR ";
				}
				$where .= "id = '$userID[$i]' ";
			}
			$emails = mysqli_query($connection, "SELECT id, email FROM Users WHERE $where");
			while($row = mysqli_fetch_array($emails, MYSQLI_ASSOC)) {
                $email = explode("@", $row['email'])[0];
				$id = $row['id'];
                echo "<div class='students' data-userid='$id' onclick='loadON(this)'> $email </div> ";
            }
        ?>
    </body>
</html>