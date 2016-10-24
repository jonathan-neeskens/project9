<?php include "includes/head.php" ?>
    <body>
        <?php include "includes/menu.php" ?>
        <div class="canvas bit-90">
            <input class="searchField" placeholder="Zoek naar klanten..." type="text">
            <i class="fa fa-search"></i>

            <?php search("customers"); ?>
            <div class="innerCanvas">
                <?php customer_list() ?>
            </div>

            <a href="add_cutsomer.php" class="addbutton">
                <i> + </i>
            </a>
            <div class="popup" style="display: none;"></div>
            <script>
                if (window.location.href.indexOf("add=success") != -1){
                    alert('Toevoegen van klant was succesvol. Dit bericht moet binnenkort veranderd worden in een pop-up.');
                    //addclass 'zichtbaar' aan <div class='popup'>
                }
                else if (window.location.href.indexOf("change=success") != -1){
                    alert('Aanpassen van klant was succesvol. Dit bericht moet binnenkort veranderd worden in een pop-up.');
                    //addclass 'zichtbaar' aan <div class='popup'>
                }

                else if (window.location.href.indexOf("delete=success") != -1){
                    alert('Verwijderen van klant was succesvol. Dit bericht moet binnenkort veranderd worden in een pop-up.');
                    //addclass 'zichtbaar' aan <div class='popup'>
                }
            </script>
        </div>
    </body>
</html>
