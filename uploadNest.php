<?php

/*
Alexander Murie
Eagleweb, Aug 2018
Purpose: uploadNest.php handles file upload for nest data files (.csv). It pushes uploaded files to the correct directory path (user's temp folder) as well
		 as to a collective storage folder.
*/

session_start();

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
	$allowed = array('csv', 'txt'); 

	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0){
			if ($fileSize < 100000){ 
				$fileNameNew = uniqid($user_in_session,true).".".$fileActualExt; 
				$fileDestination = 'User/'. $_SESSION['u_username']. '/temp/' . $fileNameNew;
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