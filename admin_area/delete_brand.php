<!-- --------------------------------------------------------------------------
--  Name: delete_brand.php
--  Abstract: Delete a brand from the database (set status to inactive) 
-- --------------------------------------------------------------------------->
<?php	
	// If posted
	if(isset($_GET['BrandID']))
	{
		// Get brandID
		$brandid = $_GET['BrandID'];							
		// Delete brand
		$sql = 
		"UPDATE tbrands 
		 SET intBrandStatusID = 2
		 WHERE intBrandID='$brandid'";
		$result = $conn->query($sql);	
		if($result)
		{
			echo "<script>alert('Brand has been deleted')</script>";
			echo "<script>window.open('index.php?menukey=6','_self')</script>";
		}
	}	
?>
