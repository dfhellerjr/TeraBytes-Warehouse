<!-- --------------------------------------------------------------------------
--   Name: my_orders.php
--   Abstract: Display a summary of the customer's orders with each one 
--   detailed separately.  
-- --------------------------------------------------------------------------->
<?php	
// Initialize variables
date_default_timezone_set('America/New_York');
$customerid = $_SESSION['CustomerID'];
	
// If customer is logged in
if($customerid > 0)
{                  
	// Get order count
	$query = 
	"SELECT MAX(intOrderIndex) AS MaxIndex 
	 FROM tcustomerorders 
	 WHERE intCustomerID=$customerid";						
	$results = $conn->query($query);
	$row     = $results->fetch(PDO::FETCH_ASSOC);
	$count   = $row['MaxIndex'];	
	if ($count > 0)
	{
	?>		
		<div id=yourOrders>
			<!-- Top header -->
			<div id="orderHeader">
				<h1>Your Order Summaries</h1>								  
			</div>
				
			<!-- New table for each order -->
			<?php		
			for($intIndex = $count; $intIndex > 0; $intIndex -= 1)
			{				
				$ordertotal = 0.00;
                /* Get all order information */
                $sql = "SELECT * 
				        FROM VAllCustomerOrderSummaries
						WHERE intCustomerID='$customerid' 
						AND intOrderIndex='$intIndex' 
						ORDER BY intOrderIndex desc, intProductIndex";
                $results = $conn->query($sql);
                		
				while($row = $results->fetch(PDO::FETCH_ASSOC))
                {
                    $intOrderIndex = $row['intOrderIndex'];
                    $deliveryname  = $row['strDeliveryName'];
                    $productnumber = $row['intProductIndex'];
                    $producttitle  = $row['strProductTitle'];
                    $quantity      = $row['intQuantity'];
                    $productprice  = $row['decSellingPrice'];
                    $productprice  = number_format($productprice, 2, '.', '');
                    $producttotal  = $row['decTotalSellingPrice'];
                    $producttotal  = number_format($producttotal, 2, '.', '');
                    $ordertotal    += $producttotal;
                    $ordertotal    = number_format($ordertotal, 2, '.', '');                
				    $tempDate      = $row['dtmOrderDate'];
				    $date          = strtotime($tempDate);
                    $orderDate     = date("m/d/y", $date);									
				?>			
				<table id="ordersTable" cellspacing="0">
					<tr bgcolor="yellow">
						<td>
							<table bgcolor="yellow">
								<td style="width:350px" class="topHeader">
									Order # <?=$intOrderIndex; ?>
								</td>
								<td style="width:250px" class="topHeader">
									Order Date: <?=$orderDate; ?>
								</td>								
								<td style="width:100px" class="topHeader">&nbsp;</td>
							</table>
						</td>			
					</tr>														
					<tr>
						<tr>
							<td style="width:700px"><hr/></td>				
						</tr>
						<!-- Table header section -->							
						<td>
							<table id="header-table">									
								<td style="width:100px" class="header">Item #</td>
								<td style="width:200px" class="header">Product(s)</td>
								<td style="width:100px" class="header">Quantity</td>
								<td style="width:150px" class="header">Price(ea)</td>
								<td style="width:150px" class="header">Product Total</td>
							</table>
						</td>
						<tr>
							<td style="width:700px"><hr/></td>				
						</tr>
						<!-- Product data section -->
						<?php
						$sql = "SELECT * 
								FROM VAllCustomerOrderSummaries
								WHERE intCustomerID='$customerid' 
								AND intOrderIndex='$intOrderIndex'
								ORDER BY intProductIndex";
						$results = $conn->query($sql);		
						while($row = $results->fetch(PDO::FETCH_ASSOC))
						{
							$productnumber = $row['intProductIndex'];
							$producttitle  = $row['strProductTitle'];
							$quantity      = $row['intQuantity'];
							$productprice  = $row['decSellingPrice'];
							$productprice  = number_format($productprice, 2, '.', '');
							$producttotal  = $row['decTotalSellingPrice'];
							$producttotal  = number_format($producttotal, 2, '.', '');
							?>
							<tr>							
								<td>
									<table>
										<td style="width:100px" class="row">
											<?=$productnumber; ?>
										</td>
										<td style="width:200px" class="row">
											<?=$producttitle; ?>
										</td>
										<td style="width:100px" class="row">
											<?=$quantity;?>
										</td>		
										<td style="width:150px" class="row">
											<?= "$" . $productprice; ?>
										</td>
										<td style="width:150px" class="row">
											<?= "$" . $producttotal; ?>
										</td>
									</table>
								</td>
							</tr>
						<?php	
						}
						?>								
							<tr>
								<td style="width:700px"><hr/></td>
							</tr>				
						</tr>		
					</tr>
					<!-- Get data for the final table rows -->
					<?php
						$sql = 
						"SELECT * 
						 FROM VIndividualOrderSummaries
						 WHERE intCustomerID='$customerid' 
						 AND intOrderIndex='$intOrderIndex'";
						$results = $conn->query($sql);
						while($row = $results->fetch(PDO::FETCH_ASSOC))
						{					
							$deliveryname   = $row['strDeliveryName'];
							$shippingcharge = $row['decShippingCharge'];
							$shippingcharge = number_format($shippingcharge, 2, '.', '');
							$total_price    = $row['decOrderTotalPrice'];
							$total_price    = number_format($total_price, 2, '.', '');					
						}					
						// Add a row if any shipping charges apply
						if($shippingcharge != 0.00)
						{
							echo
							"<tr style='padding-right:20px'>
								<td>
									<table>												
										<td class='row' style='width:300px;'>&nbsp;</td>
										<td class='row'>Next-Day Shipping Charge:</td>
										<td class='row' style='width:113px;'></td>
										<td class='row' style='min-width:40px;'>$$shippingcharge</td>
									</table> 
								</td>																	
							</tr>";
						}
					?>
					<!-- Recipient & order-total row -->						
					<tr bgcolor="yellow">
						<td>
							<table>
								<td style="width:400px"class="totals">
									<a href='my_account.php?menukey=5&amp;orderNumber=
										<?=$intOrderIndex;?>'> Delivered to: <?=$deliveryname;?>
									</a>
								</td>
								<td style="width:150px"class="totals" align="right">
									Order Total:
								</td>
								<td style="width:150px"class="totals" align="center">
									$<?=$total_price;?>
								</td>
							</table>
						</td>
					</tr>																		
				</table>
				<br>
				<?php
				}
			}						
		?>
		</div>
	<?php
	}
	// No previous orders 
	else
	{
	?>					
		<p style="font-face:bolder;font-size:30px;color:black;text-align:center">
			You have no previous orders.
		</p>
	<?php	
	}
}								
?>

	


