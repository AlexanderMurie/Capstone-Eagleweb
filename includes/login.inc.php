<!-- 

Alexander Murie
Eagleweb, Aug 2018
Purpose: Handles user authentication and log in. It also stores all user information to the session for use later (e.g. when changing the name of an 
		 uploaded file.)
 -->

<?php

session_start();

if (isset($_POST['submit'])) {

	include 'dbh.inc.php';
	
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);


	if (empty($username) || empty($pwd)) {
		header("Location: ../index.php?login=empty");
		exit();
		} else {
			

			
			$sql = "SELECT * FROM users WHERE user_username='$username' OR user_email='$username'";
			$result = mysqli_query($conn, $sql);

			$resultCheck = mysqli_num_rows($result);
			if ($resultCheck < 1){
				header("Location: ../index.php?login=errorUsername"); 
				exit();
			} else {


				if ($row = mysqli_fetch_assoc($result)) {
					$hashedPwdCheck = password_verify($pwd, $row['user_password']);	
					if ($hashedPwdCheck == false) {
						header("Location: ../index.php?login=errorPassword");
						exit();
					} elseif ($hashedPwdCheck == true){
						$_SESSION['u_id'] = $row['user_id'];
						$_SESSION['u_first'] = $row['user_first'];
						$_SESSION['u_last'] = $row['user_email'];
						$_SESSION['u_username'] = $row['user_username'];
						$_SESSION['u_email'] = $row['user_email'];
						$_SESSION['u_rfu'] = $row['user_reasonforuse'];
							
							if ($username == "MeganMurgatroyd") {
								$_SESSION['u_isMegan'] = true;
							}
							
						header("Location: ../index.php?login=success");

						$currdir = getcwd();
						$currdirNew = str_replace("includes", "", $currdir);
						mkdir($currdirNew . "/User/". $_SESSION['u_username'] . "/temp", 0777, true);

						exit();
						


					}
				}


			}
		}	
	} else {
		header("Location: ../index.php?login=errorGeneral");
		exit();
	}


