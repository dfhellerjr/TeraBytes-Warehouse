<!-- --------------------------------------------------------------------------
--   Name: menubar.php
--   Abstract: The menubar section 
-- --------------------------------------------------------------------------->
<?php
$search = "";   
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // If form submitted
    if(isset($_POST['submit']))
    {
        // Any search terms?
        if(!empty($_POST['txtUserQuery']))
        {
            $search = test_input($_POST['txtUserQuery']);
            if($search != "") 
            {
                // Assign keyword
                $_SESSION['KeywordSearch'] = $search;  
            }              
        }        
        else
        {
            $_SESSION['KeywordSearch'] = "";   
        }

        // Index page
        if($_SESSION['page'] == 'index')
        {      
            // Redirect to search page
            echo
            "<script>window.open('index.php?menukey=4', '_self')</script>";
        }
        // Customer page
        else
        {        
            // Redirect to search page            
            echo
            "<script>window.open('../index.php?menukey=4', '_self')</script>";    
        }     
    }         
}        
// Index page
if($_SESSION['page'] == 'index')
{ 
?> 
    <!-- Menu -->
    <ul class="menu">
        <li><a href="index.php?menukey=0">Home</a></li>
        <li><a href="index.php?menukey=2">All Products</a></li>
        <li><a href="customers/my_account.php">My Account</a></li>
        <li><a href="index.php?menukey=5">Sign Up</a></li>
        <li><a class="cart-link" href="index.php?menukey=6">Shopping Cart</a></li>
        <li><a href="index.php?menukey=7">Contact Us</a></li>
    </ul>
    <!-- Keyword search form -->
    <div id="form">
        <form name="frmSearch" id="frmSearch" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
              method="POST" enctype="multipart/form-data">
            <input type="text" class="user_query" name="txtUserQuery" onfocus="this.value=''"
                   placeholder="Search Brand or Category" value="<?php echo $search; ?>" />
            <input type="submit" name="submit" value=""/>				
        </form>
    </div>
<?php
}
// Customers page
else
{
?>
    <!-- Menu -->
    <ul class="menu">
        <li><a href="../index.php?menukey=0">Home</a></li>
        <li><a href="../index.php?menukey=2">All Products</a></li>
        <li><a href="my_account.php">My Account</a></li>
        <li><a href="../index.php?menukey=5">Sign Up</a></li>
        <li><a class="cart-link" href="../index.php?menukey=6">Shopping Cart</a></li>
        <li><a href="../index.php?menukey=7">Contact Us</a></li>
    </ul>
    <!-- Keyword search form-->				
    <div id="form">
        <form name="frmSearch" id="frmSearch" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
              method="POST" enctype="multipart/form-data">
            <input type="text" class="user_query" name="txtUserQuery" onfocus="this.value=''"
                   placeholder="Search Brand or Category" value="<?php echo $search; ?>" />
            <input type="submit" name="submit" value=""/>				
        </form>
    </div>
<?php
}
?>
