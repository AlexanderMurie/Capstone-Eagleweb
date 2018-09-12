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
	$allowed = array('dbf','prj','qpj','shx','shp','txt');

	// dbf
	// prj
	// qpj
	// shx
	// shp


	/*
	$file = $_FILES['area-files'];
	$fileName = $_FILES['area-files']['name'];
	$fileTmpName = $_FILES['area-files']['tmp_name'];
	$fileSize = $_FILES['area-files']['size'];
	$fileError = $_FILES['area-files']['error'];
	$fileType = $_FILES['area-files']['type'];
	*/


	if (isset($_FILES['area-files']['name'])){




		$total_files = count($_FILES['area-files']['name']);


		if ($total_files != 5){
			header("Location: index.php?notFiveAreaFiles");
			exit();



		} else {

		

		for ($key = 0; $key < $total_files; $key++){ 


			if (isset($_FILES['area-files']['name'][$key]) && $_FILES['area-files']['size'] > 0){


				$file = $_FILES['area-files'];
				$fileName = $_FILES['area-files']['name'][$key];
				$fileTmpName = $_FILES['area-files']['tmp_name'][$key];
				$fileSize = $_FILES['area-files']['size'][$key];
				$fileError = $_FILES['area-files']['error'][$key];
				$fileType = $_FILES['area-files']['type'][$key];

				$fileExt = explode('.', $fileName);
				$fileActualExt = strtolower(end($fileExt)); 
				if (in_array($fileActualExt, $allowed)) {
					if ($fileError === 0){
						if ($fileSize < 500000){ 
							$fileNameNew = uniqid($user_in_session,true).".".$fileActualExt; 
							$fileDestination = 'User/'. $_SESSION['u_username']. '/temp/' . $fileNameNew;
							move_uploaded_file($fileTmpName, $fileDestination);
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
}
}


}
}