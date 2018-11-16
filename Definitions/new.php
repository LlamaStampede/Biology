<?php

/*

NEW.PHP

Allows user to create a new entry in the database

*/



// creates the new record form

// since this form is used multiple times in this file, I have made it a function that is easily reusable

function renderForm($word, $definition, $firstChapter, $error)

{

?>

<!DOCTYPE html>

<html>

<head>

<title>New Record</title>

</head>

<body>

<?php

// if there are any errors, display them

if ($error != '') {

echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';

}

?>



<form action="" method="post">

<div>

<strong>Word: *</strong> <input type="text" name="word" value="<?php echo $first; ?>" /><br/>

<strong>Definition: *</strong> <input type="text" name="definition" value="<?php echo $last; ?>" /><br/>
    
<strong>First Chapter: *</strong> <input type="text" name="firstChapter" value="<?php echo $last; ?>" /><br/>

<p>* required</p>

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


// check if the form has been submitted. If it has, start to process the form and save it to the database

if (isset($_POST['submit'])) {

// get form data, making sure it is valid

$word = $_POST['word'];
$definition = $_POST['definition'];
$firstChapter = $_POST['firstChapter'];

// check to make sure both fields are entered

if ($word == '' || $definition == '' || firstChapter == '') {

// generate error message

$error = 'ERROR: Please fill in all required fields!';


// if either field is blank, display the form again

renderForm($word, $definition, $firstChapter, $error);

}

else {


mysqli_query($conn, "INSERT dictionary SET word='" . addslashes($word) . "', definition='" . addslashes($definition) . "', first_chapter='$firstChapter';");



// once saved, redirect back to the view page

header("Location: index.php");

}
}

else

// if the form hasn't been submitted, display the form

{

renderForm('','','','');

}

?>