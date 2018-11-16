<?php

/*

DELETE.PHP

Deletes a specific entry from the 'players' table

*/



// connect to the database

$server = 'sql9.freemysqlhosting.net';

$user = 'sql9262759';

$pass = '4fE3cl8Jqm';

$db = 'sql9262759';


// Connect to Database

$connection = mysqli_connect($server, $user, $pass, $db);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }



// check if the 'id' variable is set in URL, and check that it is valid

if (isset($_GET['id']) && is_numeric($_GET['id']))

{

// get id value

$id = $_GET['id'];

// delete the entry

$result = mysqli_query($connection, "DELETE FROM dictionary WHERE word_id='$id';");




// redirect back to the view page

header("Location: index.php");

}

//else

// if id isn't set, or isn't valid, redirect back to view page

//{

header("Location: index.php");

//}



?>