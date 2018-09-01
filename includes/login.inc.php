<!-- 

Alexander Murie
12/08/2018
Eagleweb


Controller
 -->

<?php

session_start();

if (isset($_POST['submit'])) {

	include 'dbh.inc.php';
	
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

	// error handling
	//check if empty

	if (empty($username) || empty($pwd)) {
		header("Location: ../index.php?login=empty");
		exit();
		} else {
			

			
			$sql = "SELECT * FROM users WHERE user_username='$username' OR user_email='$username'";
			$result = mysqli_query($conn, $sql);

			$resultCheck = mysqli_num_rows($result);
			if ($resultCheck < 1){
				header("Location: ../index.php?login=errorUsername"); //remove these error specifications, debugging
				exit();
			} else {


				if ($row = mysqli_fetch_assoc($result)) {
					//de-hash pwd
					$hashedPwdCheck = password_verify($pwd, $row['user_password']);	
					if ($hashedPwdCheck == false) {
						header("Location: ../index.php?login=errorPassword");
						exit();
					} elseif ($hashedPwdCheck == true){
						
						

						//check if confirmed here

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
						mkdir($currdir . "/uploads/users/". $_SESSION['u_username'] . "/temp", 0777, true);

						exit();
						


					}
				}


			}
		}	
	} else {
		header("Location: ../index.php?login=errorGeneral");
		exit();
	}


