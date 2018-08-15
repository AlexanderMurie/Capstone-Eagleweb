<!-- 

Alexander Murie
12/08/2018
Eagleweb

 -->

<?php
	include_once 'header.php';
?>

<section class="main-container">
	<div class="main-wrapper">
		<h2>Sign up</h2>


		<form class="signup-form" action="includes/signup.inc.php" method="POST">
			<input type="text" name="first" placeholder="First name";>
			<input type="text" name="last" placeholder="Surname";>
			<input type="text" name="email" placeholder="E-mail";>
			<input type="text" name="username" placeholder="Username";>
			<input type="text" name="reasonforuse" placeholder="Why are you using Eagleweb?";>
			<input type="password" name="pwd" placeholder="Password";>
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