<!-- 

Alexander Murie
Eagleweb, Aug 2018.
Purpose: Logs user out, ends their session, and redirects the user to the homepage. 
-->

<?php

if (isset($_POST['submit'])) {
	session_start();
	session_unset();
	session_destroy();
	header("Location: ../index.php");
	exit();
}