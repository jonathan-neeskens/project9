<?php include "includes/head.php";
session_destroy();
?>
<body>
<?php include "includes/menu.php"



?>
<div class="canvas bit-90">
    <input class="searchField" placeholder="Zoek naar reserveringen..." type="text">
    <i class="fa fa-search"></i>

    <?php search("reservations"); ?>
    <div class="innerCanvas">
            <div class='list_item first'>
                <div class="listbutton b1" <?php if ($_GET['view'] == 'today'){ echo "style='border-bottom: 3px solid #9c27b0'"; }?>>
                    <a href="reservations.php?view=today">Vandaag</a>
                </div>
                <div class="listbutton b2" <?php if ($_GET['view'] == 'week'){ echo "style='border-bottom: 3px solid #9c27b0'"; }?>>
                    <a href="reservations.php?view=week">Komende week</a>
                </div>
                <div class="listbutton b3" <?php if ($_GET['view'] == 'all'){ echo "style='border-bottom: 3px solid #9c27b0'"; }?>>
                    <a href="reservations.php?view=all">Alles</a>
                </div>
            </div>
        <?php reservation_list($_GET['view']); ?>
    </div>
    <a href="add_reservation.php" class="addbutton">
        <i> + </i>
    </a>
    <div class="popup" style="display: none;"></div>
    <script>
        if (window.location.href.indexOf("add=succes") != -1){
            alert('Toevoegen van reservatie was succesvol. Dit bericht moet binnenkort veranderd worden in een pop-up.');
            //addclass 'zichtbaar' aan <div class='popup'>
        }
    </script>
</div>
</body>
</html>
