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
		//trigger error msg script here, outline empty boxes red
	/*} elseif ($pwd != $pwd2) {
		header("Location: ../signup.php?signup=passwordsDoNotMatch");
		exit();
		//trigger error msg script here
	} */}else {

		// makes sure input characters are valid
		if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) { 
			header("Location: ../signup.php?signup=invalid");
			exit();
		} else {

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
				header("Location: ../signup.php?signup=email&first=$first&last=$last&username=$username&reasonforuse=$reasonforuse");
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

					$confirmCode = rand(); // add checks

					$sql = "INSERT INTO users (user_first, user_last, user_email, user_username, user_password, user_reasonforuse, user_confirm_code) VALUES ('$first', '$last', '$email', '$username', '$hashedPwd', '$reasonforuse', '$confirmCode');";
					mysqli_query($conn, $sql);

					//send email
					/*

					// Mail can't be sent from a localhost; real server + domain name needed to implement this.

					$message = 
					"
					Confirm your email

					Click the link below to verify Eagleweb account:

					http://www.eagleweb.co.za/login/Eagleweb/includes/confirm.inc.php?username=$username&&code=$confirmCode

					"

					mail($email, "Eagleweb Confirmation Email", $message, "From: DoNotReply@eagleweb.co.za");

					*/


					header("Location: ../signup.php?signup=success");
					exit();

				}

			}
		}
	

	//make directory here
	/*
	if (mkdir("/uploads/users/" . $username . "/temp", 0777, true)){

	}
	*/
	}

} else {
	header("Location: ../signup.php"); 
	exit();
}