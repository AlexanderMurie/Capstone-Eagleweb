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
if (!isset($_SESSION['u_id'])){ 
 echo ' <style>

    .backgroundHome {
      width: 1154px;
      height: 760px;
      position: relative;
      background-image: url("images/background.jpg");
    }

  </style>';
}
?>
	<div class="main-wrapper backgroundHome">
		<h2></h2>




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
								
								<h1 align="center">SELECT YOUR NEST DATA</h1>
                  					<form action="uploadNest.php" method="POST" enctype="multipart/form-data"> 
                    					<input type="file" name="nest-file">
                    					<button type="submit" name="uploadNestButton">UPLOAD NEST DATA</button>
                  					</form>
							</div>
						</div>
						<script src="nestButtonModal.js"></script>
					</body>




					<body>
						<div id="areaModal" class = "areaModal">
							<div class="modal-content">
								<span class="closeButtonArea">&times;</span>
									
									<h1 align="center">SELECT YOUR BOUNDARY AREA FILE</h1>
                  					<form action="uploadArea.php" method="POST" enctype="multipart/form-data"> 
                    					<input type="file" name="area-file">
                    					<button type="submit" name="uploadAreaButton">UPLOAD BOUNDARY AREA</button>
                  					</form>
								

							</div>
						</div>
						<script src="areaButtonModal.js"></script>
					</body>


					<body>
						<div id="clearModal" class = "clearModal">
							<div class="modal-content">
								<span class="closeButtonClear">&times;</span>
								
								<button>clear</button>

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
            echo '<div class = "sidepanelLeft">
            <ul>
            <li><button id="buttonArea" class="buttonArea">AREA</button></li>
            <li><button id="buttonNest" class="buttonNest">NESTS</button></li>
            <li><button id="buttonClear" class="buttonClear">CLEAR</button></li>
            <li><button id="buttonGenerate" class="buttonGenerate">GENERATE</button></li>
            <li><button id="buttonMegan" class="buttonMegan">MEGAN</button></li>
            </ul>
            </div>

          <body>
            <div id="nestModal" class = "nestModal">
              <div class="modal-content">
                <span class="closeButtonNest">&times;</span>
                
                <h1 align="center">SELECT YOUR NEST DATA</h1>
                <button class="uploadButton">BROWSE</button>

              </div>
            </div>
            <script src="nestButtonModal.js"></script>
          </body>

          <body>
            <div id="areaModal" class = "areaModal">
              <div class="modal-content">
                <span class="closeButtonArea">&times;</span>
                
                <p>area (modal)</p>

              </div>
            </div>
            <script src="areaButtonModal.js"></script>
          </body>


          <body>
            <div id="clearModal" class = "clearModal">
              <div class="modal-content">
                <span class="closeButtonClear">&times;</span>
                
                <button>clear</button>

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