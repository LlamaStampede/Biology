<?php

/*

CONNECT-DB.PHP

Allows PHP to connect to your database

*/



// Database Variables (edit with your own server information)

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



?>