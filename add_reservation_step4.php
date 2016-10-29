<?php
include "includes/head.php";

    if(isset($_POST["save_reservation"])){
        create_reservation($_SESSION['date'], $_SESSION['time'], $_SESSION['menu_array'], $_SESSION['table_array'], $_SESSION['capacity'], $_SESSION['customer_id']);
    }
?>
<body>
<?php include "includes/menu.php" ?>
<div class="canvas bit-90">

    <div class="innerCanvas">
        <a href="add_reservation_step1.php"> <i class="fa fa-arrow-left fa-3x"></i></a>
        <a href="#"> <i class="fa fa-floppy-o fa-3x"></i> </a>
        <div class="inside_innerCanvas">
            <h2> 4. Controleer gegevens </h2>
            <form method="POST">
                <?php var_dump($_SESSION['menu_array']); ?>
                <input type="submit" name="save_reservation" value="Reservering opslaan"> <br>
            </form>
        </div>

    </div>
</body>
</html>
