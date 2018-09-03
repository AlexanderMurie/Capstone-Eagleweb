<?php

session_start();

if (isset($_SESSION['nestFileName'])){
	$_SESSION['nestFileName'] = null;
} 

if (isset($_SESSION['nestFileDir'])){
	$_SESSION['nestFileDir'] = null;
}

if (isset($_SESSION['areaFileName'])){
	$_SESSION['areaFileName'] = null;
} 

if (isset($_SESSION['areaFileDir'])){
	$_SESSION['areaFileDir'] = null;
}

header("Location: index.php?dataCleared");

?>