<?php include "includes/head.php" ?>
<body>
        <?php include "includes/menu.php" ?>
        <div class="canvas" style="background: none!important; box-shadow: none!important; margin-top: 0px!important; padding-top: 75px;">
            <a href="table_settings.php">
                <i class="fa fa-cog fa-2x"></i>
            </a>
            <?php table_list() ?>
            <div class="popup">
               <?php
                    if($_GET['receipt_id']){
                        echo "<script> $('.popup').addClass('visible') </script>";
                        get_receipt($_GET['receipt_id']);
                        
                    }
                ?>

            </div>
        </div>
    </body>
</html>
