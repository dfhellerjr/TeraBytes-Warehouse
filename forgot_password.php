<!-- -------------------------------------------------------------------------------
<!-- Name: forgot_password.php
<!-- Abstract: A form to allow a customer to login to the site when the password
<!-- has been forgotten. A randomly generated password is forwarded to the customer's
<!-- email address.  
<!-- ------------------------------------------------------------------------------>
<?php
if(isset($_POST['submit-password']))
{
	$username = test_input($_POST['username']);
    $query = 
    "SELECT * 
     FROM tcustomers 
     WHERE strUserName='$username'";
    $result = $conn->query($query);

    // If no match is found
    if($result->rowCount() == 0)
	{
		// Display error message
		echo "<script>alert('User Name not found. Please try again.')</script>";		
	}
	else
	{
        $row = $result->fetch(PDO::FETCH_ASSOC);
		// Set customerid
		$_SESSION['CustomerID'] = $row['intCustomerID'];
				
        // Redirect to reset_password.php
        echo "<script>window.open('index.php?menukey=54', '_self')</script>";   
	}
}
?>

<!-- Forgot password form -->
<form name="frmForgotPassword" id="frmForgotPassword" action="" method="post">
    <table width="500px" cellspacing="8" bgcolor="#1258DC" frame="box">
        <tr align="center">
            <td colspan="3">
                <h2 style="color:white"><u>Forgot Password?</u></h2>
            </td>
        </tr>		
        <tr align="center">
            <td align="right"><b style="color:white">User Name:</b></td>
            <td colspan="2" align="left">
                <input class="forgot-username" type="text" name="username" 
                       placeholder="&nbsp;Enter your user name" required />
            </td>
        </tr>        
        <tr>
            <td align="right">
                <input type="submit" name="submit-password" value="Reset Password"/>
            </td>
            <td align="center">                
                <a href="index.php?menukey=5" class="return">Return to Login</a> 		            
            </td>
        </tr>       
    </table>						
</form>