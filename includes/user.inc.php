<!-- 
Alexander Murie
16/08/2018

User (Object), UserHandler controller
-->

<?php

session_start(); // note to self: objects can be stored in the session, map = object -> store map in session?
if (isset($_POST['submit'])) {
	include dbh.inc.php;
	$sql = "SELECT * FROM users WHERE user_username='$username' OR user_email='$username'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result)
}


class User {
	// user properties
	protected $u_id = $row['user_id'];
	protected $u_first = $row['user_first'];
	protected $u_last = $row['user_email'];
	protected $u_username = $row['user_username'];
	protected $u_email = $row['user_email'];
	protected $u_rfu = $row['user_reasonforuse'];
	
	function __constructUser(){

	}

	public function __destruct(){

	}




	function getId(){return $this->u_id;}
	function getFirst(){return $this->u_first;}
	function getLast(){return $this->u_last;}
	function getUsername(){return $this->u_username;}
	function getEmail(){return $this->u_email;}
	function getRfu(){return $this->u_rfu;} 

	// add delete user (i.e. ban a specific user from user eagleweb) permissions for megan
	// change getters to magic (__getId($u_id){}, etc.) getters
}

