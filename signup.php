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
      height: 760px;
      top: 0;
      position: relative;
      background-image: url('images/chickNestEgg.jpg');
      z-index: 0;
      	background-size: cover;
    	background-repeat: no-repeat;
    }

  </style>

	<div class="main-wrapper backgroundSignUp">
		<h2>Sign up</h2>


		<form class="signup-form" action="includes/signup.inc.php" method="POST">
			<input type="text" name="first" placeholder="First name";>
			<input type="text" name="last" placeholder="Surname";>
			<input type="text" name="email" placeholder="E-mail";>
			<input type="text" name="username" placeholder="Username";>
			<input type="text" name="reasonforuse" placeholder="Why are you using Eagleweb?";>
			<input type="password" name="pwd" placeholder="Password";>
			<input type="password" name="pwd2" placeholder="Confirm password">
			<button type="submit" name="submit">Sign up</button>

			<!-- 

			- add "agree to have my data stored" button/box
			- adjust the css of reasonforuse file
			
			-->
		</form>	
	</div>
</section>

<?php
	include_once 'footer.php';
?>