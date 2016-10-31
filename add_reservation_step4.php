<?php
include "includes/head.php";

    if (!$_POST['name'] AND !$_POST['address'] AND !$_POST['city'] AND !$_POST['mail'] AND !$_POST['phone']) {
        $_SESSION['customer_id'] = $_POST['customer_id'];
    }

    elseif($_POST['name'] AND $_POST['address'] AND $_POST['city'] AND $_POST['mail'] AND $_POST['phone']){

        $name = $_POST['name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $mail = $_POST['mail'];
        $phone = $_POST['phone'];

        global $link;

        $color[0] = '#00BCD4';
        $color[1] = '#8BC34A';
        $color[2] = '#FF9800';
        $color[3] = '#9C27B0';

        $randcolor = $color[rand()%count($color)];

        $query = mysqli_query($link, "INSERT INTO `customer` VALUES (NULL, '$name', '$address', '$city', '$mail', '$phone', '$randcolor')");

        $u_id = mysqli_insert_id($link);

        $_SESSION['customer_id'] = $u_id;
    }


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
