<!-- 

Alexander Murie
Eagleweb, Aug 2018
Purpose: Pushes user supplied data (when they fill out the signup form) into the user database. This code also validates
		 user input (email validation, disallow special characters in names, etc.)
 -->

<?php

if (isset($_POST['submit'])) {
	include_once 'dbh.inc.php';

	
	$first = mysqli_real_escape_string($conn, $_POST['first']); 
	$last = mysqli_real_escape_string($conn, $_POST['last']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$reasonforuse = mysqli_real_escape_string($conn, $_POST['reasonforuse']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

	if (empty($first) || empty($last) || empty($email) || empty($username) || empty($reasonforuse) || empty($pwd)) { 

		header("Location: ../signup.php?signup=empty"); 
		exit();
		}else {


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

					$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT); 

				

					$confirmCode = rand(); 

					$sql = "INSERT INTO users (user_first, user_last, user_email, user_username, user_password, user_reasonforuse, user_confirm_code) VALUES ('$first', '$last', '$email', '$username', '$hashedPwd', '$reasonforuse', '$confirmCode');";
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