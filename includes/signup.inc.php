<!-- 

Alexander Murie
12/08/2018
Eagleweb


Controller
 -->

<?php

if (isset($_POST['submit'])) { /*check if submit button was clicked - stops bypassing via url */
	include_once 'dbh.inc.php';

	
	$first = mysqli_real_escape_string($conn, $_POST['first']); 
	$last = mysqli_real_escape_string($conn, $_POST['last']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$reasonforuse = mysqli_real_escape_string($conn, $_POST['reasonforuse']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);


	
	//error handling 
	//check for empty fields

	if (empty($first) || empty($last) || empty($email) || empty($username) || empty($reasonforuse) || empty($pwd)) { // add agreement empty() check 

		header("Location: ../signup.php?signup=empty"); 
		exit();

	} else {

		// makes sure input characters are valid
		if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) { 
			header("Location: ../signup.php?signup=invalid");
			exit();
		} else {

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
				header("Location: ../signup.php?signup=email");
				exit();
			} else {

				$sql = "SELECT * FROM users WHERE user_username = '$username'";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				if ($resultCheck > 0){
					header("Location: ../signup.php?signup=usertaken");
					exit();
				} else {

					$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT); // hash password

					//insert user into db

					$sql = "INSERT INTO users (user_first, user_last, user_email, user_username, user_password, user_reasonforuse) VALUES ('$first', '$last', '$email', '$username', '$hashedPwd', '$reasonforuse');";
					mysqli_query($conn, $sql);
					header("Location: ../signup.php?signup=success");
					exit();

				}

			}
		}
	}

} else {
	header("Location: ../signup.php"); 
	exit();
}