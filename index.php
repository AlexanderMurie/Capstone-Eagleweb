<!-- 

Alexander Murie
12/08/2018
Eagleweb


View
 -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--test this, w3school -->


<?php
	include_once 'header.php';
?>

<section class="main-container">
	<div class="main-wrapper">
		<h2>Eagleweb</h2>
		<?php
			if (isset($_SESSION['u_id'])) {

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

					
					echo '
						<body>

  						<div id="map" class="map">
  						<div id="mapid"></div>
  


						<script>
						//Import Open Terrain Layer Tile Map
						var mymap = L.map("mapid").setView([-28.378272, 23.913711], 5);
						var Stamen_Terrain = L.tileLayer("https://stamen-tiles-{s}.a.ssl.fastly.net/terrain/{z}/{x}/{y}{r}.{ext}", {
						attribution: "Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>",
						subdomains: "abcd",
						minZoom: 0,
						maxZoom: 18,
						ext: "png"
						});
						mymap.addLayer(Stamen_Terrain);
						//Simple Scale Bar, must have on map following basic cartographic principles.
						L.control.scale().addTo(mymap);


						</script>
						</body>
						</div>
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







						//font-awesome icons

				/* - redirect to webmap here, checking if user is logged in
				   - add some way of checking if username = "Megatron" or something
				   - handle user agreement that data will be collected
				   - figure out how to farm user session data (add nestData, boundaryArea column to db?)






				 */




			}
		?>
	</div>
</section>

<?php
	include_once 'footer.php';
?>