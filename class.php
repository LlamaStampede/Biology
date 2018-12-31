<?php
    session_start();
    if (isset($_SESSION['allowed']) && $_SESSION['allowed'] == true) {
        //echo "<script> alert('you are logged in') </script>";
    }
    else {
        $_SESSION['message'] = "Please Log in or Sign up";
        echo "<script> window.location.replace('/Biology/Login/') </script>";
    }

	$classCookie;
	if(isset($_COOKIE["classCookie"])) {
		$classCookie = $_COOKIE["classCookie"];
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
            $type = "";
            if (isset($_GET['type'])) {
                $type = $_GET['type'];
            }
            if ($type == "mostRecent") { //SELECT row FROM table ORDER BY id DESC LIMIT 1
				$email = $_SESSION['email'];
                $userID = mysqli_query($connection, "SELECT id FROM Users WHERE email = '$email'");
                $personalID = NULL;
				while($row = mysqli_fetch_array($userID, MYSQLI_ASSOC)) {
                    $personalID = $row['id'];
                }
				//echo "PersonalID: " . $personalID;
                $class = mysqli_query($connection, "SELECT Name, Description, CreatorID, ClassID FROM Classes;");
                while($row = mysqli_fetch_array($class, MYSQLI_ASSOC)) {
                    $name = $row['Name'];
                    $desc = $row['Description'];
                    $creatorID = $row['CreatorID'];
                    $classID = $row['ClassID'];
                    $creator;
                    $theUser = mysqli_query($connection, "SELECT email FROM Users WHERE id = '" . $creatorID . "';");
                    while($row = mysqli_fetch_array($theUser, MYSQLI_ASSOC)) {
                        $creator = explode("@", $row['email'])[0];
                    }
					$joinSearch = mysqli_query($connection, "SELECT id FROM ClassUsers WHERE ClassID = '" . $classID . "' AND UserID = '" . $personalID . "';");
					$joined = "false";
                    if (mysqli_num_rows($joinSearch) > 0) {
						$joined = "true";
					}
                    echo "<div class='resultedClass pointer' data-classID='$classID' data-joined='$joined' onclick='joinClass(this)'> &#9673 $name - $desc - Created by: $creator</div>";
                }
            }
            elseif ($type == "form") {
                if ($_GET['createIt'] == "Cancel") {
                    echo "<script> window.location.replace('/Biology/') </script>";
                    exit();
                }
                echo "Sent: " . "SELECT id FROM Users WHERE email='" . $_SESSION['email'] . "'";
                $getCreatorID = mysqli_query($connection, "SELECT id FROM Users WHERE email='" . $_SESSION['email'] . "'");
                $creatorID = "";
                while($row = mysqli_fetch_array($getCreatorID, MYSQLI_ASSOC)) {
                    $creatorID = $row['id'];
                }
                $name = $_GET['name'];
                $desc = $_GET['description'];
                
                $makeClass = mysqli_query($connection, "INSERT INTO Classes (Name, Description, CreatorID) VALUES ('$name', '$desc', '$creatorID');");
                $getClassID = mysqli_query($connection, "SELECT ClassID FROM Classes WHERE name='" . $name . "' AND Description='" . $desc . "' AND CreatorID='" . $creatorID . "' ");
                $classID = "";
                while($row = mysqli_fetch_array($getClassID, MYSQLI_ASSOC)) {
                    $classID = $row['ClassID'];
                }
                
                $makeClass = mysqli_query($connection, "INSERT INTO ClassUsers (ClassID, UserID) VALUES ('$classID', '$creatorID');");
                
                echo "<script> window.location.replace('/Biology/') </script>";
            }
			elseif ($type == "add") {
				$classID = $_GET['classID'];
				$userID = $_SESSION['userID'];
				$addToClass = mysqli_query($connection, "INSERT INTO ClassUsers (ClassID, UserID) VALUES ('$classID', '$userID');");
			}
			elseif ($type == "search") {
				$text = urldecode($_GET['words']);
				$name; $desc;
				
				$userID = mysqli_query($connection, "SELECT id, email FROM Users WHERE LOWER(email) LIKE LOWER('%$text%') AND id IN
(
SELECT CreatorID FROM Classes
);");
				$emailList = array();
				$idList = array();
				while($row = mysqli_fetch_array($userID, MYSQLI_ASSOC)) {
					array_push($emailList, $row['email']);
					array_push($idList, $row['id']);
					//echo "First While loop";
				}
				//echo explode("@", $email)[0];
				//echo "Length of email List: " . count($emailList);
				$userIDList = array();
				for ($i=0;$i<count($emailList);$i++) {
					//echo "First For loop";
					$email = $emailList[$i];
					if (strpos(explode("@", $email)[0], strtolower($text)) !== false) {
						//echo "<br>" . strtolower($text) . " is in " . explode("@", $email)[0];
						array_push($userIDList, $idList[$i]);
					}
					else {
						//echo "<br>" . strtolower($text) . " is not in " . explode("@", $email)[0];
					}
				}
				
				$longUserIdString;
				for ($i=0;$i<count($userIDList);$i++) {
					//echo "Second For loop";
					$longUserIdString .= "CreatorID = '$userIDList[$i]' OR "; 
				}
				$longUserIdString = substr($longUserIdString, 0, -3) . ";";
				//echo "UserIdString: " . $longUserIdString;
				$where = array("LOWER(Name) LIKE LOWER('%$text%');", "LOWER(Description) LIKE LOWER('%$text%');", $longUserIdString);
				
				$arrayOfResults = array();
			
				for ($i=0;$i<3;$i++) {
					$searchResults = mysqli_query($connection, "SELECT Name, Description, CreatorID, ClassID FROM Classes WHERE " . $where[$i]);
					//echo "Sent: " . "SELECT Name, Description, CreatorID, ClassID FROM Classes WHERE " . $where[$i] . "<br>";
					while($row = mysqli_fetch_array($searchResults, MYSQLI_ASSOC)) {
						$name = $row['Name'];
						$desc = $row['Description'];
						$creatorID = $row['CreatorID'];
						$classID = $row['ClassID'];
						$creator;
						$theUser = mysqli_query($connection, "SELECT email FROM Users WHERE id = '" . $creatorID . "';");
						while($row = mysqli_fetch_array($theUser, MYSQLI_ASSOC)) {
							$creator = explode("@", $row['email'])[0];
						}
						$joinSearch = mysqli_query($connection, "SELECT id FROM ClassUsers WHERE ClassID = '" . $classID . "' AND UserID = '" . $creatorID . "';");
						$joined = "false";
						if (mysqli_num_rows($joinSearch) > 0) {
							$joined = "true";
						}
						//$arrayTwo = array("<a class='highlight'>$name</a> - $desc", "$name - <a class='highlight'>$desc</a>", "$name - $desc");
						//$arrayThree = array("$creator", "$creator", "<a class='highlight'>$creator</a>");
						$newClass = true;
						for ($j=0;$j<count($arrayOfResults);$j++) {
							if ($arrayOfResults[$j][0] == $classID) {
								//echo "<br>IN HERE<br>";
								$arrayOfResults[$j][2] .= strval($i);
								$newClass = false;
							}
						}
						if ($newClass) {
							array_push($arrayOfResults, array($classID, $joined, strval($i), $name, $desc, $creator));
						}
					}
				}
				for ($i=0;$i<count($arrayOfResults);$i++) {
					$a = $arrayOfResults[$i];
					//echo "J2: $a[2]";
					$listOfI = str_split($a[2]); $name = $a[3]; $desc = $a[4]; $creator = $a[5];
					for ($j=0;$j<count($listOfI);$j++) {
						//echo "<br>J:$listOfI[$j]<br>";
						if ($listOfI[$j] == 0) {
							$name = "<a class='highlight'>$name</a>";
						}
						if ($listOfI[$j] == 1) {
							$desc = "<a class='highlight'>$desc</a>";
						}
						if ($listOfI[$j] == 2) {
							$creator = "<a class='highlight'>$creator</a>";
						}
					}
					echo "<div class='resultedClass pointer' data-classid='$a[0]' data-joined='$a[1]' onclick='joinClass(this)'> &#9673 $name - $desc - Created by: $creator </div>";
				}
				
			}
			elseif ($type == "leave") {
				$classID = $_GET['classID'];
				$userID = $_SESSION['userID'];
				$addToClass = mysqli_query($connection, "DELETE FROM ClassUsers WHERE ClassID = '$classID' AND UserID = '$userID';");
			}
            else {
                $email = $_SESSION['email'];
                

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
						$extraData = ""; $extraClass = "";
						if ($classCookie != NULL && $classCookie == $resultArray[$i]) {
							$extraData = " data-selectedclass='true'"; $extraClass = " cookieClass";
						}
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
                        echo "<div class='resultedClass pointer$extraClass' data-classid='$resultArray[$i]'$extraData onclick='clickedTopClass(this)'> &#9673 $name - $desc - Created by: $creator</div>";
                    }
                }  
            }
        ?>
    </body>
</html>
