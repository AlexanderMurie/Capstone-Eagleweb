<!-- 

Alexander Murie
12/08/2018
Eagleweb


View
 -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--test this, w3school -->
<link rel="stylesheet" type="text/css" href="mapstyle.css">
<script src="https://unpkg.com/leaflet@1.3.3/dist/leaflet.js" integrity="sha512-tAGcCfR4Sc5ZP5ZoVz0quoZDYX5aCtEm/eu1KhSLj2c9eFrylXZknQYmxUssFaVJKvvc0dJQixhGjG2yXWiV9Q==" crossorigin=""></script>


<?php
	include_once 'header.php';
?>

<section class="main-container">
<?php
if (!isset($_SESSION['u_id'])){  //1154, 760
 echo ' <style>

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
  // about section here


}
?>
	<div class="main-wrapper backgroundHome">
		

  		
			<?php

			if (!isset($_SESSION['u_id'])){
  			echo '<div class="aboutBox">
  				<p style="color:black; text-align:center; padding-top:10px; font-size:26px; font-weight:bold;">About Eagleweb</p>
  			</div>

  			<div class="contactBox">
  				<p style="color:black; text-align:center; padding-top:10px; font-size:26px; font-weight:bold;">Links</p>
  			</div>';	
  			}
  			?>

  			



		<?php
			if (isset($_SESSION['u_id'])) {
				  echo '<div id="mapid"></div>
          <script src="mapStuff.js"></script>

          ';


				echo '<div class = "sidepanelLeft">
						<ul>
						<li><button id="buttonArea" class="buttonArea">AREA</button></li>
						<li><button id="buttonNest" class="buttonNest">NESTS</button></li>
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
					</body>




					<body>
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
					</body>


					<body>
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
					</body>
						
					<body>
						<div id="genModal" class = "genModal">
							<div class="modal-content">
								<span class="closeButtonGen">&times;</span>
								
								<button>generate</button>

							</div>
						</div>
						<script src="generateButtonModal.js"></script>
					</body>					
					';


				echo '<div>
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



        
        if (isset($_SESSION['u_isMegan'])) { 
           echo '

           		



           ';
        
        }






			}
		?>
	</div>
</section>
  
<sectiom> 

<?php
	

	

  ?>  
 
</sectiom>
<?php
	include_once 'footer.php';
?>