<?php
session_start();
//db-gegevens
$host = 'localhost';
$username = 'root';
$password = '';
$dataBase = 'project_9';
//$port = '3306';
$link = mysqli_connect($host,$username,$password,$dataBase/*,$port*/);

function search($page){
   // echo $page;
}

function create_user($name, $address, $city, $mail, $phone){
    global $link;

    $color[0] = '#00BCD4';
    $color[1] = '#8BC34A';
    $color[2] = '#FF9800';
    $color[3] = '#9C27B0';

    $randcolor = $color[rand()%count($color)];

    $query = mysqli_query($link, "INSERT INTO `customer` VALUES (NULL, '$name', '$address', '$city', '$mail', '$phone', '$randcolor')");
    header("Location: customers.php?add=success");

}

function check_tables($date, $time){
    global $link;
    $datetime = $date. " " .$time;

    //$tables = '?';
    //$begintijd  = '12.00';
    //$reservation_date = '20-10-2016 12:00:00';
    //$reservation_date_end = '20-10-2016 14:00:00'; 	//$reservation_date + 2u

    //$reservations_active = mysqli_query($link, "SELECT * FROM `reservation` WHERE (datetime > '".$datetime."') OR ('$datetime' < date_add(datetime, INTERVAL 2 hour ))");
    echo "SELECT * FROM `reservation` WHERE (datetime > '".$datetime."') OR ('$datetime' < date_add(datetime, INTERVAL 2 hour ))";

    $active_tables = mysqli_query($link, "SELECT * FROM `tables` WHERE active = 1"); //in dit geval alle tafels
    echo "SELECT * FROM `tables` WHERE active = 1";

    //$reservation_tables = mysqli_query($link, "SELECT table_id FROM `order_table` WHERE id = $reservations_active->id"); //tafel 3 is gekoppeld aan de reservering
    echo "SELECT table_id FROM `order_table` WHERE id = $reservations_active->id";

    //$free_tables = mysqli_query($link, "SELECT * FROM `tables` WHERE id != $reservation_tables->id"); //tafel 1/2/4 komen uit hier
    echo "SELECT * FROM `tables` WHERE id != $reservation_tables->id";
}


function change_user($id, $name, $adress, $city, $mail, $phone){
    global $link;
    $query = mysqli_query($link, "UPDATE `customer` SET `name` = '$name', `adress` = '$adress', `city` = '$city', `mail` = '$mail', `phone` = '$phone' WHERE `id` = '$id'");
    header("Location: customers.php?change=success");
}

function get_receipt($table_id){
    echo $table_id;

    //$query1. Select*from order_table where table_id = $table_id
    //$query2. select*from orders where reservation_id = $$query1['reservation_id']
    // while (query2){
    //  select price from menu where id = $query2['menu_id'];
    //  Toevoegen aan array $totaal of zo iets?
    //}
    // echo "totaal: €" .$totaal;

}

function create_menu($name, $price){
    global $link;
    $query = mysqli_query($link, "INSERT INTO `menu` VALUES (NULL, '$name', '$price', '1')");
    header("Location: menus.php?add=succes");
}

function table_list(){
    global $link;
    $query1 = mysqli_query($link, "SELECT * FROM tables");

    while($row1 = mysqli_fetch_assoc($query1)) {
        echo "
        <div class='table_wrapper'>
            <div class='table'>
                <div class='table-top'>
                    <h1> Tafel " . $row1['table_nr'] . " </h1>
                    <a class='printbutton' href='index.php?receipt_id=".$row1['id']."'>
                        <i class='fa fa-print'></i>
                    </a>
                </div>
                <div class='table-bottom'>
                    <p><strong>3</strong><light>/4 personen</light></p>
                </div>
            </div>
        </div>
        ";
    }
}

function table_list_2(){
    global $link;

    $query1 = mysqli_query($link, "SELECT * FROM tables");

    while($row1 = mysqli_fetch_assoc($query1)){

        echo "
        <div class='list_item'>
            <div class='user_pic'>
                <img src='img/table.png'>
            </div>
            <div class='list-section'>
                <h3> Tafel " .$row1['table_nr']. " </h3>
            </div>
            <a href='edit_table.php?id=".$row1['id']."'>
                <i class='fa fa-pencil'></i>
            </a>
        </div>
        ";
    }
}

function customer_list(){
    global $link;

    $query1 = mysqli_query($link, "SELECT * FROM customer");

    while($row1 = mysqli_fetch_assoc($query1)){

        echo "
        <div class='list_item'>
            <div class='user_pic'>
                <img style='background: ".$row1['app_color']."' src='img/customer.png'>
            </div>
            <div class='list-section'>
            <h3> " .$row1['name']. " </h3>
            </div>
            <a href='edit_customer.php?id=".$row1['id']."'>
                <i class='fa fa-pencil'></i>
            </a>
        </div>
        ";
    }
}

function change_menu($id, $name, $price){
    global $link;
    $query = mysqli_query($link, "UPDATE `menu` SET `name` = '$name', `price` = '$price' WHERE `id` = '$id'");
    header("Location: menus.php?change=success");
}

function menu_list(){
    global $link;
    $query1 = mysqli_query($link, "SELECT * FROM menu");

    while($row1 = mysqli_fetch_assoc($query1)){

        echo "
        <div class='list_item'>
            <div class='user_pic'>
                <img src='img/menu.png'>
            </div>
            <div class='list-section'>
            <h3> " .$row1['name']. " </h3>
            </div>
            <a href='edit_menu.php?id=".$row1['id']."'>
                <i class='fa fa-pencil'></i>
            </a>
        </div>
        ";
    }
}

function reservation_list(){
    global $link;
    $query1 = mysqli_query($link, "SELECT * FROM reservation");

    while($row1 = mysqli_fetch_assoc($query1)) {
        $d = new DateTime($row1['datetime']);
        $e = new DateTime($row1['datetime']);
        $e->add(new DateInterval('PT2H'));

        $nameQuery = mysqli_query($link, "SELECT `name` from `customer` WHERE `id` = ".$row1['customer_id']."");
        $name = mysqli_fetch_assoc($nameQuery);

        echo "
        <div class='list_item'>
            <div class='list-section'>
                <h3> " .$d->format('H:i'). " - ".$e->format('H:i')."</h3>
            </div>
            <div class='list-section'>
                ".$name['name']."
            </div>
            <div class='list-section'>
                ".$row1['capacity']." &nbsp; <i class='fa fa-user' style='color: #000;'></i>
            </div>
            <div class='list-section'>
                ";

        $query2 = mysqli_query($link, "SELECT * FROM order_table WHERE reservation_id = ".$row1['id']."");

        while($row2 = mysqli_fetch_assoc($query2)) {
            $tableQuery = mysqli_query($link, "SELECT `table_nr` from `tables` WHERE `id` = ".$row2['table_id']."");
            $table = mysqli_fetch_assoc($tableQuery);

            echo "<span> ".$table['table_nr']." </span>";
        }

        echo "
            </div>
            <div class='section'>
            <a href='edit_menu.php?id=".$row1['id']."'>
                <i class='fa fa-pencil'></i>
            </a>
            </div>
        </div>
        ";
    }
}


function delete_user($id){
    global $link;
    $query = mysqli_query($link, "DELETE FROM `customer` WHERE `id` = ".$id."");
    header("Location: customers.php?delete=success");
}

function create_table($nr){
    global $link;
    $query = mysqli_query($link, "INSERT INTO `tables` VALUES (NULL, '$nr', '1')");
    header("Location: table_settings.php?add=success");
}