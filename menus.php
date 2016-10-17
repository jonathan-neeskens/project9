<?php include "includes/head.php" ?>
<body>
<?php include "includes/menu.php" ?>
<div class="canvas bit-90">
    <input class="searchField" placeholder="Zoek naar menu's..." type="text">
    <i class="fa fa-search fa-2x"></i>

    <?php search("menus"); ?>
    <div class="innerCanvas">
        <?php menu_list() ?>
    </div>
    <a href="add_menu.php" class="addbutton">
        <i> + </i>
    </a>
    <div class="popup" style="display: none;"></div>
    <script>
        if (window.location.href.indexOf("add=succes") != -1){
            alert('Toevoegen van menu was succesvol. Dit bericht moet binnenkort veranderd worden in een pop-up.');
            //addclass 'zichtbaar' aan <div class='popup'>
        }
    </script>
</div>
</body>
</html>
