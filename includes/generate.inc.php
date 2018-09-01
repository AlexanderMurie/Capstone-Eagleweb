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
	

		//push to backend
	}	