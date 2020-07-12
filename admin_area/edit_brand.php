﻿<!-- --------------------------------------------------------------------------
--  Name: edit_brand.php
--  Abstract: A form to edit a product brand   
-- --------------------------------------------------------------------------->
<?php
	$brandtitle = "";
	// Get BrandID
	if(isset($_GET['BrandID']))
	{
		$brandid = $_GET['BrandID'];
	}
	// Get data for the specified brand from the database
	$sql = 
	"SELECT * 
	 FROM tbrands 
	 WHERE intBrandID =" . $brandid;               			 
	$result = $conn->query($sql);
	$row = $result->fetch(PDO::FETCH_ASSOC);
	$brand_title = $row['strBrandTitle']; 

	// If posted
	if(isset($_POST['edit_brand']))
	{
		$brandtitle = test_input($_POST['txtBrand']);		
		$sql = 
		"UPDATE tbrands 
		 SET strBrandTitle='$brandtitle' 
		 WHERE intBrandID='$brandid'";						
		$result = $conn->query($sql);
		if($result)
		{
			// Display success message 
			echo "<script>alert('Brand updated.')</script>";
			echo "<script>window.open('index.php?menukey=6','_self')</script>";
		}	
	}
?>
<!-- Style sheet -->
<link rel="stylesheet" href="styles/style6.css" media="all" />
<!-- Edit brand form -->					
<form name="frmEditBrand" id="frmEditBrand" action="" method="post" />
	<div id="brandheader">
		<h2>
			<b><u>Edit Brand</u></b>
		</h2>
	</div>
	<div id="content">
		<label for="txtBrand" id="brand">
			<b>Brand Name:</b>&nbsp;&nbsp;					
			<input type="text" name="txtBrand" id="txtBrand" required value="<?=$brand_title ?>"/>
		</label>
		<br/>
		<input type="submit" name="edit_brand" id="edit_brand" value="Edit Brand" />	
		<input type="button" name="cancel" id="cancel" value="Cancel" 						   		       	   onclick="location.href='index.php?menukey=6';" />
	</div>
</form>			
