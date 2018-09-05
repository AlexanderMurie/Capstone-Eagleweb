<!-- 

Alexander Murie
Eagleweb, Aug 2018
Purpose: Handles the footer, which contains the Export button.

 -->
<?php
	if (isset($_SESSION['u_id'])){

		echo '	<form action="includes/export.inc.php" method="POST">
				<button type="submit" name="submit">Logout</button>
				</form>';
			}
?>


</body>
</html>