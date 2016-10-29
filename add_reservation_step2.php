<?php
include "includes/head.php";
$_SESSION['table_array'] = $_POST['tables'];

?>
<body>
<?php include "includes/menu.php" ?>
<div class="canvas bit-90">

    <div class="innerCanvas">
        <a href="add_reservation_step1.php"> <i class="fa fa-arrow-left fa-3x"></i></a>
        <a href="#"> <i class="fa fa-floppy-o fa-3x"></i> </a>
        <div class="inside_innerCanvas">
            <h2> 2. Selecteer menu('s) </h2>
            <form method="POST" action="add_reservation_step3.php">
                    <?php
                        pick_menus($_SESSION['capacity'])
                    ?>
                <br>
                <input type="submit" name="pick_menus" value="Kies deze menu's"> <br>
            </form>
        </div>

    </div>
</body>
</html>
