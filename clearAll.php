<?php

/*
Alexander Murie.
Eagleweb, Aug 2018.
Purpose: clearAll.php represents the functionality of the Clear button. The current files, names and paths, being used (i.e. those stored in session) are 
		 reset to null.

*/
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

$dir = getcwd() . "/User/" . $_SESSION['u_username'] . "/temp/";
foreach(glob($dir.'*.*') as $file){
	unlink($file);
}



header("Location: index.php?dataCleared");



?>