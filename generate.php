<!--
Alexander Murie
Eagleweb, Aug 2018
Purpose: Checks if all necessary files are uploaded. If they are, stores their names and paths in the session for later use.
-->

<?php
session_start();


if (isset($_POST['generate'])) {
	echo '<script>console.log(123);</script>';

	if ($_SESSION['nestFileName'] == null || $_SESSION['nestFileDir'] == null || $_SESSION['areaFileName'] == null || $_SESSION['areaFileDir'] == null){
		header("Location: index.php?somesFilesNotUploaded");
		
		
	} else {

		// execute calcbounds.py via shell here
		


		// run map gen 


		header("Location: index.php?generated");
		
		
	

		
	}	


}