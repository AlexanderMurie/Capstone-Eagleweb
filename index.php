<!-- 

Alexander Murie
12/08/2018
Eagleweb


View
 -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--test this, w3school -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.3.3/dist/leaflet.js" integrity="sha512-tAGcCfR4Sc5ZP5ZoVz0quoZDYX5aCtEm/eu1KhSLj2c9eFrylXZknQYmxUssFaVJKvvc0dJQixhGjG2yXWiV9Q==" crossorigin=""></script>


<?php
	include_once 'header.php';
?>

<section class="main-container">
	<div class="main-wrapper">
		<h2>Eagleweb</h2>
		<?php
			if (isset($_SESSION['u_id'])) {
				

				echo '<div id="mapid"></div>
						<script src="mapStuff.js"></script>
						';
				
				echo '<div class = "sidepanelLeft">
						<ul>
						<li><button id="buttonArea" class="buttonArea"><i class="fa fa-home"></i></button></li>
						<li><button id="buttonNest" class="buttonNest"><i class="fa fa-folder"></i></button></li>
						<li><button id="buttonClear" class="buttonClear"><i class="fa fa-trash"></i></button></li>
						<li><button id="buttonGenerate" class="buttonGenerate">GENERATE</button></li>
						</ul>
						</div>

					<body>
						<div id="nestModal" class = "nestModal">
							<div class="modal-content">
								<span class="closeButtonNest">&times;</span>
								
								<p>nests (modal)</p>

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

					
					

						


				
				if (isset($_SESSION['u_isMegan'])) { 
				

				}
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


			}
		?>
	</div>
</section>

<?php
	include_once 'footer.php';
?>