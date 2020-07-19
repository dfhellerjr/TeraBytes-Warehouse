<!-- --------------------------------------------------------------------------
--  Name: checkout.php
--  Abstract: Display the customer's cart details and shipping information
--  for review prior to order submission/confirmation. The PayPal link-button
--  does not actually process a PayPal payment. 
-- --------------------------------------------------------------------------->
<?php
    // Initialize variables
    $customerid = $_SESSION['CustomerID'];
    $shipping = 0.00;
    $shippingcharge = number_format($shipping, 2, '.', '');
    $product_count = 0;

    // Get customer information for primary shipping table
    $query = 
    "SELECT * 
    FROM VAllCustomerDeliveryAddresses
    WHERE intCustomerID='$customerid'
    AND intDeliveryIndex= 1";
    $results = $conn->query($query);
    $count = $results->rowCount();
    if($count > 0)
    {
        $row = $results->fetch(PDO::FETCH_ASSOC);
        $customername = $row['strCustomerName'];
        $address1     = $row['strAddress1'];
        $address2     = $row['strAddress2'];
        $city         = $row['strCity'];
        $state        = $row['strState'];
        $country      = $row['strCountry'];	
        $zipcode      = $row['strZipCode'];	
    }
    // Get customer cart totals
    $query = 
    "SELECT * 
    FROM VCustomerCartTotalSummaries 
    WHERE intCustomerID='$customerid'";
    $results = $conn->query($query);
    while($row = $results->fetch(PDO::FETCH_ASSOC))
    {
        $product_count = $row['intTotalProducts'];
        $total_price   = $row['decTotalPrice'];
        $amountpayable = $total_price + $shippingcharge;
        $total_price   = number_format((float)$total_price, 2, '.', '');
        $amountpayable = number_format((float)$amountpayable, 2, '.', '');
    }
    // Primary shipping form post 
    if(isset($_POST['submit-primary']))
    {
        $shippingcharge = $_POST['ShippingCharge'];
        // Set session variables    
        $_SESSION['DeliveryIndex'] = 1;    
    }
    // Alternate shipping form post
    elseif(isset($_POST['submit-alternate']))
    {               
        // Assign fields
        $customername   = $_POST['altcustomername'];
        $address1       = $_POST['altaddress1'];
        $address2       = $_POST['altaddress2'];
        $city           = $_POST['altcity'];
        $state          = $_POST['altstate'];
        $countryid      = $_POST['altcountry'];	
        $zipcode        = $_POST['altzipcode'];
        $shippingcharge = $_POST['AltShippingCharge'];            
        // Add delivery address to database
        $sql = 'CALL uspAddDeliveryAddress(?,?,?,?,?,?,?,?)';
        $stmt = $conn->prepare($sql);
        // Bind parameters
        $stmt->bindParam(1, $customerid, PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 11);
        $stmt->bindParam(2, $customername, PDO::PARAM_STR, 50);
        $stmt->bindParam(3, $address1, PDO::PARAM_STR, 50);
        $stmt->bindParam(4, $address2, PDO::PARAM_STR, 50);
        $stmt->bindParam(5, $city, PDO::PARAM_STR, 50);
        $stmt->bindParam(6, $state, PDO::PARAM_STR, 50);
        $stmt->bindParam(7, $countryid, PDO::PARAM_INT, 11);
        $stmt->bindParam(8, $zipcode, PDO::PARAM_STR, 50);
        // Execute
        $stmt->execute();
        // Retrieve delivery index from database
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Assign session variable
        $_SESSION['DeliveryIndex'] = $row['intDeliveryIndex']; 
        $stmt->closeCursor(); 
    }
    // On post
    if(isset($_POST['submit-primary']) || isset($_POST['submit-alternate']))
    {    
        // Assign shipping charge session variable
        $_SESSION['ShippingCharge'] = $shippingcharge;
        // Redirect to confirm.php
        echo "<script>window.open('index.php?menukey=62', '_self')</script>";
    }
?>
<!-- Page header -->
<div id="checkout-heading">
    <h2>Please review your order</h2>
</div>
<div id="main-content">
    <!-- Order Summary Table -->    
    <div id="shoppingCart">         
        <div id="cart-header">
            <h3>Your Order Summary</h3>
        </div>                
        <table id="cartSummary">          
            <tr bgcolor="#00ccff">
                <th width="50px">Qty</th>
                <th width="200px">Item Description</th>
                <th width="60px">Price (ea)</th>
                <th width="60px">Total</th>
            </tr>
            <!-- Get customer's cart items -->
            <?php			
            $query = 
            "SELECT * 
             FROM VIndividualCustomerCartSummaries 
             WHERE intCustomerID='$customerid'";
            $results = $conn->query($query);
            $count = $results->rowCount();
            if($count > 0)
            {
                // Var used to alternate row color
                $b = 0;				
                // Loop through cart products
                while($row = $results->fetch(PDO::FETCH_ASSOC))
                {
                    // Alternate row background color
                    $bg_color = ($b++ %2 == 1) ? 'odd' : 'even';                                       
                    // Get product information
                    $producttitle    = $row['strProductTitle'];
                    $productprice    = $row['decProductPrice'];
                    $productquantity = $row['intQuantity'];
                    $producttotal    = $row{'decTotalProductPrice'};		                       
                    // Format
                    $producttotal  = number_format((float)$producttotal, 2, '.', '');             
                // Product summary section
                ?> 
                    <tr align="center" class="<?=$bg_color;?>">
                        <td><?=$productquantity;?></td>
                        <td><?=$producttitle;?></td>
                        <td>$<?=$productprice;?></td>
                        <td>$<?=$producttotal;?></td>							
                    </tr>
                <?php
                }
                ?>
                <!-- Total summary section  -->                       
                <tr bgcolor="#f8f7f7">
                    <td colspan="4"><hr/></td>
                </tr>
                <tr class="totals">
                    <td colspan="2"></td>
                    <td>SubTotal:</td>
                    <td>$<span id="subTotal"><?=$total_price;?></span></td>
                    <tr class="totals">						
                        <td class="ship-charge" align="left">
                            <input type="checkbox" name="chkShipping" id="chkShipping"> 
                        </td>
                        <td>
                            <label for="chkShipping">Next Day Shipping ($7.50/item)</label>
                        </td>
                        <td>Shipping:</td>
                        <td>                           
                            &nbsp;$<span id="shipping_charge"><?=$shippingcharge;?></span>
                        </td>
                    </tr>                                                    
                    <tr class="totals" >
                        <td colspan="2"></td>
                        <td>
                            <b>Order Total:</b>
                        </td>
                        <td>
                            $<span id="order-total"><?=$amountpayable;?></span>
                        </td>		
                    </tr>
                </tr>
            <?php
            } 
            ?>          
        </table>                       
        <span id="product-count"><?=$product_count;?></span>
        <!-- Back to cart button -->
        <a href="index.php?menukey=6" class="return">Back to Cart</a>			
    </div>
    <!-- Primary shippimg address/recipient form -->
    <div id="main-shipping">       
        <div id="shipping-header">
            <h3>Shipping Information*</h3>			
        </div>
        <form name="frmPrimaryAddress" id="frmPrimaryAddress" action="" method="post">   			
            <table name="customerdatatble" id="customerdatatable">
                <tr class='first'>                                    
                    <td>
                        <input type="text" id="customername" name="customername" 
                               class='edit_user input-static' value='<?=$customername;?>'>
                    </td>               
                </tr>				
                <tr>		                   
                    <td>
                        <input type="text" id="address1" name="address1" 
                               class='edit_user input-static' value='<?=$address1;?>'>
                    </td>               
                </tr>						
                <tr>		           
                    <td>
                        <input type="text" id="address2" name="address2" 
                               class='edit_user input-static' value='<?=$address2;?>'>
                    </td>
                </tr>						
                <tr>					                        
                    <td>
                        <input type="text" id="city" name="city" 
                               class='edit_user input-static' value='<?=$city;?>'>
                    </td>                    
                </tr>						
                <tr>					
                    <td>
                        <input type='text' id='state' name='state' 
                               class='edit_user input-static' value='<?=$state;?>'>
                    </td>
                </tr>
                <tr>																	
                    <td>
                        <input type='text' id='country' name='country' 
                               class='edit_user input-static' value='<?=$country;?>'>
                    </td>
                </tr>	
                <tr>
                    <td>
                        <input type='text' id='zipcode' name='zipcode' 
                               class='edit_user input-static' value='<?=$zipcode;?>'>
                    </td>
                </tr>               
                <tr>
                    <td>
                        <input type='text' id='prime-shipping' name='ShippingCharge' value='0.00'>
                    </td>
                </tr>                           
            </table>
            <input type='submit' name='submit-primary' id='submit-primary'> 
        </form>
    </div>
    <!-- Alternate shippimg address/recipient form -->
    <div id='alt-shipping'> 
        <form name="frmDeliveryAddress" id="frmDeliveryAddress" action="" method="post">      
            <div id="shipping-header">
                <h3>Alternative Shipping Data*</h3>			
            </div>			
            <table name="customeraltdatatable" id="customeraltdatatable">
                <tr class="first-row">                                    
                    <td>
                        <input type="text" id="altcustomername" name="altcustomername"                         placeholder="Recipient Name">
                    </td>               
                </tr>				
                <tr>		                   
                    <td>
                        <input type="text" id="altaddress1" name="altaddress1" placeholder="Address1"
                               required>
                    </td>               
                </tr>						
                <tr>		           
                    <td>
                        <input type="text" id="altaddress2" name="altaddress2" placeholder="Address2">
                    </td>
                </tr>						
                <tr>					                        
                    <td>
                        <input type="text" id=altcity" name="altcity" placeholder="City" required>
                    </td>                    
                </tr>						
                <tr>					
                    <td>
                        <input type='text' id='altstate' name='altstate' placeholder="State" required >
                    </td>
                </tr>
                <tr>																                
                    <td>           
                        <select name="altcountry" id="altcountry">
                            <option value="32" selected>United States</option>			
                                <!-- Create countries drop-down list -->					
                                <?=getAllCountries();?>	                    						
                        </select>
                    </td>          
                </tr>	
                <tr>
                    <td>
                        <input type='text' id='altzipcode' name='altzipcode' placeholder="Zip Code">
                    </td>
                </tr>                
                <tr>
                    <td>
                        <input type='text' id='alternate-shipping' name='AltShippingCharge'                    value='0.00'>
                    </td>
                </tr>                                           
            </table> 
            <input type='submit' name='submit-alternate' id='submit-alternate'>            
        </form>                    
    </div>
    <!-- Alternate delivery checkbox -->
    <div id="chkbox">										               
        <input type="checkbox" name="alt-chk" id="alt-chk" >
        <span>*Alternative address/recipient</span>                              
    </div>    
</div>
<!-- Payment button -->
<div id="payment">
    <h2> Click button below to confirm and submit your order!</h2>			    
    <button type="button" name="button1" id="button"></button>	
</div>