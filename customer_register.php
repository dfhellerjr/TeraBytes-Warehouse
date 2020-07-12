<!-- --------------------------------------------------------------------------
--   Name: customer_register.php
--   Abstract: Customer registration and/or edit form 
-- --------------------------------------------------------------------------->
<?php
    // Initialize variables
    $customerid    = $_SESSION['CustomerID'];
    $ErrorMessages = array();	
    $Error         = "";			
    $Length        = 0;
    $customernameError = $address1Error = $address2Error = $cityError = $stateError =
    $zipcodeError = $usernameError = $passwordError = $emailError = $phoneError = false;

    $customername  = "";
    $ip            = "";
    $address1      = "";
    $address2      = "";
    $city          = "";
    $state         = "";
    $countryid     = 0;
    $countrystatus = "";
    $zipcode       = "";
    $username      = "";
    $password      = "";
    $email         = "";
    $phone         = "";

    // If form submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {  
        $customername = test_input($_POST['customername']);
        $address1     = test_input($_POST['address1']);
        $address2     = test_input($_POST['address2']);
        $city         = test_input($_POST['city']);
        $state        = test_input($_POST['state']);
        $countryid    = test_input($_POST['country']);	
        $zipcode      = test_input($_POST['zipcode']);
        $username     = test_input($_POST['username']);
        $password     = test_input($_POST['password']);
        $email        = test_input($_POST['email']);
        $phone        = test_input($_POST['phone']);       
    
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
        else
        {		
            // Proper length?
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
            if(strlen($address1) > 30)
            {
                $Error = "-- Address can not exceed 30 characters";
                array_push($ErrorMessages, $Error);
                $address1Error = true;
            }		
            // Test format (alphanumeric with these special characters allowed: - . ' , # and space) 
            $pattern = '/^[a-zA-Z0-9 .,\'#-]*$/';
            if (!preg_match($pattern, $address1))
            {
                $Error = "-- Address must be alphanumeric with ' . , - or # allowed";
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
                $Error = "-- Address can not exceed 30 characters";
                array_push($ErrorMessages, $Error);
                $address2Error = true;
            }		
            // Test format (alphanumeric with these special characters allowed: - . ' , # and space) 
            $pattern = '/^[a-zA-Z0-9 -.,\'# ]*$/';
            if(!preg_match($pattern, $address2))
            {
                $Error = "-- Address must be alphanumeric with ' . , - or # allowed";
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
        //User name
        if(empty($username))
        {
            $Error = "-- Enter your User Name";
            array_push($ErrorMessages, $Error);
            $usernameError = true;
        }
        else 
        {
            // Test boundaries
            if((strlen($username) < 6) || (strlen($username) > 30))
            {
                $Error = "-- User Name must be between 6-30 characters";
                array_push($ErrorMessages, $Error);
                $usernameError = true;
            }
            else 
            {
                // Test if user name already exists
                $checkUser = 
                "SELECT * FROM tcustomers 
                WHERE strUserName = '$username'";
                $results = $conn->query($checkUser);
                $count = $results->rowCount(); 
                if($count != 0)
                {	
                    $Error = "-- This user name has already been assigned";
                    array_push($ErrorMessages, $Error);
                    $usernameError = true;
                }
            }
        }
        // Password
        if(empty($password))
        {
            $Error = "-- Enter your Password";
            array_push($ErrorMessages, $Error);
            $passwordError = true;
        }
        // Test boundaries
        else
        { 
            if((strlen($password) < 6) || (strlen($password) > 30))
            {
                $Error = "-- Password must be between 6-30 characters";
                array_push($ErrorMessages, $Error);
                $passwordError = true;            
            }
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

        // If no errors, add customer to database
        if($Length == 0)
        {				                      
            // Add customer to database
            $sql = 'CALL uspAddCustomer(?,?,?,?,?,?,?,?,?,?,?,?)';
            $stmt = $conn->prepare($sql);
            // Bind parameters
            $stmt->bindParam(1, $ip, PDO::PARAM_STR, 50);
            $stmt->bindParam(2, $customername, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 50);
            $stmt->bindParam(3, $address1, PDO::PARAM_STR, 50);
            $stmt->bindParam(4, $address2, PDO::PARAM_STR, 50);
            $stmt->bindParam(5, $city, PDO::PARAM_STR, 50);
            $stmt->bindParam(6, $state, PDO::PARAM_STR, 50);
            $stmt->bindParam(7, $countryid, PDO::PARAM_INT, 11);
            $stmt->bindParam(8, $zipcode, PDO::PARAM_STR, 50); 
            $stmt->bindParam(9, $username, PDO::PARAM_STR, 50);
            $stmt->bindParam(10, $password, PDO::PARAM_STR, 50); 
            $stmt->bindParam(11, $email, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 50);  
            $stmt->bindParam(12, $phone, PDO::PARAM_STR, 50);
            $stmt->execute();
            // Return variables
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['CustomerID'] = $row['intCustomerID']; 
            $separatedname = explode(" ", $customername);									
            $_SESSION['firstname'] = $separatedname[0];	
            $_SESSION['email'] = $row['strEmailAddress']; 
            $stmt->closeCursor();
            
            // Redirect to index.php
            echo "<script>window.open('index.php', '_self')</script>";            
        }
    }
?>

<!-- Server-side error section -->
<section id="errors">
    <?php
    if(isset($_POST['register'])) 	
    {
        // Display any error messages
        $Length = count($ErrorMessages);	
        if($Length > 0)
        {			
            echo 
            "<div class='errorgroup'>
                <span class='firstline'>Please correct the following errors:</span><br>
             	<span class='message' id='message'>";								
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

<!-- Customer Registration form -->
<form name="frmCustomerRegister" id="frmCustomerRegister" action="" method="post"
      onsubmit="return IsValidData(this);"> 
    <!-- New Account -->   
    <div class="register-header">
        <h2>Create New Account</h2>			
    </div> 
    <!-- Customer register table -->               
    <table name="customerdata" id="customerdata" width="500" cellspacing="4" frame="Box">
        <tr>           
            <td>
                <label for "customername">Name: 
                    <span class="tip">(4-30 characters)</span>
                </label>
                <span class="required">*</span>
            </td>					                                     
            <td>
                <input type="text" id="customername" name="customername" required		                       class="<?php if($customernameError == "true"){echo "error-message";}?>"
                       value='<?=$customername;?>'>
            </td>           
        </tr>				
        <tr>
            <td>
                <label for "address1">Street Address 1:</label>
                <span class="required">*</span>
            </td>
            <td>
                <input type="text" id="address1" name="address1" required 
                       class="<?php if($address1Error == "true"){echo "error-message";}?>"
                       value='<?=$address1;?>'>
            </td>            
        </tr>						
        <tr>
            <td>
                <label for "address2">Street Address 2:</label>
            </td>
            <td>            
                 <input type="text" id="address2" name="address2"  
                        class="<?php if($address2Error == "true"){echo "error-message";}?>"
                        value='<?=$address2;?>'>
            </td>            
        </tr>						
        <tr>
            <td>
                <label for "city">City:</label>
                <span class="required">*</span>
            </td>                              
            <td>
                <input type="text" id="city" name="city" required 
                       class="<?php if($cityError == "true"){echo "error-message";}?>"
                       value='<?=$city;?>'>
            </td>            
        </tr>						
        <tr>
            <td>
                <label for "state">State/Region/Province:</label>
                <span class="required">*</span>
            </td>           
            <td>
                <input type='text' id='state' name='state' required 
                       class="<?php if($stateError == "true"){echo "error-message";}?>"
                       value='<?=$state;?>'>
            </td>           
        </tr>
        <tr>
            <td>
                <label for "country">Country:</label>
                <span class="required">*</span>
            </td> 
            <td>            
                <select name="country" id="country">
                    <option value="32" selected>United States</option>			
                        <!-- Create countries drop-down list -->					
                        <?=getAllCountries();?>	                    						
                </select>            									
            </td>
        </tr>	
        <tr>
            <td>
                <label for "zipcode">Postal Code:</label>
                <span class="required">*</span>
            </td>          
            <td>
                <input type='text' id='zipcode' name='zipcode' required 
                       class="<?php if($zipcodeError == "true"){echo "error-message";}?>"
                       value='<?=$zipcode;?>'>
            </td>           
        </tr>
        <tr>            
            <td>
                <label for "username">User Name: 
                    <span class="tip">(6-30 characters)</span>
                </label>
                <span class="required">*</span>
            </td>                           
            <td>
                <input type='text' id='username' name='username' required 
                       class="<?php if($usernameError == "true"){echo "error-message";}?>"
                       value='<?=$username;?>'>
            </td>                                                                    
        </tr>
        <tr>
            <td>
                <label for "password">Password: 
                    <span class="tip">(6-30 characters)</span>
                </label>
                <span class="required">*</span>
            </td>                           
            <td>
                <input type='password' id='password' name='password' required
                       class="<?php if($passwordError == "true"){echo "error-message";}?>" 
                       value='<?=$password;?>'>
            </td>                         
        </tr>
        <tr>
            <td>
                <label for "email">Email Address:</label>
                <span class="required">*</span>
            </td>              
            <td>
                <input type='email' id='email' name='email' required 
                       class="<?php if($emailError == "true"){echo "error-message";}?>"
                       value='<?=$email;?>'>
            </td>                       
        </tr>
        <tr>
            <td><label for "phone">Phone Number:<label></td>               
            <td>
                <input type='text' id='phone' name='phone' 
                       class="<?php if($phoneError == "true"){echo "error-message";}?>"
                       value='<?=$phone;?>'>
            </td>            
        </tr>		
        <tr>
            <!-- Hidden column to hold IP address -->
            <td>&nbsp;
                <input type='hidden' name='ipaddress' value='<?=$ip;?>'>
            </td>
            <!-- Required field span -->
            <td>&nbsp;&nbsp;
                <span class="required">*</span>
                <span class="subscript">= Required Fields</span>
            </td>
        </tr>				
    </table>
    <div id="buttons">              
        <input type="submit" name="register" value="Create Account">      
        <input type="reset" name="clear" value="Clear Errors" onclick="btnClear_Click()">               
        <input type="button" name="cancel" value="Cancel" onclick="location.href='index.php';">		
    </div>    					
</form>

<!-- ------------------------ Javascript Section----------------------------- -->
<script type="text/javascript" language="javascript"> 
    // ----------------------------------------
    // btnClear_Click()
    // Clear any server-side error messages
    // ----------------------------------------
    function btnClear_Click()
    {
        try
        {
            var errors = document.getElementById("errors");           
            // Clear server-side error messages								
            if(errors.innerHTML != "") errors.innerHTML = "";
        }
        catch (excError)
        {
            alert("customer_register.php::btnClear()\n"
            + excError.name + ', ' + excError.message);
        }
    }

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
            var customername = form.elements['customername'].value;
            var address1     = form.elements['address1'].value;
            var address2     = form.elements['address2'].value;
            var city         = form.elements['city'].value;
            var state        = form.elements['state'].value;
            var zipcode      = form.elements['zipcode'].value;
            var email        = form.elements['email'].value;
            var phone        = form.elements['phone'].value;
            
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
            alert("frmCustomerRegister::IsValidData()\n"
                  + excError.name + ', ' + excError.strValue);
        }
        return blnIsValidData;
    }
</script>

			

