<!DOCTYPE html>

<html>

<head>

<title>View Records</title>

</head>

<body>



<?php

/*

VIEW.PHP

Displays all data from 'players' table

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

// ...some PHP code for database "my_db"...

// Change database to "test"
//mysqli_select_db($connection,"Main");


// get results from database

$result = mysqli_query($connection, "SELECT * FROM dictionary;");

// display data in table

echo "<p><b>View All</b> | <a href='view-paginated.php?page=1'>View Paginated</a></p>";



echo "<table border='1' cellpadding='10'>";

echo "<tr> <th>ID</th> <th>Word</th> <th>Definition</th> <th>First Chapter</th> <th></th> <th></th> </tr>";


// loop through results of database query, displaying them in the table

while($row = mysqli_fetch_array( $result, MYSQLI_ASSOC)) {



// echo out the contents of each row into a table

echo "<tr>";

echo '<td>' . $row['word_id'] . '</td>';

echo '<td>' . $row['word'] . '</td>';

echo '<td>' . $row['definition'] . '</td>';
    
echo '<td>' . $row['first_chapter'] . '</td>';

echo '<td><a href="edit.php?id=' . $row['word_id'] . '">Edit</a></td>';

echo "<td><a href=\"delete.php?id=" . $row['word_id'] . "\">Delete</a></td>";

echo "</tr>";

}

?>
<form action=new.php method="post">

<div>
<tr>
<td></td>
<td>
    <strong>Word: *</strong> <input type="text" style="width:100%;" name="word" value="<?php echo $first; ?>" />
</td>
<td>
    <strong>Definition: *</strong> <input type="text" style="width:100%;" name="definition" value="<?php echo $last; ?>" />
</td>

<td>
    <strong>First Chapter: *</strong> <input type="text" style="width:100%;" name="firstChapter" value="<?php echo $last; ?>" />
</td>
</tr>
    
<?php echo "</table>"; ?>
    
<p>* required</p>

<input type="submit" name="submit" value="Submit">

</div>

</form>


<!--<p><a href="new.php">Add a new record</a></p>-->



</body>

</html>