<?php include "includes/head.php" ?>
<body>
<?php include "includes/menu.php" ?>
<div class="canvas bit-90">
    <input class="searchField" placeholder="Zoek naar reserveringen..." type="text">
    <i class="fa fa-search fa-2x"></i>

    <?php search("reservations"); ?>
    <div class="innerCanvas"></div>
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
