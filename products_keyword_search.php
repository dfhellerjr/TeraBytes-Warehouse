<!-- --------------------------------------------------------------------------
--   Name: products_keyword_search.php
--   Abstract: Search for products by keywords
--   A very simple search based upon brand and category keywords (in that order)
-- --------------------------------------------------------------------------->
<?php
    $count = 0;
    $search_variable = "";
    $header = "";   

    // If keyword is set
    if($_SESSION['KeywordSearch'] !="") 
    {
        $search_query = $_SESSION['KeywordSearch'];				
    }   
    else
    {
        $search_query = "";
    }
    
    // If no query
    if($search_query == "")
    {
        echo 
        "<p style='font-size:30px;color:black;margin-bottom:20px;margin-left:260px'>
            <b>No product selected!</b>
        </p>
        <p>&nbsp;</p>";  
    }
    else
    {        
        if(strlen($search_query) > 1)
        {
            // Brands
            $query =
            "SELECT * 
             FROM VActiveProducts 
             WHERE strBrandTitle LIKE '%" . $search_query . "%'";       
            $results = $conn->query($query);            
            $count   = $results->rowCount();
            $search_variable = "brands"; 
            
            // Categories
            if($count < 1)
            {
                // Categories 
                $query =
                "SELECT * 
                 FROM VActiveProducts 
                 WHERE strCategoryTitle 
                 LIKE '%" . $search_query . "%'";  
                $results = $conn->query($query);
                $count   = $results->rowCount(); 
                $search_variable = "categories"; 
               
            }
        }  
        // No product matched
        if($count == 0)
        {
            echo 
            "<p style='font-size:30px;color:black;margin-bottom:20px;margin-left:260px'>
                <b>Products not found!</b>
             </p>"; 
        }
        else
        {
            // Categories
            if($search_variable == "categories")
            {
                while($row = $results->fetch(PDO::FETCH_ASSOC))
                {
                    $header = $row['strCategoryTitle' ];
                }                
                echo
                '<div class="content-header">
                    <h2>'. $header . '</h2>
                </div>';                 
            }
            else
            {
                // Brands
                while($row = $results->fetch(PDO::FETCH_ASSOC))
                {
                    $header = $row['strBrandTitle' ];
                }
                echo
                '<div class="content-header">
                    <h2>' . $header . '&nbsp;Products</h2>
                </div>';                
            }

            // Desired # of results/page
            $results_per_page = 6;

            // Determine number of pages needed
            $number_of_pages = ceil($count/$results_per_page);
            
            // Determine which page # the user has selected (default to 1) 
            if (!isset($_GET['page'])) 
            {
                $page = 1;
            } 
            else 
            {
                $page = $_GET['page'];
            }            
            // Get offset value
            $offset = $results_per_page * ($page-1);
            
            // Limit result set within bounds
            $results = $conn->query($query ." LIMIT {$offset}, {$results_per_page}");    
            
            // Obtain and display the data
            while($row = $results->fetch(PDO::FETCH_ASSOC))
            {
                $productid    = $row['intProductID'];
                $producttitle = $row['strProductTitle'];
                $productprice = $row['decSellingPrice'];			
                $productimage = $row['strProductImage'];
            ?>            			                     			
                <div class='product'>
                    <h3><?=$producttitle;?></h3>
                    <img src='admin_area/product_images/<?=$productimage;?>'/>
                    <p>
                        Price: $<?=$productprice;?>
                    </p>
                    <a class='detail' href='index.php?menukey=3&amp;productid=
                        <?=$productid;?>>'>Details
                    </a>
                    <a href='index.php?add_cart=<?=$productid;?>'>
                        <button class='cart-button'></button>
                    </a>
                </div>
            <?php
            }
            ?>
            <!-- Pagination nav bar -->
            <div class="page_list" style="clear:both; text-align:center; padding-top:20px">        
            <?php
            if($number_of_pages > 1)
            {       
                // Page links
                for($page = 1; $page <= $number_of_pages; $page ++)
                {       
                    echo 
                    '<a href="index.php?menukey=4&amp;page=' . $page . '">' . $page . '</a>';   
                }
            }                 
            ?>            
        </div>                   
    <?php
    }   
}














