<!-- 

Alexander Murie
12/08/2018
Eagleweb

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