<!-- --------------------------------------------------------------------------
--   Name: logout.php
--   Abstract: Log out of Administrator session   
-- --------------------------------------------------------------------------->
<?php
    session_start();
    session_destroy();
    echo "<script>window.open('login.php', '_self')</script>";
?>