<?php include "includes/head.php" ?>
<body>
<?php include "includes/menu.php" ?>
<div class="canvas bit-90">

    <div class="innerCanvas">
        <a href="add_reservation.php"> <i class="fa fa-arrow-left fa-3x"></i></a>
        <a href="#"> <i class="fa fa-floppy-o fa-3x"></i> </a>
        <div class="inside_innerCanvas">
            <h2> 2. Selecteer een tafel </h2>
            <form method="POST">
                <!--<select>-->
                   <?php
                    $date = $_POST['date'];
                    $time = $_POST['time'];
                   $capacity = $_POST['capacity'];

                    check_tables($date, $time, $capacity);
                    ?>
                <!--</select>-->
                <br>
                <input type="submit" name="pick_tables" value="Kies deze tafel"> <br>
            </form>
        </div>

    </div>
</body>
</html>
