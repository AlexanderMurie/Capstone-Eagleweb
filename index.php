<!-- 

Alexander Murie
Eagleweb, Aug 2018
Purpose: Main page which controls whether the user sees the home page or the logged-in screen (i.e. a Leaflet map)

 -->


<!-- Links to style sheets: Font Awesome (external), mapstyle.css (internal, sourced from Leaflet with small changes) 
	 and the main stylesheet style.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
<link rel="stylesheet" type="text/css" href="mapstyle.css">
<link rel="stylesheet" type="text/css" href="style.css">
<script src="https://unpkg.com/leaflet@1.3.3/dist/leaflet.js" integrity="sha512-tAGcCfR4Sc5ZP5ZoVz0quoZDYX5aCtEm/eu1KhSLj2c9eFrylXZknQYmxUssFaVJKvvc0dJQixhGjG2yXWiV9Q==" crossorigin=""></script>


<?php
	include_once 'header.php';
?>

<section class="main-container">
	<?php
		if (!isset($_SESSION['u_id'])){  //1154, 760
 			echo 	'
 					<style>

    					.backgroundHome {
      					width: 100%;
		      			height: 100%;
		      			position: relative;
		      			background-image: url("images/testbackground.jpeg");
		      			bottom: 0;
		      			right: 0;
		      			z-index: 0;
						}

		  			</style>
		  			'; 
  


		}
	?>

	<div class="main-wrapper backgroundHome">	
			<?php

				if (!isset($_SESSION['u_id'])){

					/*
					This section handles the About and Links windows on the homepage.  
					*/
  					echo 	'
  							<div class="aboutBox">
	  							<p style="color:black; text-align:center; padding-top:10px; font-size:26px; font-weight:bold;">About Eagleweb</p>
	  							<p style="font: georgia; color:black; text-align:left; padding-top:10px; font-size:20px; padding-left: 20px; padding-right:26px">

	  							Eagleweb, developed at UCT, is a free online tool for assessing the collision risk of black eagles around wind farms.
	  							Something about the Black Eagle Project and Megan Murgatroyd. 

	  							[Populate with more content]  
	  							</p>
  							</div>

  							<div class="contactBox">
  								<p style="color:black; text-align:center; padding-top:10px; padding-bottom: 50px; font-size:26px; font-weight:bold;">Links</p
  								<body>
  									<div class="linkWrapper">
  										<a href="http://www.blackeagles.co.za">The Black Eagle Project</a>
  									</div>
  								</body>

  								<body>
  									<div  style="padding-top: 40px" class="linkWrapper">
  										<a href="http://www.uct.ac.za/">University of Cape Town</a>
  									</div>
  								</body>
  								
  								<body>
  									<div  style="padding-top: 40px" class="linkWrapper">
  										<a href="http://www.blackeagles.co.za/?page_id=110/">Donate to the Black Eagle Project</a>
  									</div>
  								</body>

  								<body>
  									<div  style="padding-top: 40px" class="linkWrapper">
  										<a href="http://www.blackeagles.co.za/?page_id=14/">About Black Eagles</a>
  									</div>
  								</body>

								<body>
  									<div  style="padding-top: 40px" class="linkWrapper">
  										<a href="http://www.blackeagles.co.za/?page_id=132">Contact the Black Eagle Project</a>
  									</div>
  								</body>  

  							</div>';	
  				}
  			// End of About and Links windows section.	
  			?>

  			



			<?php
				if (isset($_SESSION['u_id'])) {
				  	
				  	/*
					This section handles the webmap display.
					*/
				  	echo 	'
				  			<iframe src="WebMap.html" width=970px height="660px" align="right" >
				  			</iframe>

          					';

          			// End of the webmap display section.

			


          			/*
					This section handles the display of the left-side panel, which contains
					the major buttons: Area, Nest, Clear and Generate.
					*/

					echo 	'	
							<div class = "sidepanelLeft">
							<ul>
								<li><button id="buttonNest" class="buttonNest">NESTS</button></li>
								<li><button id="buttonArea" class="buttonArea">AREA</button></li>
								<li><button id="buttonClear" class="buttonClear">CLEAR</button></li>
								<li><button id="buttonGenerate" class="buttonGenerate">GENERATE</button></li>
							</ul>
							</div>


							<body>


								<div id="nestModal" class = "nestModal">
									<div class="modal-content">
										<span class="closeButtonNest">&times;</span>
								
											<p style="color:#D2691E; text-align: center; padding-top:20px; font-weight: bold">SELECT YOUR NEST DATA</p>
											<p style="color:#D2691E; text-align: center; padding-left: 10px; padding-top:40px;">Please select your nest data</p>
											<p style="color:#D2691E; text-align: center; padding-left: 10px; padding-top:10px; padding-bottom: 30px; font-style: italic;">(.csv files only)</p>
								
                  							<form action="uploadNest.php" method="POST" enctype="multipart/form-data"> 
                  								<input type="file" name="nest-file">
                    							<button style="float: bottom;" type="submit" name="uploadNestButton">UPLOAD NESTS</button>
               								</form>

               							<p style="color: red; text-align:center; padding-top: 30px; padding-bottom:60px">By uploading your data you consent to having it recorded and stored by Eagleweb. For any queries, please contact eagleweb@eagleweb.com.</p>
									</div>
								</div>
								<script src="nestButtonModal.js"></script>
				

					
								<div id="areaModal" class = "areaModal">
									<div class="modal-content">
										<span class="closeButtonArea">&times;</span>
											<p style="color:#D2691E; text-align: center; padding-top:20px; font-weight: bold">SELECT YOUR BOUNDARY AREA</p>
											<p style="color:#D2691E; text-align: center; padding-left: 10px; padding-top:40px;">Please select your boundary area file.</p>
											<p style="color:#D2691E; text-align: center; padding-left: 10px; padding-top:10px; padding-bottom: 30px; font-style: italic;">(.shp files only)</p>
											
                  							<form action="uploadArea.php" method="POST" enctype="multipart/form-data"> 
                  								<input type="file" name="area-file">
                    							<button style="float: bottom;" type="submit" name="uploadAreaButton">UPLOAD AREA</button>
               								</form>

               							<p style="color: red; text-align:center; padding-top: 30px; padding-bottom:60px">By uploading your data you consent to having it recorded and stored by Eagleweb. For any queries, please contact eagleweb@eagleweb.com.</p>
									</div>
								</div>
								<script src="areaButtonModal.js"></script>
					

								<div id="clearModal" class = "clearModal">
									<div class="modal-content">
										<span class="closeButtonClear">&times;</span>
								
											<p style="font-size: 20px; color:#D2691E; text-align: center; padding-top:20px;padding-bottom: 40px; font-weight: bold">Are you sure you want to clear?</p>
								
							

										<form style="padding-left:30%; padding-right: 30%;"action="clearAll.php" method="POST">
											<button style="float: bottom;" type="submit" name="clearButton">CLEAR DATA</button>
										</form>
									<p style="color: red; text-align:center; padding-top: 30px; padding-bottom:60px">Your data will still be stored on the Eagleweb system, even if cleared. For any queries, please contact eagleweb@eagleweb.com.</p>
									</div>
								</div>
								<script src="clearButtonModal.js"></script>
					

								<div id="genModal" class = "genModal">
									<div class="modal-content">
										<span class="closeButtonGen">&times;</span>
								
											<button id="generate">generate</button>

									</div>
								</div>
								<script src="generateButtonModal.js"></script>


							</body>					
							';
				}
				// End of left-side panel section.

	
        
        if (isset($_SESSION['u_id'])){
				
				/*
				This section handles the export button.
				*/


				echo 	'
						<div>
							<ul>
								<li><button id="buttonExport" class="buttonExport">EXPORT</button></li>
							</ul>
						</div>
						
						<body>
						<div id="exportModal" class = "exportModal">
							<div class="modal-content">
								<span class="closeButtonExport">&times;</span>
								
								<button>Export</button>

							</div>
						</div>
						<script src="exportButtonModal.js"></script>
						</body>	

						';
		}
		// End of export button section.


		
		if (isset($_SESSION['u_isMegan'])){
			/*
			This section handles the Megan (i.e. the admin) button, displayed only if Megan logs in.
			*/
			echo '
				<button id="buttonMegan" class="buttonMegan">MEGAN</button>
				';
		}
			// End of Megan button section.
		      
			
	?>
</div>
</section>
<?php
	include_once 'footer.php';
?>