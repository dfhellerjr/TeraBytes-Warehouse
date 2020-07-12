<!-- --------------------------------------------------------------------------
--   Name: sidebar.php
--   Abstract: The sidebar for both the index & customer pages
-- --------------------------------------------------------------------------->
<?php
// Index page
if($_SESSION['page'] == 'index')
{
?>
    <!-- Categories -->
    <div class="sidebar_title">Categories</div>
    <ul class="sidebar_categories sidebar_links">
        <?php
            $query = 
            "SELECT * 
             FROM tcategories
             WHERE intCategoryStatusID = 1";
            $results = $conn->query($query);
            $rows    = $results->fetchAll(); 
        // Loop through rows
        foreach($rows as $row)
        {
            $categoryid    = $row['intCategoryID'];
            $categorytitle = $row['strCategoryTitle'];
        ?>       
            <!-- Display each category name as link -->            
            <li class=sidebar_list>
                <a href="index.php?menukey=1&amp;categoryid=<?=$categoryid;?>">
                    <?=$categorytitle ?>
                </a>
            </li>
        <?php
        }	
        ?>
    </ul>
    <!-- Brands -->				
    <div class="sidebar_title">Brands</div>
    <ul class="sidebar_brands sidebar_links">
        <?php
            $query = 
            "SELECT * 
             FROM tbrands
             WHERE intBrandStatusID = 1
             ORDER BY strBrandTitle";
            $results = $conn->query($query);
            $rows    = $results->fetchAll(); 
        // Loop through rows
        foreach($rows as $row)
        {
            $brandid = $row['intBrandID'];
            $brandtitle = $row['strBrandTitle'];
        ?>       
            <!-- Display each brand name as link -->        
            <li class=sidebar_list>
                <a href="index.php?menukey=1&amp;brandid=<?=$brandid;?>">
                    <?=$brandtitle ?>
                </a>
            </li>
        <?php
        }	
        ?>
    </ul>
<?php
}
// Customer page
else
{
?>
    <section id=customer_sidebar">
        <div class="sidebar_title">My Account</div>
        <ul class="sidebar_categories">
            <li><a href="my_account.php?menukey=3">My Orders</a></li>
            <li><a href="my_account.php?menukey=1">Edit Account</a></li>
            <li><a href="my_account.php?menukey=2">Change Password</a></li>
            <li><a href="my_account.php?menukey=4">Delete Account</a></li>
            <li><a href="../index.php?menukey=53">Logout</a></li>
        </ul>    
    </section>
<?php
}
?>