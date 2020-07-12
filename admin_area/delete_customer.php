<!-- --------------------------------------------------------------------------
--   Name: delete_customer.php
--   Abstract: Delete a customer account (set status to inactive)  
-- --------------------------------------------------------------------------->
<?php
// Connect to the database
include "../MySQLConnector.php";
$customerid = $_GET['CustomerID'];

// If valid login
if(isset($_SESSION['user_name']))
{
	if(isset($_POST['confirm']))
	{
		// Delete customer cart first
		$sql = 
		"DELETE FROM tcustomercarts 
		 WHERE intCustomerID='$customerid'";
		$result = $conn->query($sql);
		if($result)
		{
			// Set customer to inactive
			$query = 
			"UPDATE tcustomers 
			 SET intCustomerStatusID = 2
			 WHERE intCustomerID='$customerid'";
			$result = $conn->query($query);			
			// Message & redirect
			echo "<script>alert('Customer account deleted!')</script>";						
			echo "<script>window.open('index.php', '_self')</script>";	
		}
	}
	?>				
	<link rel="stylesheet" href="styles/style8.css" media="all" />					
	<h2 style="text-align:center"><u>Delete This Customer Account?</u></h2>
	<form name="frmDeleteCustomerAccount" id="frmDeleteCustomerAccount" action="" method="post" >
		<br>
		<div id="buttons">
			<!-- Submit button -->
			<input type="submit" name="confirm" id="confirm" value="Confirm"> 					
			<!-- Cancel button -->
			<input type="button" name="cancel" id="cancel" value="Cancel" 							   onclick="location.href='index.php';">				
		</div>		
	</form>		
<?php
}
?>