<?php include "includes/head.php" ?>
<body>
<div class="layer"></div>
<div class="popup">
    <?php
    if($_GET['receipt_id']){
        echo "<script> $('.popup').addClass('visible'); $('.layer').addClass('visible'); </script>";
        get_receipt($_GET['receipt_id']);
    }


    ?>
    <button onclick="invisible()">Sluiten</button>
</div>
        <?php include "includes/menu.php" ?>
        <div class="canvas" style="background: none!important; box-shadow: none!important; margin-top: 0px!important; padding-top: 75px;">
            <a href="table_settings.php">
                <i class="fa fa-cog fa-2x"></i>
            </a>
            <?php
                table_list();
            ?>

        </div>
        <script>
            function invisible(){
                $('.popup').removeClass('visible');
                $('.layer').removeClass('visible');
            }
        </script>
    </body>
</html>
