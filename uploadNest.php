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
				$fileDestination = 'includes/uploads/users/'. $_SESSION['u_username']. '/temp/' . $fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
				$_SESSION['nestFileName'] = $fileNameNew;
				$_SESSION['nestFileDir'] = $fileDestination;
				copy($fileDestination, 'includes/uploads/nest_data_dump/' . $fileNameNew);
				//echo 'Success!';
				header("Location: index.php?uploadsuccess");


			} else {
				$_SESSION['errorType'] = 'error_filesize';
				header("Location: index.php?error=filesizeError");
				
			}
		} else {
			$_SESSION['errorType'] = 'error_upload';
			header("Location: index.php?error=uploadError");
			
		}
	} else {
		$_SESSION['errorType'] = 'error_nestdata_not_csv';
		header("Location: index.php?error=typeError");
			
	}










}