<?php include "includes/head.php" ?>
    <body>
        <?php include "includes/menu.php" ?>
        <div class="canvas bit-90">
            <input class="searchField" type="text">

            <?php search("customers"); ?>
            <div class="innerCanvas">
                <?php customer_list() ?>
            </div>

            <a href="#" class="addbutton">
                <i> + </i>
            </a>
        </div>
    </body>
</html>
