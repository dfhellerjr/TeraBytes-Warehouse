<!-- --------------------------------------------------------------------------
--   Name: undelete_customer.php
--   Abstract: Undelete a customer account  
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
        // Undelete customer
		$query = 
		"UPDATE tcustomers 
         SET intCustomerStatusID = 1
         WHERE intCustomerID='$customerid'";
        $result = $conn->query($query);       
        echo "<script>alert('Customer account undeleted!')</script>";						
        echo "<script>window.open('index.php', '_self')</script>";			
	}
	?>				
	<link rel="stylesheet" href="styles/style8.css" media="all" />		
	<h2 style="text-align:center; margin-top:0px"><u>Undelete This Customer Account?</u></h2>
	<form name="frmDeleteCustomerAccount" id="frmDeleteCustomerAccount" action="" method="post" >
		<br>
		<div id="buttons">
			<!-- Submit button -->
			<input type="submit" name="confirm" id="confirm" value="Confirm"> 							<!-- Cancel button -->
			<input type="button" name="cancel" id="cancel" value="Cancel" 							   		   onclick="location.href='index.php';">				
		</div>		
	</form>	
		
<?php
}
?>