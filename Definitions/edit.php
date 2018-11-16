<?php

/*

EDIT.PHP

Allows user to edit specific entry in database

*/



// creates the edit record form

// since this form is used multiple times in this file, I have made it a function that is easily reusable

function renderForm($id, $word, $definition, $firstChapter, $error)

{

?>

<!DOCTYPE html>

<html>

<head>

<title>Edit Record</title>

</head>

<body>

<?php

// if there are any errors, display them

if ($error != '')

{

echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';

}

?>



<form action="" method="post">

<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<div>

<p><strong>ID:</strong> <?php echo $id; ?></p>

<strong>Word: *</strong> <input type="text" name="word" value="<?php echo $word; ?>" /><br/>

<strong>Definition: *</strong> <input type="text" name="definition" value="<?php echo $definition; ?>" /><br/>
    
<strong>First Chapter: *</strong> <input type="text" name="firstChapter" value="<?php echo $firstChapter; ?>" /><br/>

<p>* Required</p>

<input type="submit" name="submit" value="Submit">

</div>

</form>

</body>

</html>

<?php

}







// connect to the database

$server = 'sql9.freemysqlhosting.net';
$user = 'sql9262759';
$pass = '4fE3cl8Jqm';
$db = 'sql9262759';

// Connect to Database

$conn = mysqli_connect($server, $user, $pass, $db);

if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}



// check if the form has been submitted. If it has, process the form and save it to the database

if (isset($_POST['submit']))

{

// confirm that the 'id' value is a valid integer before getting the form data

if (is_numeric($_POST['id']))

{

// get form data, making sure it is valid

$id = $_POST['id'];

$word = $_POST['word'];
$definition = $_POST['definition'];
$firstChapter = $_POST['firstChapter'];



// check that firstname/lastname fields are both filled in

if ($word == '' || $definition == '' || $firstChapter == '') 

{

// generate error message

$error = 'ERROR: Please fill in all required fields!';



//error, display form

renderForm($id, $word, $definition, $firstChapter, $error);

}

else

{

// save the data to the database

mysqli_query($conn, "UPDATE dictionary SET word='" . addslashes($word) . "', definition='" . addslashes($definition) . "', first_chapter='$firstChapter' WHERE word_id='$id';");



// once saved, redirect back to the view page

header("Location: index.php");

}

}

else

{

// if the 'id' isn't valid, display an error

echo 'Error!';

}

}

else

// if the form hasn't been submitted, get the data from the db and display the form

{



// get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)

if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)

{

// query db

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM dictionary WHERE word_id='$id';");

$row = mysqli_fetch_array($result);

// check that the 'id' matches up with a row in the databse

if($row)

{



// get data from db

$word = $row['word'];

$definition = $row['definition'];

$firstChapter = $row['first_chapter'];

// show form

renderForm($id, $word, $definition, $firstChapter, '');

}

else

// if no match, display result

{

echo "No results!";

}

}

else

// if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error

{

echo 'Error!';

}

}

?>