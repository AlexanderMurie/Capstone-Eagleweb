<!-- 

Alexander Murie
12/08/2018
Eagleweb

 -->

<?php

if (isset($_POST['submit'])) {
	session_start();
	session_unset();
	session_destroy();
	header("Location: ../index.php");
	exit();
}