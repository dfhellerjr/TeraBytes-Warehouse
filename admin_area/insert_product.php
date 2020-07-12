<!-- --------------------------------------------------------------------------
--  Name: insert_product.php
--  Abstract: A simple form using a table for adding a product  
--  Imports script from https://www.tinymce.com to provide a fully editable 
--  text area for product descriptions
-- --------------------------------------------------------------------------->
<?php
	// If posted
	if(isset($_POST['insert_post']))
	{
		// Get data from form fields
		$product_title       = test_input($_POST['product_title']);
		$product_category    = test_input($_POST['product_category']);
		$product_brand       = test_input($_POST['product_brand']);
		$product_title       = test_input($_POST['product_title']);
		$product_price       = test_input($_POST['product_price']);
		$product_description = $_POST['product_description'];		
		// Get product image from file
		$product_image       = $_FILES['product_image']['name'];
		$product_image_tmp   = $_FILES['product_image']['tmp_name'];		
		// Move uploaded image from temp file to project folder
		move_uploaded_file($product_image_tmp, "product_images/$product_image");
		// Call database stored procedure
		$sql = 'CALL uspAddProduct(?,?,?,?,?,?)';
		$stmt = $conn->prepare($sql);
		// Bind parameters		
		$stmt->bindParam(1, $product_category, PDO::PARAM_INT, 11);
		$stmt->bindParam(2, $product_brand, PDO::PARAM_INT, 11);
		$stmt->bindParam(3, $product_title, PDO::PARAM_STR, 50);
		$stmt->bindParam(4, $product_price, PDO::PARAM_INT, 11);
		$stmt->bindParam(5, $product_description, PDO::PARAM_STR, 1000);
		$stmt->bindParam(6, $product_image, PDO::PARAM_STR, 50);
		$stmt->execute(); 
		$stmt->closeCursor(); 
		echo "<script>alert('Product successfully added.')</script>";
		echo "<script>window.open('index.php?menukey=2','_self')</script>";		
	}					
?>
<!-- Style sheet -->		
<link rel="stylesheet" href="styles/style3.css" media="all"/>
<!-- Add product form -->
<form name="frmInsertProduct" id="frmInsertProduct" action="" method="post" 				  		  	  	  enctype="multipart/form-data"/>						
	<div id="tableheader">
		<h2 class='admin-header2'>Add New Product</h2>				
	</div>												
	<table width="800" height="500" align="center" bgcolor="#ffc14d">
		<tr>
			<td align="right" class="product_title"><b>Product Title:</b></td>
			<td>
				<input type="text" name="product_title" id="product_title" size="25" required />
			</td>
		</tr>
		<tr>
			<td align="right"><b>Product Category:</b></td>
			<td>
				<!-- Product category select box -->
				<select name="product_category" id="product_category" required />
					<option>Select a category</option>
					<?php																
					// Prepare & execute query
					$query = 
					"SELECT * 
					 FROM tcategories";
					$results = $conn->query($query);
					$count = $results->rowCount();
					if($count > 0)
					{
						// Loop through results
						while($row = $results->fetch(PDO::FETCH_ASSOC))
						{
							$categoryid = $row['intCategoryID'];
							$categorytitle = $row['strCategoryTitle'];						
							// Display option value 
							echo 
							'<option value="' . $categoryid . '">' . 
								$categorytitle . 
							'</option>';
						}
					}			
					?>						
				</select>
			</td>
		</tr>
		<tr>
			<td align="right"><b>Product Brand:</b></td>
			<td>						
				<!-- Product brand select box -->
				<select name="product_brand" id="product_brand" required />
					<option>Select a brand</option>
					<?php																	
					$query = 
					"SELECT * 
					 FROM tbrands";
					$results = $conn->query($query);
					$count = $results->rowCount();
					if($count > 0)
					{
						// Loop through result-set
						while($row = $results->fetch(PDO::FETCH_ASSOC))
						{
							$brandid    = $row['intBrandID'];
							$brandtitle = $row['strBrandTitle'];								
							// Display option 
							echo 
							'<option value="' . $brandid . '">' 
								. $brandtitle . 
							'</option>';
						}
					}			
					?>						
				</select>
			</td>					
		</tr>
		<tr>
			<td align="right"><b>Product Image:</b></td>
			<td>			
				<input type="file" name="product_image" id="product_image" required/>		
			</td>
		</tr>
		<tr>
			<td align="right"><b>Product Price:</b></td>
			<td>
				<input type="text" name="product_price" id="product_price" size="12" required/>
			</td>
		</tr>
		<tr>
			<td align="right"><b>Product Description:</b></td>
			<td>
				<!-- Include tinymce -->
				<script>tinymce.init({selector:'textarea'});</script>						
				<textarea name="product_description" id="product_description" 
						  cols="15" rows="10">
				</textarea>					
			</td>
		</tr>			
	</table>
	<div id="buttons">
		<input type="submit" name="insert_post" id="insert_post" value="Insert Product"/>
		<input type="button" name="cancel" id="cancel" value="Cancel" 
			   onclick="location.href='index.php?menukey=2';"/>
	</div>
</form>				
