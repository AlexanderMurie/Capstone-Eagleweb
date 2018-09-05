<?php

/*
Alexander Murie
Eagleweb, Aug 2018
Purpose: uploadArea.php handles file upload for shapefiles (.shp). It pushes uploaded files to the correct directory path (user's temp folder) as well
		 as to a collective storage folder.
*/

session_start();




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

	$allowed = array('shp', 'txt'); 

	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0){
			if ($fileSize < 500000){ 
				$fileNameNew = uniqid($user_in_session,true).".".$fileActualExt; 
				$fileDestination = 'includes/uploads/users/'. $_SESSION['u_username']. '/temp/' . $fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
				$_SESSION['areaFileName'] = $fileNameNew;
				$_SESSION['areaFileDir'] = $fileDestination;
				copy($fileDestination, 'includes/uploads/boundary_data_dump/' . $fileNameNew);

				header("Location: index.php?uploadareasuccess"); 


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