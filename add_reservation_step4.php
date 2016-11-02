<?php
include "includes/head.php";

    if (!$_POST['name'] AND !$_POST['address'] AND !$_POST['city'] AND !$_POST['mail'] AND !$_POST['phone'] AND !$_SESSION['customer_id']) {
        $_SESSION['customer_id'] = $_POST['customer_id'];
    }

    elseif($_POST['name'] AND $_POST['address'] AND $_POST['city'] AND $_POST['mail'] AND $_POST['phone'] AND !$_SESSION['customer_id']){

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


    //Definitie variabelen voor overzicht:
    //naam
    $name_query = mysqli_query($link, "SELECT * FROM `customer` WHERE `id` = '$_SESSION[customer_id]'");
    $name_assoc = mysqli_fetch_assoc($name_query);
    $name = $name_assoc['name'];

    //tafel(s)
    $table_name_array = array();

    for ($i= 0; $i < count($_SESSION['table_array']); $i++){
        $table_id = $_SESSION['table_array'][$i];
        $table_name_query = mysqli_query($link, "SELECT * FROM `tables` WHERE `id` = '$table_id'");

        $table_name_assoc = mysqli_fetch_assoc($table_name_query);

        array_push($table_name_array, ", Tafel ".$table_name_assoc['table_nr']."");
    }

    $table = implode("", $table_name_array);
    $tables = substr($table, 1);

    //Datum / tijd
    $datetime = new DateTime($_SESSION['date']. " " .$_SESSION['time']);
    $date= date_format($datetime, 'd F Y');
    $time= date_format($datetime, 'H:i');

    //Menu's
    $menu_name_array = array();
    for ($i= 0; $i < count($_SESSION['menu_array']); $i++){
        $menu_id = $_SESSION['menu_array'][$i];
        $menu_name_query = mysqli_query($link, "SELECT * FROM `menu` WHERE `id` = '$menu_id'");

        $menu_name_assoc = mysqli_fetch_assoc($menu_name_query);
        array_push($menu_name_array, "<li> ".$menu_name_assoc['name']." </li>");
    }

    $menus = implode("", $menu_name_array);

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
                Op naam van: <?php echo $name; ?> <br><br>
                Aantal personen: <?php echo $_SESSION['capacity']; ?> <br><br>
                Tafel(s): <?php echo $tables; ?> <br><br>
                Datum: <?php echo $date; ?> <br><br>
                Tijd: <?php echo $time; ?> <br><br>
                Gekozen menu's: <?php echo $menus; ?> <br><br>

                <input type="submit" name="save_reservation" value="Reservering opslaan"> <br>
            </form>
        </div>

    </div>
</body>
</html>
