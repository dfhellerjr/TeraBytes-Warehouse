<!-- --------------------------------------------------------------------------
--   Name: header.php
--   Abstract: The header section 
-- --------------------------------------------------------------------------->
<?php
if($_SESSION['page'] == 'index')
{
?>
    <img class="logo" src="images/terabytes.jpeg" />
    <img class="banner" src="images/banner2.jpg" /> 
    <span class="banner-text">Warehouse</span>  
    <div id="animate">
        <p>The best tech products for less!</p>
    </div>
     
<?php
}
else
{
?>
    <img class="logo" src="../images/terabytes.jpeg" />
    <img class="banner" src="../images/banner2.jpg" />
    <span class="banner-text2">Warehouse</span>  
    <div id="animate">
        <p>The best tech products for less!</p>
    </div>
<?php
}
?>

    