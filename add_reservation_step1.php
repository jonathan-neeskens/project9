<?php
include "includes/head.php" ?>
<body>
<?php include "includes/menu.php" ?>
<div class="canvas bit-90">

    <div class="innerCanvas">
        <a href="add_reservation.php"> <i class="fa fa-arrow-left fa-3x"></i></a>
        <a href="#"> <i class="fa fa-floppy-o fa-3x"></i> </a>
        <div class="inside_innerCanvas">
            <h2> 2. Selecteer tafel('s) </h2>
            <form method="POST" action="add_reservation_step2.php">
                   <?php
                        $_SESSION['date'] = $_POST['date'];
                        $_SESSION['time'] = $_POST['time'];
                        $_SESSION['capacity'] = $_POST['capacity'];

                        check_tables($_SESSION['date'], $_SESSION['time'], $_SESSION['capacity']);
                   ?>
                <br>
                <input type="submit" name="pick_tables" value="Kies deze tafel"> <br>
            </form>
        </div>

    </div>
</body>
</html>
