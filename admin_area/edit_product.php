<!-- --------------------------------------------------------------------------
--  Name: edit_product.php
--  Abstract: Update a product's selling price or description in the database   
-- --------------------------------------------------------------------------->
<?php	
	// Get ProductID
	if(isset($_GET['ProductID']))
	{
		$productid = $_GET['ProductID'];	
	}
	// Get data for selected product from database
	$sql = 
	"SELECT * 
	 FROM VAllProductData 
	 WHERE intProductID =" . $productid;               			 
	$result = $conn->query($sql);
	$row = $result->fetch(PDO::FETCH_ASSOC); 					
	$category_id        = $row['intCategoryID'];
	$categorytitle      = $row['strCategoryTitle'];
	$brand_id           = $row['intBrandID'];
	$brandtitle         = $row['strBrandTitle'];
	$productname        = $row['strProductTitle'];
	$productprice       = $row['decSellingPrice'];
	$productdescription = $row['strProductDescription'];
	$productimage	    = $row['strProductImage'];
	$productstatus_id   = $row['intProductStatusID'];

	// If posted
	if(isset($_POST['edit_post']))
	{		
		// Edit price or description
		$product_price = test_input($_POST['product_price']);
		$product_description = $_POST['product_description'];
		// Call database stored procedure	
		$sql = 'CALL uspEditProduct(?,?,?)';
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $productid, PDO::PARAM_INT, 11);
		$stmt->bindParam(2, $product_price, PDO::PARAM_INT, 11);
		$stmt->bindParam(3, $product_description, PDO::PARAM_STR, 1000);
		$stmt->execute(); 
		$stmt->closeCursor(); 
		echo "<script>alert('Product successfully edited.')</script>";
		echo "<script>window.open('index.php?menukey=2','_self')</script>";		
	}						
?>
<!-- Style sheet -->	
<link rel="stylesheet" href="styles/style3.css" media="all" />
<!-- Product edit form -->					
<form name="frmEditProduct" id="frmEditProduct" action="" method="post" 
	  enctype="multipart/form-data"/>						
	<div id="tableheader">
		<h2 class='admin-header2'>Edit Product</h2>				
	</div>												
	<table width="800" align="center" bgcolor="#ffc14d" frame="box" >
		<tr>
			<td align="right" class="product_title"><b>Product Name:</b></td>
			<td>
				<input type="text" id="product_title" class="static" 
					   size="25" value="<?=$productname?>"/>
			</td>
		</tr>
		<tr>
			<td align="right"><b>Product Category:</b></td>
			<td>
				<input type="text" id="product_category" class="static" 
					   size="25" value="<?=$categorytitle?>"/>
			</td>
		</tr>
		<tr>
			<td align="right"><b>Product Brand:</b></td>
			<td>
				<input type="text" id="product_brand" class="static" 
					   size="25" value="<?=$brandtitle?>"/>
			</td>					
		</tr>					
		<tr>
			<td align="right"><b>Product Price:</b></td>
			<td>
				<input type="text" name="product_price" id="product_price" size="8"  		           		   value="<?=$productprice;?>"/>
			</td>
		</tr>
		<tr>
			<td align="right"><b>Product Description:</b></td>
			<td>
				<!-- include tinymce -->
				<script>tinymce.init({selector:'textarea'});</script>		
				<textarea name="product_description" id="product_description" 
						  cols="15" rows="10"><?=$productdescription;?>
				</textarea>
			</td>
		</tr>							
	</table>
	<div id="buttons">
		<input type="submit" name="edit_post" id="edit_post" value="Edit Product" />
		<input type="button" name="cancel" id="cancel" value="Cancel" 						   		   		   onclick="location.href='index.php?menukey=2';" />
	</div>
</form>
