<!-- --------------------------------------------------------------------------
--   Name: my_account.php
--   Abstract: Allow customer to manage his/her account 
-- --------------------------------------------------------------------------->
<?php
session_start();
include ("../MySQLConnector.php");	
include ("../functions/functions.php");

// Set entry page
$_SESSION['page'] = 'customer'; 

// Customer logged in?
if(empty($_SESSION['CustomerID'])) 
{
	 // Not logged in
	 $_SESSION['CustomerID'] = 0; 
	 $_SESSION['firstname']  = "Guest";  
}
$customerid = $_SESSION['CustomerID'];
?>

<!DOCTYPE html>
<html>
	<head>
		<title>TeraBytes Warehouse - My Account</title>				
		<link rel="stylesheet" href="../styles/style.css" media="all" />
		<link rel="stylesheet" href="styles/style2.css" media="all" />               
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script src="../scripts/jquery.js"></script>	
	</head>
	<body>
		<div class="main_wrapper">
			<!-- Header -->
			<header class="header">
				<?php include "../header.php"; ?>
			</header>
			<!-- Menu bar -->
			<nav class="menubar">				
				<?php include "../menubar.php"; ?>														
			</nav>
			<!-- Sidebar -->
			<aside class="sidebar">
				<?php include "../sidebar.php"; ?>				
			</aside>
			<!-- Welcome section -->
			<section class="welcome">
				<?php Add_to_Cart(); ?>
				<?php include "../welcome.php"; ?>					
			</section>
			<!-- Content section -->
			<section class="my_account-content">
				<?php
				if($customerid == 0)
				{
					echo 
					"<h2 style='padding-top:20px'>
						Please login or register your account.
					</h2>";
				}
				else
				{
					if (isset($_GET['menukey']))  
					{
						$menukey = $_GET['menukey'];
					} 
					else 
					{
						$menukey = 0;
					}
					switch ($menukey) 
					{						
						case 1:
							include "edit_customer.php";
							break;
						case 2:
							include "change_password.php";
							break;
						case 3:
							include "my_orders.php";
							break;
						case 4:
							include "delete_account.php";
							break;
						case 5:
							include "order_recipient.php";
							break;
						default:
							break;
					}
				}
				?>
			</section>						
			<div class="clearfix"></div>							
			<!-- Footer -->
			<footer style='padding-top:20px'>
				<?php include "../footer.php"; ?>
			</footer>
		</div>		
	</body>
</html>