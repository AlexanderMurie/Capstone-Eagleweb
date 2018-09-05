<!--
Alexander Murie
Eagleweb, Aug 2018
Purpose: Checks if all necessary files are uploaded. If they are, stores their names and paths in the session for later use.
-->

<?php
session_start();


if (isset($_SESSION['u_id']){

	if ($_SESSION['nestFileName'] == null || $_SESSION['nestFileDir'] == null || $_SESSION['areaFileName'] == null || $_SESSION['areaFileDir'] == null){
		header("Location: index.php?somesFilesNotUploaded");
		exit();

	} else {

		$currentNestFile = $_SESSION['nestFileName'];
		$currentNestFileDir = $_SESSION['nestFileDir'];
		$currentAreaFile = $_SESSION['areaFileName'];
		$currentAreaFileDir = $_SESSION['areaFileDir'];
	

		
	}	