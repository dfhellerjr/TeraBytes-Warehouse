<!-- --------------------------------------------------------------------------
--  Name: undelete_category.php
--  Abstract: undelete a category from the database   
-- --------------------------------------------------------------------------->
<?php
	// If posted
	if(isset($_GET['CategoryID']))
	{
		// Get categoryID
		$categoryid = $_GET['CategoryID'];									
		// Delete category
		$sql = 
		"UPDATE tcategories 
		 SET intCategoryStatusID = 1
		 WHERE intCategoryID='$categoryid'";
		$result = $conn->query($sql);	
		if($result)
		{
			echo "<script>alert('Category has been undeleted')</script>";
			echo "<script>window.open('index.php?menukey=4','_self')</script>";
		}
	}
?>