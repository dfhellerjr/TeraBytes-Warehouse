<!-- --------------------------------------------------------------------------
--  Name: insert_brand.php
--  Abstract: A form for adding a new product brand    
-- --------------------------------------------------------------------------->
<?php
	$brandtitle = "";
	// If posted
	if(isset($_POST['insert_brand']))
	{
		$brandtitle = test_input($_POST['txtBrand']);	
		$query = 
		"SELECT * 
		 FROM tbrands 
		 WHERE strBrandTitle='$brandtitle'"; 
		$result = $conn->query($query);
		$count = $result->rowCount();			
		if($count == 0)
		{
			$sql = 
			"INSERT INTO tbrands(strBrandTitle, intBrandStatusID)
			 VALUES('$brandtitle', 1)";
			$result = $conn->query($sql);
			if($result)
			{
				// Display success message 
				echo "<script>alert('Brand added.')</script>";
			}
		}
		else
		{
			// Display error message 
			echo "<script>alert('Brand already exists.')</script>";			
		}
		echo "<script>window.open('index.php?menukey=6','_self')</script>";		
	}
?>
<!-- Style sheet -->
<link rel="stylesheet" href="styles/style6.css" media="all" />
<!-- Add brand form -->					
<form name="frmInsertBrand" id="frmInsertBrand" action="" method="post" />
	<div id="brandheader">
		<h2 class='admin-header2'><b><u>Add New Brand</u></b></h2>
	</div>
	<div id="content">
		<label for="txtBrand" id="brand">
			<b>Brand Name:</b>&nbsp;&nbsp;
			<input type="text" name="txtBrand" id="txtBrand" required /><br/>
		</label>	
		<input type="submit" name="insert_brand" id="insert_brand" value="Add Brand" />
		<input type="button" name="cancel" id="cancel" value="Cancel" 						   			   	   onclick="location.href='index.php?menukey=6';" />				
	</div>
</form>		
