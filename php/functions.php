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

function create_reservation($date, $time, $menu_array, $table_array, $capacity, $u_id){
    global $link;

    $reservation_start = $date. " " .$time;
    $reservation_end_obj = new DateTime($date. " " .$time);
    $reservation_end_obj->add(new DateInterval('PT2H'));

    $reservation_end = date_format($reservation_end_obj, 'Y-m-d H:i:s');

    //1. Maak een nieuwe row aan in reservations met daarin customer_id, capacity, reservation_start + end.
    $query = mysqli_query($link, "INSERT INTO `reservation` VALUES (NULL, '$u_id', '$capacity', '$reservation_start', '$reservation_end')");

    //2. Maak voor iedere tafel een nieuwe row in order_table met daarin het table_id + reserverings-id;
    $reservation_id = mysqli_insert_id($link);
    for ($i= 0; $i < count($table_array); $i++) {
        $query = mysqli_query($link, "INSERT INTO `order_table` VALUES (NULL, '$reservation_id', '$table_array[$i]', '1')");
    }

    //2. Maak voor ieder menu een nieuwe row aan in orders met daarin het menu_id + reserverings_id;
    var_dump($menu_array);
//    for ($i= 0; $i < count($menu_array); $i++) {
//        //$query = mysqli_query($link, "INSERT INTO `orders` VALUES (NULL, '$reservation_id', '$menu_array[$i]')");
//        echo "INSERT INTO `orders` VALUES (NULL, '$reservation_id', '$menu_array[$i]')";
//    }

    //4. Header terug naar reserverings-overzicht?succes
    //header("Location: reservations.php?add=success");
}


function check_tables($date, $time, $capacity){
    global $link;
    $reservation_start = $date. " " .$time;
    $reservation_end_obj = new DateTime($date. " " .$time);
    $reservation_end_obj->add(new DateInterval('PT2H'));

    //Formatteer het datetime object naar een string
    $reservation_end = date_format($reservation_end_obj, 'Y-m-d H:i:s');

    //Stap 1: Selecteer alle reserveringen die plaatsvinden op de ingevoerde tijd.
    $reservations_active_query = mysqli_query($link, "SELECT * FROM `reservation` WHERE `reservation_start` >= '$reservation_start' AND `reservation_start` <= '$reservation_end' OR `reservation_end` >= '$reservation_start' AND `reservation_end` <= '$reservation_end'");
    $reservations_active = mysqli_fetch_assoc($reservations_active_query);


    //echo "SELECT * FROM `reservation` WHERE `reservation_start` >= '$reservation_start' AND `reservation_start` <= '$reservation_end' OR `reservation_end` >= '$reservation_start' AND `reservation_end` <= '$reservation_end'<br><br>";

    //Stap 2a: Als er GEEN reserveringen plaatsvinden, zijn alle tafels dus beschikbaar.
    if (!$reservations_active){
        $free_tables_query = mysqli_query($link, "SELECT * FROM `tables` WHERE `availability` = '1'");
        $n_o_tables = ceil($capacity / 4);
        for ($i= 0; $i < $n_o_tables; $i++) {
            echo "<select name='tables'>";
            while ($free_tables = mysqli_fetch_assoc($free_tables_query)) {
                echo "<option value='".$free_tables['id']."'> Tafel ".$free_tables['id']." </option>";
            }
            echo "</select> <br>";
        }
    }

    //Stap 2b: Als er WEL reserveringen plaatsvinden, selecteer uit order_table de table_ids waar reservation_id =  $reservations_active['id']. Je hebt nu alle table_ids van tafels die bezet zijn.
    else {
        $array = array();
        $number = count($reservations_active)/5;

        for ($i= 0; $i < $number; $i++){
            array_push($array, "AND reservation_id = '$reservations_active[id]'");
        }
        $array_string = implode(" ", $array);

        //Check de hoeveelheid tafels.
        $n_o_tables = ceil($capacity / 4);

        //Check tabel order_tables.
        $order_tables_query = mysqli_query($link, "SELECT * FROM `order_table` WHERE `availability` = '1' ".$array_string."");

        $free_tables_array = Array();
        $free_tables_assoc = mysqli_fetch_assoc($order_tables_query);

        //Pleur table_ids in een array
        $number2 = count($free_tables_assoc)/4;
        for ($i= 0; $i < $number2; $i++){
            array_push($free_tables_array, "AND id != '$free_tables_assoc[table_id]'");
        }

        $array_string2 = implode(" ", $free_tables_array);


        for ($i= 0; $i < $n_o_tables; $i++) {
            //Selecteer * from tables WHERE availability = '1'
            $free_tables_query = mysqli_query($link, "SELECT * FROM `tables` WHERE `availability` = '1' $array_string2");
            echo "<select name='tables[]'>";
            while ($free_tables2 = mysqli_fetch_assoc($free_tables_query)) {
                echo "<option value='".$free_tables2['id']."'> Tafel ".$free_tables2['table_nr']." </option>";
            }
            echo "</select> <br>";
        }


    }
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

function pick_menus($capacity){
    global $link;

    $a = 1;

    for ($i= 0; $i < $capacity; $i++){
        echo
            "<h3> Keuze persoon ".$a. ":</h3>
            <select name='menu[]'>
        ";


        $query1 = mysqli_query($link, "SELECT * FROM menu");
        while($row1 = mysqli_fetch_assoc($query1)) {
            echo "<option value='".$row1['id']."'> ".$row1['name']." </option>";
        }
        echo "
            </select>
        ";
        $a++;
    }
}

function create_menu($name, $price){
    global $link;
    $query = mysqli_query($link, "INSERT INTO `menu` VALUES (NULL, '$name', '$price', '1')");
    header("Location: menus.php?add=success");
}

function select_customer(){
    global $link;
    $query1 = mysqli_query($link, "SELECT * FROM customer");

    while($row1 = mysqli_fetch_assoc($query1)) {
        echo "
        <option value='".$row1['id']."'> ".$row1['name'].", ".$row1['mail']." </option>
        ";
    }
}

function table_list(){
    global $link;
    $query1 = mysqli_query($link, "SELECT * FROM tables WHERE `availability` = '1'");

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

function change_menu($id, $name, $price, $availability){
    global $link;

    if ($availability == 'no'){
        $query = mysqli_query($link, "UPDATE `menu` SET `name` = '$name', `price` = '$price' WHERE `id` = '$id'");

        header("Location: menus.php?change=success");
    }

    else{
        $query = mysqli_query($link, "UPDATE `menu` SET `name` = '$name', `price` = '$price', `availability` = '$availability' WHERE `id` = '$id'");
        header("Location: menus.php?change=success");
    }



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
    //TO DO: ALLEEN RESERVERINGEN DIE VANDAAG PLAATSVINDEN, LATEN ZIEN

    while($row1 = mysqli_fetch_assoc($query1)) {
        $d = new DateTime($row1['reservation_start']);
        $e = new DateTime($row1['reservation_end']);

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
            <a href='edit_reservation.php?id=".$row1['id']."'>
                <i class='fa fa-pencil'></i>
            </a>
            </div>
        </div>
        ";
    }
}

function export_customers()
{
    global $link;

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