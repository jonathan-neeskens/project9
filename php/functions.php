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

function create_user($role, $name, $adress, $city, $mail, $phone){
    global $link;
    if ($role == 'create_user') {
        $query = mysqli_query($link, "INSERT INTO `customer` VALUES (NULL, '$name', '$adress', '$city', '$mail', '$phone')");
        header("Location: customers.php?add=succes");
    }

    elseif ($role == 'create_user_reservation') {
        $query = mysqli_query($link, "INSERT INTO `customer` VALUES (NULL, '$name', '$adress', '$city', '$mail', '$phone')");
        header("Location: add_reservation.php?added=success");
       }
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
            <h3> Tafel " .$row1['table_nr']. " </h3>
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
                <img src='img/customer.png'>
            </div>
            <h3> " .$row1['name']. " </h3>
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
            <h3> " .$row1['name']. " </h3>
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
        //$time->modify('+2 hours');
        echo $time ."<br>";
        /*
        echo "
        <div class='list_item'>
            <div class='s1'>
              <h3> " .$row1['app_time']. " </h3>  
            </div>
            <div>

            </div>
            <a href='edit_menu.php?id=".$row1['id']."'>
                <i class='fa fa-pencil'></i>
            </a>
        </div>
        "; */
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