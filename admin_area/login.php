<!-- --------------------------------------------------------------------------
--   Name: login.php
--   Abstract: Administrator login page
-- --------------------------------------------------------------------------->
<?php
	session_start();
	include ("../MySqlConnector.php");

	// If posted
	if(isset($_POST['admin-login']))
	{
		// Get variables from form
		$user_name = $_POST['user_name'];
		$password  = $_POST['password'];		
		// Test user name & password
		$sql = 
		"SELECT * 
		 FROM `tadministrators` 
		 WHERE strUserName = '$user_name' 
		 AND   strPassword = '$password'";
		$result = $conn->query($sql);
		$count = $result->rowCount();
		if($count == 0)
		{
			// Display error message
			echo "<script>alert('Username and/or password invalid! Please try again.')</script>";	
		}
		else
		{
			// Set session variable
			$_SESSION['user_name'] = $user_name;			
			// Redirect to index.php
			echo "<script>window.open('index.php', '_self')</script>";
		}		
	}
?>
<link rel="stylesheet" href="styles/login_style.css" media="all" />	
<div class="login">
	<h1>Administrator Login</h1>
	<form action="" method="post">
		<input type="text" name="user_name" placeholder="Username" required />				
		<input type="password" name="password" placeholder="Password" required />	
		<button type="submit" class="btn btn-primary btn-block btn-large" name="admin-login">
			Login
		</button>
	</form>
</div>
