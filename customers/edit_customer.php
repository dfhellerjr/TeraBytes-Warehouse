<!-- --------------------------------------------------------------------------
--   Name: edit_customer.php
--   Abstract: Customer edit form 
-- --------------------------------------------------------------------------->
<?php
    // Initialize variables
    $customerid    = $_SESSION['CustomerID'];
    $ErrorMessages = array();	
    $Error         = "";			
    $Length        = 0;
    $customernameError = $address1Error = $address2Error = $cityError = $stateError =
    $zipcodeError = $emailError = $phoneError = false;

    // Get customer data from database 
    $sql = "SELECT * FROM VAllCustomerData
            WHERE intCustomerID = '$customerid'"; 
    $result = $conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    // Assign initial values from database to form variables
    $customerid   = $row['intCustomerID'];
    $ip           = $row['strIPAddress'];
    $customername = $row['strCustomerName'];
    $address1     = $row['strAddress1'];
    $address2     = $row['strAddress2'];
    $city         = $row['strCity'];
    $state        = $row['strState'];
    $countryid    = $row['intCountryID'];
    $strCountry   = $row['strCountry'];
    $zipcode      = $row['strZipCode'];
    $username     = $row['strUserName'];
    $password     = $row['strPassword'];
    $email        = $row['strEmailAddress'];
    $phone        = $row['strPhoneNumber'];

    // If form submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        // Retrieve new values from form
        $customername = test_input($_POST['edit-customername']);
        $address1     = test_input($_POST['edit-address1']);
        $address2     = test_input($_POST['edit-address2']);
        $city         = test_input($_POST['edit-city']);
        $state        = test_input($_POST['edit-state']);
        $countryid    = test_input($_POST['edit-country']);	
        $zipcode      = test_input($_POST['edit-zipcode']);
        $username     = test_input($_POST['edit-username']);
        $password     = test_input($_POST['edit-password']);
        $email        = test_input($_POST['edit-email']);
        $phone        = test_input($_POST['edit-phone']);

        // ------------------------------------------------------------------------
        // Validate form input fields (server-side)
        // ------------------------------------------------------------------------
        // Customer name        
        if(empty($customername))
        {
            $Error = "-- Enter your customer name";
            array_push($ErrorMessages, $Error);       
            $customernameError = true;
        }
        // Proper length?
        else 
        {
            if((strlen($customername) < 4) || (strlen($customername) > 30))
            {
                $Error = "-- Name must be 4-30 characters (incl spaces)";
                array_push($ErrorMessages, $Error);
                $customernameError = true;
            }		
            // Test format (start with a letter; these special characters allowed: - . ' , and space) 
            $pattern = '/^[a-zA-Z\'][0-9a-zA-Z-.,\'\s]*$/';
            if (!preg_match($pattern, $customername))
            {
                $Error = "-- Name must start with a letter with <b> . ' - , </b>allowed";
                array_push($ErrorMessages, $Error);
                $customernameError = true;
            }
        }        
        // Address 1               
        if(empty($address1))
        {
            $Error = "-- Enter your address";
            array_push($ErrorMessages, $Error);
            $address1Error = true;
        }
        else
        {	
            // Proper length?
            if(strlen($address1) < 4 || strlen($address1) > 30)
            {
                $Error = "-- Address1 must be 4-30 characters (incl spaces)";
                array_push($ErrorMessages, $Error);
                $address1Error = true;
            }		
            // Test format (alphanumeric with special characters allowed: - . ' , # and space) 
            $pattern = '/^[a-zA-Z0-9 .,\'#-]*$/';
            if (!preg_match($pattern, $address1))
            {
                $Error = "-- Address must be alphanumeric with <b> . ' , - or # </b>allowed";
                array_push($ErrorMessages, $Error);
                $address1Error = true;
            }				
        }			
        // Address2         
        if(!empty($address2))
        {
            // Proper length?
            if(strlen($address2) > 30)
            {
                $Error = "-- Address2 can not exceed 30 characters";
                array_push($ErrorMessages, $Error);
                $address2Error = true;
            }		
            // Test format (alphanumeric with these special characters allowed: - . ' , # and space) 
            $pattern = '/^[a-zA-Z0-9 -.,\'# ]*$/';
            if(!preg_match($pattern, $address2))
            {
                $Error = "-- Address2 must be alphanumeric with <b> ' . , - or # </b>allowed";
                array_push($ErrorMessages, $Error);
                $address2Error = true;
            }				
        }	
        // City 
        if(empty($city))
        {
            $Error = "-- Enter your city";
            array_push($ErrorMessages, $Error);
            $cityError = true;
        }
        else
        {
            // Proper length?
            if(strlen($city) > 30)
            {
                $Error = "-- City name can not exceed 30 characters";
                array_push($ErrorMessages, $Error);
                $cityError = true;
            }		
            // Test format (start with a letter; these special characters allowed: - . ' , and space) 
            $pattern = '/^[a-zA-Z\'][0-9a-zA-Z-.,\'\s]*$/';
            if (!preg_match($pattern, $city))
            {
                $Error = "-- City must start with a letter with - . ' , and space allowed";
                array_push($ErrorMessages, $Error);
                $cityError = true;
            }				
        }		
        // State 
        if(empty($state))
        {
            $Error = "-- Enter your state/region/province";
            array_push($ErrorMessages, $Error);
            $stateError = true;
        }
        else
        {
            // Proper length?
            if(strlen($state) > 30)
            {
                $Error = "-- State/region/province can not exceed 30 characters";
                array_push($ErrorMessages, $Error);
                $stateError = true;
            }		
            // Test format (start with a letter; these special characters allowed: - . ' , and space) 
            $pattern = '/^[a-zA-Z\'][0-9a-zA-Z-.,\'\s]*$/';
            if (!preg_match($pattern, $state))
            {
                $Error = "-- State must start with a letter with - . ' , and space allowed";
                array_push($ErrorMessages, $Error);
                $stateError = true;
            }				
        }		
        // ZipCode 
        if(!empty($zipcode))
        {        
            $pattern = '/^[0-9]{5}(?:-[0-9]{4})?$/';            
            if(!preg_match($pattern, $zipcode))
            {
                $Error = "-- Invalid Zipcode: ##### or #####-####";
                array_push($ErrorMessages, $Error);
                $zipcodeError = true;
            }	
        }
        else
        {
            $Error = "-- Zipcode can not be blank";
            array_push($ErrorMessages, $Error);
            $zipcodeError = true;  
        }
        // Email address
        if(empty($email))
        {
            $Error = "-- Enter your Email Address";
            array_push($ErrorMessages, $Error);
            $emailError = true;
        }
        else
        {
            $pattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/';
            if (!preg_match($pattern, $email))
            {
                $Error = "-- Invalid Email Address";
                array_push($ErrorMessages, $Error);
                $emailError = true;
            }		
        }
        // Phone number
        if(!empty($phone))
        {
            if(strlen($phone) > 15 )
            {
                $Error = "-- Phone number may not exceed 15 characters";
                array_push($ErrorMessages, $Error);
                $phoneError = true;
            }
        }
        $Length = count($ErrorMessages);
        // If no errors, edit customer in database
        if($Length == 0)
        {
            // Edit customer data
            $sql = 'CALL uspEditCustomer(?,?,?,?,?,?,?,?,?,?,?,?,?)';
            $stmt = $conn->prepare($sql);
            // Bind parameters
            $stmt->bindParam(1, $customerid, PDO::PARAM_INT, 11);
            $stmt->bindParam(2, $ip, PDO::PARAM_STR, 50);
            $stmt->bindParam(3, $customername, PDO::PARAM_STR, 50);
            $stmt->bindParam(4, $address1, PDO::PARAM_STR, 50);
            $stmt->bindParam(5, $address2, PDO::PARAM_STR, 50);
            $stmt->bindParam(6, $city, PDO::PARAM_STR, 50);
            $stmt->bindParam(7, $state, PDO::PARAM_STR, 50);
            $stmt->bindParam(8, $countryid, PDO::PARAM_INT, 11);
            $stmt->bindParam(9, $zipcode, PDO::PARAM_STR, 50); 
            $stmt->bindParam(10, $username, PDO::PARAM_STR, 50);
            $stmt->bindParam(11, $password, PDO::PARAM_STR, 50); 
            $stmt->bindParam(12, $email, PDO::PARAM_STR, 50);  
            $stmt->bindParam(13, $phone, PDO::PARAM_STR, 50);
            $stmt->execute(); 
            $stmt->closeCursor();       
           
            // Redirect to my_account.php
            echo "<script>window.open('my_account.php', '_self')</script>";              
        }
    }
?>

<!-- Server-side error testing section -->
<section id="edit-errors">
    <?php
    if(isset($_POST['customer-edit'])) 	
    {
        // Display any error messages
        $Length = count($ErrorMessages);	
        if($Length > 0)
        {			
            echo 
            "<div class='errorgroup'>
                <span class='firstline'>Please correct the following errors:</span><br>
             	<span class='message' id='edit-message'>";								
                    foreach($ErrorMessages as $message)
                    {
                        echo "&nbsp;&nbsp;" . $message . "<br />";
                    }
             	"</span>
            </div>";
        }
    }
    ?>
</section>

<!-- Customer Edit form -->
<form name="frmCustomerEdit" id="frmCustomerEdit" action="" method="post"
      onsubmit="return IsValidData(this);"> 
    <div class="edit-header">
        <h2>Edit Your Account</h2>			
    </div>
    <!-- Customer edit table -->            
    <table name="edit-customerdata" id="edit-customerdata" width="500" cellspacing="4" frame="Box">
        <tr>           
            <td>
                <label for "edit-customername">Name: 
                    <span class="tip">(4-30 characters)</span>
                </label>
                <span class="required">*</span>
            </td>
            <td>
                <input type="text" id="edit-customername" name="edit-customername" required		               class="<?php if($customernameError == "true"){echo "error-message";}?>"  
                       value='<?=$customername;?>'>
            </td>					            
        </tr>				
        <tr>
            <td>
                <label for "edit-address1">Address 1:</label>
                <span class="required">*</span>
            </td>
            <td>
                <input type="text" id="edit-address1" name="edit-address1" required
                       class="<?php if($address1Error == "true"){echo "error-message";}?>"
                       value='<?=$address1;?>'>
            </td>
        </tr>						
        <tr>
            <td>
                <label for "edit-address2">Address 2:</label>
            </td>
            <td>            
                 <input type="text" id="edit-address2" name="edit-address2"  
                        class="<?php if($address2Error == "true"){echo "error-message";}?>"
                        value='<?=$address2;?>'>
            </td>
        </tr>						
        <tr>
            <td>
                <label for "edit-city">City:</label>
                <span class="required">*</span>
            </td>
            <td>
                <input type="text" id="edit-city" name="edit-city" required 
                       class="<?php if($cityError == "true"){echo "error-message";}?>"
                       value='<?=$city;?>'>
            </td>
        </tr>						
        <tr>
            <td>
                <label for "edit-state">State/Region/Province:</label>
                <span class="required">*</span>
            </td>
            <td>
                <input type='text' id='edit-state' name='edit-state' required 
                       class="<?php if($stateError == "true"){echo "error-message";}?>"
                       value='<?=$state;?>'>
            </td> 
        </tr>
        <tr>
            <td>
                <label for "edit-country">Country:</label>
                <span class="required">*</span>
            </td> 
            <td>            
                <select name="edit-country" id="edit-country">
                    <option value="<?=$countryid;?>" selected><?=$strCountry;?></option>			
                    <!-- Create countries drop-down list -->					
                    <?=getAllCountries();?>	                    						
                </select>    									
            </td>
        </tr>	
        <tr>
            <td>
                <label for "edit-zipcode">Zip Code:</label>
                <span class="required">*</span>
            </td>
            <td>
                <input type='text' id='edit-zipcode' name='edit-zipcode' required 
                       class="<?php if($zipcodeError == "true"){echo "error-message";}?>"
                       value='<?=$zipcode;?>'>
            </td>
        </tr>
        <tr>            
            <td>
                <label for "edit-username">User Name: </label>
            </td>        
            <td>
                <input type='text' class='edit_user input-static' id='edit-username'                           name='edit-username' value='<?=$username;?>'>
            </td>                       
        </tr>
        <tr>
            <td>
                <label for "edit-password">Password:</label>
            </td>
            <td>
                <input type='password' class='edit_user input-static' id='edit-password'                       name='edit-password' value='<?=$password;?>'>
            </td>         
        </tr>
        <tr>
            <td>
                <label for "edit-email">Email Address:</label>
                <span class="required">*</span>
            </td>
            <td>
                <input type='email' id='edit-email' name='edit-email' required 
                       class="<?php if($emailError == "true"){echo "error-message";}?>"
                       value='<?=$email;?>'>
            </td>            
        </tr>
        <tr>
            <td><label for "edit-phone">Phone Number:<label></td>
            <td>
                <input type='text' id='edit-phone' name='edit-phone' 
                       class="<?php if($phoneError == "true"){echo "error-message";}?>"
                       value='<?=$phone;?>'>
            </td>
        </tr>		
        <tr>
            <!-- Hidden column to hold IP address -->
            <td>&nbsp;
                <input type='hidden' name='edit-ipaddress' value='<?=$ip;?>'>
            </td>
            <!-- Required field span -->
            <td>&nbsp;&nbsp;
                <span class="required">*</span>
                <span class="subscript">= Required Fields</span>
            </td>
        </tr>				
    </table>
    <div id="edit-buttons">       
        <input type="submit" name="customer-edit" style="margin-left:90px;" value="Edit Account">    	
        <input type="button" name="cancel" value="Cancel" onclick="location.href='my_account.php';">  
    </div>    					
</form>

<!-- -------------------------- JavaScript Section ----------------------------- -->
<script type="text/javascript">   
    // -----------------------------------------------------------------------------
    // Name: IsValidData
    // Abstract: Test if all input data is valid
    // Basic client-side testing to be augmented by more rigorous server-side tests
    // -----------------------------------------------------------------------------
    function IsValidData(form)
    {       
        var blnIsValidData = true;    // Easier to assume data is all valid       
        try
        {                   
            // Initialize
            var ErrorMessage = [];
            var strError = "";
            var index = 0; 
            var customername = form.elements['edit-customername'].value;
            var address1     = form.elements['edit-address1'].value;
            var address2     = form.elements['edit-address2'].value;
            var city         = form.elements['edit-city'].value;
            var state        = form.elements['edit-state'].value;
            var zipcode      = form.elements['edit-zipcode'].value;
            var email        = form.elements['edit-email'].value;
            var phone        = form.elements['edit-phone'].value;
            
            // Name                                                                                    
            if(customername.length < 4 ) 
            {
                ErrorMessage.push("- Customer Name must contain 4 - 30 characters\n");   
            }
            if(customername.length > 30 ) 
            {
                ErrorMessage.push("- Customer Name must contain 4 - 30 characters\n");   
            }                                          
            // Address1            
            if(address1.length > 30)
            {
                ErrorMessage.push("- Address1 must not exceed 30 characters\n");                      
            }
            // Address2                        
            if(address2.length > 30) 
            {
                ErrorMessage.push("- Address2 must not exceed 30 characters\n");      
            }            
            // City            
            if(city.length > 30) 
            {
                ErrorMessage.push("- City must not exceed 30 characters\n");        
            }
            // State            
            if(state.length > 30) 
            {
                ErrorMessage.push("- State must not exceed 30 characters\n");         
            }
            // Zipcode            
            if(zipcode.length > 15) 
            {
                ErrorMessage.push("- Zipcode must not exceed 15 characters\n");       
            }
            // Email           
            if(email.length > 30) 
            {
                ErrorMessage.push("- Email address must not exceed 30 characters\n");    
            }            
            // Phone
            if(phone != "")
            {
                if(phone.length > 15) 
                {
                    ErrorMessage.push("- Phone number must not exceed 15 characters\n");
                }   
            }                                             
            // If any input data is invalid
            if (ErrorMessage.length > 0)
            {
                for(index = 0; index < ErrorMessage.length; index += 1)
                {
                    strError += ErrorMessage[index]+""; 
                }
                // Display error message
                alert(strError);
                blnIsValidData = false;
            }           
        }
        catch (excError)
        {
            alert("frmCustomerEdit::IsValidData()\n"
                  + excError.name + ', ' + excError.strValue);
        }
        return blnIsValidData;
    }   
</script>