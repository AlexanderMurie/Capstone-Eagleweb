<?php
session_start();
// Nest upload handler
if (isset($_POST['uploadAreaButton'])) {

	$user_in_session = $_SESSION['u_username']; 

	$file = $_FILES['area-file'];
	$fileName = $_FILES['area-file']['name'];
	$fileTmpName = $_FILES['area-file']['tmp_name'];
	$fileSize = $_FILES['area-file']['size'];
	$fileError = $_FILES['area-file']['error'];
	$fileType = $_FILES['area-file']['type'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt)); 

	$allowed = array('shp', 'txt'); //remove txt allowed; is for testing

	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0){
			if ($fileSize < 500000){ //not sure if 10mb is appropriate
				$fileNameNew = uniqid($user_in_session,true).".".$fileActualExt; //gives file a new id prefixed with u_username currently in session
				$fileDestination = 'uploads/boundary_area_files/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
				echo 'Success!';
				header("Location: index.php?uploadareasuccess"); //change if we need a loading screen or whatever; check in index.php if a file has been uploaded.


			} else {
				echo 'Error: area file is too big!';
			}
		} else {
			echo 'Error uploading area file!';	
		}
	} else {
		echo 'Boundary area must be a .shp file!';
	}


}