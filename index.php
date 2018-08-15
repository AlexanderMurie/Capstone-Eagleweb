<!-- 

Alexander Murie
12/08/2018
Eagleweb

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


				//echo "webmap here - logged in";
				/*
				echo '<div class="sidepanel">
						<ul>
						<li><a href="#">About</a></li>
  						<li><a href="#">Services</a></li>
  						<li><a href="#">Clients</a></li>
  						<li><a href="#">Contact</a></li>
  						</ul>
					</div>';
					*/

				echo '<div class = "sidepanelLeft">
						<ul>
						<li><button id="buttonArea" class="buttonArea"><i class="fa fa-home"></i></button></li>
						<li><button id="buttonNest" class="buttonNest"><i class="fa fa-folder"></i></button></li>
						<li><button id="buttonClear" class="buttonClear"><i class="fa fa-trash"></i></button></li>
						<li><button class="buttonGenerate">GENERATE</button></li>
						</ul>
						</div>

					<body>
						<div id="nestModal" class = "modal">
							<div class="modal-content">
								<span class="closeButton">&times;</span>
								
								<p>Hello World (modal)</p>

							</div>
						</div>
						<script src="ButtonModal.js"></script>
					</body>
						';
				
				if (isset($_SESSION['u_isMegan'])) { 
					echo '<div class = "sidepanelLeft">
							<ul>
							<li><button id="buttonArea" class="buttonArea"><i class="fa fa-home"></i></button></li>
							<li><button id="buttonNest" class="buttonNest"><i class="fa fa-folder"></i></button></li>
							<li><button id="buttonClear" class="buttonClear"><i class="fa fa-trash"></i></button></li>
							<li><button class="buttonGenerate">GENERATE</button></li>
							<li><button id="button" class="buttonMegan">MEGAN</button></li>
							</ul>
							</div>';
					}

				echo '<div>
						<ul>
						<li><button id="exportButton" class="buttonExport">EXPORT</button></li>
						</ul>
						</div>';







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