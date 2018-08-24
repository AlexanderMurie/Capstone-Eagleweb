<?php
session_start();
// Nest upload handler
if (isset($_POST['uploadNestButton'])) {

	$user_in_session = $_SESSION['u_username']; 

	$file = $_FILES['nest-file'];
	$fileName = $_FILES['nest-file']['name'];
	$fileTmpName = $_FILES['nest-file']['tmp_name'];
	$fileSize = $_FILES['nest-file']['size'];
	$fileError = $_FILES['nest-file']['error'];
	$fileType = $_FILES['nest-file']['type'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt)); 

	$allowed = array('csv', 'txt'); //remove txt allowed; is for testing

	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0){
			if ($fileSize < 100000){ //not sure if 10mb is appropriate
				$fileNameNew = uniqid($user_in_session,true).".".$fileActualExt; //gives file a new id prefixed with u_username currently in session
				$fileDestination = 'uploads/nest_files/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
				echo 'Success!';
				header("Location: index.php?uploadsuccess"); //change if we need a loading screen or whatever; check in index.php if a file has been uploaded.


			} else {
				echo 'Error: file is too big!';
			}
		} else {
			echo 'Error uploading nest file!';	
		}
	} else {
		echo 'Nest data must be a .csv file!';
	}


}