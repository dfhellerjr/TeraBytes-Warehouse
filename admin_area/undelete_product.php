<!-- --------------------------------------------------------------------------
--  Name: undelete_product.php
--  Abstract: UnDelete a product from the database   
-- --------------------------------------------------------------------------->
<?php
	// If posted
	if(isset($_GET['ProductID']))
	{
		// Get product ID
		$productid = $_GET['ProductID'];		
		// Get product name
		$query = 
		"SELECT strProductTitle 
		 FROM tproducts 
		 WHERE intProductID='$productid'";
		$result = $conn->query($query);
		$row = $result->fetch(PDO::FETCH_ASSOC);
		$producttitle = $row['strProductTitle'];					
		// Set product status to active
		$sql = 
		"UPDATE tproducts
		 SET intProductStatusID = 1 
		 WHERE intProductID='$productid'";
		$result = $conn->query($sql);	
		if($result)
		{
			echo "<script>alert('$producttitle has been undeleted')</script>";
			echo "<script>window.open('index.php?menukey=2','_self')</script>";
		}
	}
?>
