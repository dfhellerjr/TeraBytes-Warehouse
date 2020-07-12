<!-- --------------------------------------------------------------------------
--  Name: undelete_brand.php
--  Abstract: Undelete a brand from the database   
-- --------------------------------------------------------------------------->
<?php	
	// If posted
	if(isset($_GET['BrandID']))
	{
		// Get brandID
		$brandid = $_GET['BrandID'];							
		// Undelete brand
		$sql = 
		"UPDATE tbrands 
		 SET intBrandStatusID = 1
		 WHERE intBrandID='$brandid'";
		$result = $conn->query($sql);	
		if($result)
		{
			echo "<script>alert('Brand has been undeleted')</script>";
			echo "<script>window.open('index.php?menukey=6','_self')</script>";
		}
	}	
?>