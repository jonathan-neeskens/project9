<?php include "includes/head.php" ?>
<body>
<?php include "includes/menu.php" ?>
<div class="canvas bit-90">

    <div class="innerCanvas">
        <a href="reservations.php"> <i class="fa fa-arrow-left fa-3x"></i></a>
        <a href="#"> <i class="fa fa-floppy-o fa-3x"></i> </a>
        <div class="inside_innerCanvas">
            <h2> 1. Voer tijd in. </h2>
            <form method="POST" action="add_reservation_step1.php">
                <input type="date" value="<?php echo date('Y-m-d'); ?>" required name="date" placeholder="Datum"><br>
                <input type="time" value="<?php echo date('H'); ?>:00"required name="time" step="1800" placeholder="Tijd"><br>
                <i class="fa fa-user"></i><input type="number" name="capacity" value="Aantal personen"> <br>
                <input type="submit" name="check_tables" value="Tafels ophalen"> <br>
            </form>
    </div>

</div>
</body>
</html>
