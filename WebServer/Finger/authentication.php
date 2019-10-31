<?php
session_start();

include "dbconfig.php";

if ( !isset($_POST['username'], $_POST['password']) ) {
	die ('Please fill both the username and password field!');
}
// Prepare for preventing SQL injection. This is very important , guys, this makes a little trouble for hackers ,hkhk
if ($stmt = $conn->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
	$stmt->bind_result($id, $password);
	$stmt->fetch();
	// Account exists, now we verify the password.
	
	if (password_verify($_POST['password'], $password)) {
		// Verification success! User has loggedin!
		// Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $_POST['username'];
		$_SESSION['id'] = $id;
		header('Location: home.php');	} 
		else {
		echo 'Incorrect password!';
	}
} else {
	echo 'Incorrect username!';
}
$stmt->close();
}
?>