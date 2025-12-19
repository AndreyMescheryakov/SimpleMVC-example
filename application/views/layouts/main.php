<?php 
use ItForFree\SimpleMVC\Config;


$User = Config::getObject('core.user.class');

?>
<!DOCTYPE html>
<html>
    <?php include('includes/main/head.php'); ?>
    <body> 
        <div id="container">
            <?php include('includes/main/header.php'); ?>
            <div class="container">
                <?= $CONTENT_DATA ?>
            </div>
            <?php include('includes/main/footer.php'); ?>
        </div>
    </body>
</html>
