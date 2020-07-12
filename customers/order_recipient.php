<!-- --------------------------------------------------------------------------
--   Name: order_recipient.php
--   Abstract: Order recipient table dadat
-- --------------------------------------------------------------------------->
<?php	
    // Initialize variables
    $customerid = $_SESSION['CustomerID'];
    $orderNumber = $_GET['orderNumber']; 
    $recipientName = "";
    $address1 = "";
    $address2 = "";
    $city = "";
    $state = "";
    $country = "";
    $zip = "";

    // Get recipient information
    $query = 
    "SELECT * 
    FROM VCustomerOrderDeliveryAddresses
    WHERE intCustomerID='$customerid'
    AND intOrderIndex='$orderNumber'";
    $results = $conn->query($query);
    while($row = $results->fetch(PDO::FETCH_ASSOC))
    {
        $recipientName = $row['strDeliveryName'];
        $address1      = $row['strAddress1'];
        $address2      = $row['strAddress2'];
        $city          = $row['strCity'];
        $state         = $row['strState'];
        $country       = $row['strCountry'];
        $zip           = $row['strZipCode'];
    }
?>
   
<!-- Order recipient table -->
<div class="recipient-header">
    <h3>Order Recipient</h3>			
</div>			
<table class="recipientdatatable">
    <tr>                                    
        <td>
            <input type="text" value='<?=$recipientName;?>'>
        </td>               
    </tr>				
    <tr>		                   
        <td>
            <input type="text" value='<?=$address1;?>'>
        </td>               
    </tr>						
    <tr>		           
        <td>
            <input type="text" value='<?=$address2;?>'>
        </td>
    </tr>						
    <tr>					                        
        <td>
            <input type="text" value='<?=$city;?>'>
        </td>                    
    </tr>						
    <tr>					
        <td>
            <input type='text' value='<?=$state;?>'>
        </td>
    </tr>
    <tr>            																	            <td>           
            <input type='text' value='<?=$country;?>'>
        </td>          
    </tr>	
    <tr>
        <td>
            <input type='text' value='<?=$zip;?>'>
        </td>
    </tr>                       
</table>
<div class="recipient-button">
    <a href="my_account.php?menukey=3">
        <h3>Back To Orders</h3>
    </a>
</div>	
         