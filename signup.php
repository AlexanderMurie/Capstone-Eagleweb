<!-- 

Alexander Murie
12/08/2018
Eagleweb


Sign Up (View)
 -->

<?php
	include_once 'header.php';
?>

<section class="main-container">
 
	<style>

    .backgroundSignUp {
      	width: 100%;
      	height: 602px;
      	top: 0;
      	
      	background-image: url('images/chickNestEgg.jpg');
      	z-index: 0;
      	
    	
    }

  	</style>
  	
	<div class="main-wrapper backgroundSignUp">
			


		<form class="signup-form" action="includes/signup.inc.php" method="POST">


			<?php

			$errorType = null;
			$userCheck = true;
			$isInvalid = false;
			$isSuccess = false; 
			if (isset($_GET['first'])){
				$first = $_GET['first'];
				echo '<input type="text" name="first" placeholder="First name" value="'.$first.'">';
			}
			else {
				echo '<input type="text" name="first" placeholder="First name">';
			}

			if (isset($_GET['last'])){
				$last = $_GET['last'];
				echo '<input type="text" name="last" placeholder="Surname" value="'.$last.'">';
			} 
			else {
				echo '<input type="text" name="last" placeholder="Surname">';
			}

			if (isset($_GET['signup'])){
				if ($_GET['signup'] == "usertaken"){
					echo '

						<style>
							#errorFlag {
							color: red;
							}
						</style>

						<input type="text" id="errorFlag" name="username" placeholder="Username" value="This username is already in use.">';
						$userCheck = false;

				}
			}

			if($userCheck){

				if (isset($_GET['username'])){
					$username = $_GET['username'];
					echo '<input type="text" name="username" placeholder="Surname" value="'.$username.'">';
				} 
				else {

					echo '<input type="text" name="username" placeholder="Username">';
				}
			}

			if (isset($_GET['reasonforuse'])){
				$reasonforuse = $_GET['reasonforuse'];
				echo '<input type="text" name="reasonforuse" placeholder="Why are you using Eagleweb?" value="'.$reasonforuse.'">';
			}
			else {
				echo '<input type="text" name="reasonforuse" placeholder="Why are you using Eagleweb?">';
			}

			if (isset($_GET['signup'])){
				
				$errorType = $_GET['signup'];
					if ($errorType == "email"){
						echo '
						<style>
							#errorFlag {
							color: red;
							}
						</style>

						<input type="text" id="errorFlag" name="email" placeholder="E-mail" value="Your email was invalid.">

						';
					
						}


					if ($errorType == "empty"){
						
						echo '<input type="text" name="email" placeholder="E-mail">';	
						}
					if ($errorType == "invalid"){
						$isInvalid = true;
					}	

					if ($errorType == "success"){
						$isSuccess = true;
					}	

				} else {
					echo '<input type="text" name="email" placeholder="E-mail">';
				}

				if($userCheck == false){
					echo '<input type="text" name="email" placeholder="E-mail">';	
				}

				if($isInvalid == true){
					echo '<input type="text" name="email" placeholder="E-mail">';	
				}
				if ($isSuccess == true){
					echo '<input type="text" name="email" placeholder="E-mail">';	
				}
			
			echo '
			
		
			
			<input type="password" name="pwd" placeholder="Password">
			<input type="password" name="pwd2" placeholder="Confirm password">
			<button type="submit" name="submit">Sign up</button>
			';
			

				if ($errorType == "empty"){
					
					echo '

					<style>
						#emptyFlag {
						padding-top: 10px;
						color: #ffffff;
						text-align: center;
						font-size: 20px;
						font: arial;
						}
					</style>
					<p id="emptyFlag">Error: Empty fields.</p>';
			
				}

				if ($isInvalid == true){
					echo '

					<style>
						#emptyFlag {
						padding-top: 10px;
						color: #ffffff;
						text-align: center;
						font-size: 20px;
						font: arial;
						}
					</style>
					<p id="emptyFlag">Error: You used invalid characters.</p>';		
				}

				if ($isSuccess == true){
					echo '

					<style>
						#emptyFlag {
						padding-top: 10px;
						color: #ffffff;
						text-align: center;
						font-size: 20px;
						font: arial;
						}
					</style>
					<p id="emptyFlag">Welcome to Eagleweb. Please log in.</p>';		
				}
			?>
		</form>	
	</div>
</section>

<?php
	include_once 'footer.php';
?>