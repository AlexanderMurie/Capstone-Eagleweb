<!-- 

Alexander Murie
Eagleweb, Aug 2018.
Purpose: Logs user out, ends their session, and redirects the user to the homepage. 
-->

<?php

if (isset($_POST['submit'])) {
	session_start();

	$cwd = $_SESSION['workingDir'];
	foreach(glob($cwd.'*.*') as $file){
		unlink($file);
	}



	session_unset();
	session_destroy();
	header("Location: ../index.php");
	exit();
}