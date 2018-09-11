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

	// dbf
	// prj
	// qpj
	// shx
	// shp

	$fileDbf = $_FILES['dbf-file'];
	$fileNameDbf = $_FILES['dbf-file']['name'];
	$fileTmpNameDbf = $_FILES['dbf-file']['tmp_name'];
	$fileSizeDbf = $_FILES['dbf-file']['size'];
	$fileErrorDbf = $_FILES['dbf-file']['error'];
	$fileTypeDbf = $_FILES['dbf-file']['type'];


	$filePrj = $_FILES['dbf-file'];
	$fileNameDbf = $_FILES['dbf-file']['name'];
	$fileTmpNameDbf = $_FILES['dbf-file']['tmp_name'];
	$fileSizeDbf = $_FILES['dbf-file']['size'];
	$fileErrorDbf = $_FILES['dbf-file']['error'];
	$fileTypeDbf = $_FILES['dbf-file']['type'];





	$fileExt = explode('.', $fileNameDbf);
	$fileActualExt = strtolower(end($fileExt)); 
	$allowed = array('dbf', 'prj', 'qpj', 'shx' ,'shp', 'txt'); 

	if (in_array($fileActualExt, $allowed)) {
		if ($fileErrorDbf === 0){
			if ($fileSizeDbf < 500000){ 
				$fileNameNew = uniqid($user_in_session,true).".".$fileActualExt; 
				$fileDestination = 'User/'. $_SESSION['u_username']. '/temp/' . $fileNameNew;
				move_uploaded_file($fileTmpNameDbf, $fileDestination);
				$_SESSION['dbfFileName'] = $fileNameNew;
				$_SESSION['dbfFileDir'] = $fileDestination;
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