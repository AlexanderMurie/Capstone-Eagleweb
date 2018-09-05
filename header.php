<!-- 

Alexander Murie
Eagleweb, Aug 2018

 -->

<?php
	session_start();
?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<header>
	<nav>
		<div class="main-wrapper">
			<div class = "nav-login"> <!-- This div controls whether the header displays a login form or just a logout button 
										   depending on whether the user is logged in. -->

				<?php
					if (isset($_SESSION['u_id'])){

							echo 	'	
									<form action="includes/logout.inc.php" method="POST">
									<button type="submit" name="submit">Logout</button>
									</form>
								 	';

					} 
					else {

							echo 	'
									<form action="includes/login.inc.php" method="POST">
									<input type="text" name="username" placeholder="Username">
									<input type="password" name="pwd" placeholder="Password">
									<button type="submit" name="submit">Login</button> 
									</form>
									<a href="signup.php">Sign up</a>
									';
					
							}
				?>
			</div>
		</div>
	</nav>
</header>