<!-- --------------------------------------------------------------------------
--  Name: delete_category.php
--  Abstract: Delete a category from the database (set status to inactive)  
-- --------------------------------------------------------------------------->
<?php
	// If posted
	if(isset($_GET['CategoryID']))
	{
		// Get categoryID
		$categoryid = intval($_GET['CategoryID']);					
		// Delete category
		$sql = 
		"UPDATE tcategories 
		 SET intCategoryStatusID = 2
		 WHERE intCategoryID='$categoryid'";
		$result = $conn->query($sql);	
		if($result)
		{
			echo "<script>alert('Category has been deleted')</script>";
			echo "<script>window.open('index.php?menukey=4','_self')</script>";
		}
	}
?>
