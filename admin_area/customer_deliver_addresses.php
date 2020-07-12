<!-- --------------------------------------------------------------------------
--   Name: order_recipient.php
--   Abstract: Order recipient table dadat
-- --------------------------------------------------------------------------->
<?php	
    // Initialize variables
    $customerid = $_GET['CustomerID'];
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
<!-- Style sheet -->
<link rel="stylesheet" href="styles/style7.css" media="all" />
<!-- Order recipient table -->
<div class="recipient-header">
    <h3>Order Recipient</h3>			
</div>			
<table class="recipientdatatable">
    <tr>                                    
        <td>
            <input type="text" class="static" value='<?=$recipientName;?>'>
        </td>               
    </tr>				
    <tr>		                   
        <td>
            <input type="text" class="static" value='<?=$address1;?>'>
        </td>               
    </tr>						
    <tr>		           
        <td>
            <input type="text" class="static" value='<?=$address2;?>'>
        </td>
    </tr>						
    <tr>					                        
        <td>
            <input type="text" class="static" value='<?=$city;?>'>
        </td>                    
    </tr>						
    <tr>					
        <td>
            <input type='text' class="static" value='<?=$state;?>'>
        </td>
    </tr>
    <tr>            																	            <td>           
            <input type='text'class="static" value='<?=$country;?>'>
        </td>          
    </tr>	
    <tr>
        <td>
            <input type='text' class="static" value='<?=$zip;?>'>
        </td>
    </tr>                       
</table>
<div class="recipient-button">
    <a href="index.php?menukey=81&amp;CustomerID=<?=$customerid;?>">
        <h3>Back To Orders</h3>
    </a>
</div>