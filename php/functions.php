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
    for ($i= 0; $i < count($menu_array); $i++) {
        $query = mysqli_query($link, "INSERT INTO `orders` VALUES (NULL, '$reservation_id', '$menu_array[$i]')");
    }

    //4. Header terug naar reserverings-overzicht?succes
    header("Location: reservations.php?add=success");
}


function check_tables($date, $time, $capacity){
    global $link;

    $reservation_start = $date. " " .$time;
    $reservation_end_obj = new DateTime($date. " " .$time);
    $reservation_end_obj->add(new DateInterval('PT2H'));

    //Formatteer het datetime object naar een string
    $reservation_end = date_format($reservation_end_obj, 'Y-m-d H:i:s');

    //Stap 1: Selecteer alle reserveringen die plaatsvinden op de ingevoerde tijd.
    $reservations_active_array = array();

    $reservations_active_query = mysqli_query($link, "SELECT `id` FROM `reservation` WHERE `reservation_start` >= '$reservation_start' AND `reservation_start` <= '$reservation_end' OR `reservation_end` >= '$reservation_start' AND `reservation_end` <= '$reservation_end'");

    while($reservation_row = mysqli_fetch_assoc($reservations_active_query)){
        array_push($reservations_active_array, "OR `reservation_id` = '$reservation_row[id]'");
    }

    //Check of alle tafels bezet zijn.
    if (count($reservations_active_array) == 0){
        for ($i= 0; $i < ceil($capacity / 4); $i++) {
            $tables_available = mysqli_query($link, "SELECT * FROM `tables` WHERE `availability` = '1'");
            echo "<select name='tables'>";
            while ($table_row2 = mysqli_fetch_assoc($tables_available)) {
                echo "<option value='".$table_row2['id']."'> Tafel ".$table_row2['table_nr']."</option>";
                            }
            echo "</select> <br>";
        }
    }

    else{
        //converteer array met reservering-ids naar string.
        $reservations_active_1 = implode(" ", $reservations_active_array);
        $reservations_active = substr($reservations_active_1, 3);

        //Stap 2: Selecteer alles uit order_table WHERE reservation_id == stap1['reservation_id']

        $table_active_array = array();
        $table_active_query = mysqli_query($link, "SELECT * FROM `order_table` WHERE `availability` = '1' AND $reservations_active");

        while($table_row = mysqli_fetch_assoc($table_active_query)){
            array_push($table_active_array, "AND `id` != '$table_row[table_id]'");
        }

        $tables_active = implode(" ", $table_active_array);

        for ($i= 0; $i < ceil($capacity / 4); $i++) {
            $tables_available = mysqli_query($link, "SELECT * FROM `tables` WHERE `availability` = '1' $tables_active");
            echo "<select name='tables[]'>";
            while ($table_row2 = mysqli_fetch_assoc($tables_available)) {
                echo "<option value='".$table_row2['id']."'> Tafel ".$table_row2['table_nr']."</option>";
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
    $query1 = mysqli_query($link, "SELECT * FROM reservation ORDER BY `reservation_start` ASC");
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

    echo "SELECT * FROM `customers` INTO OUTFILE 'C:/tmp/klantsysteem.csv' FIELDS ENCLOSED BY '\"' TERMINATED BY ';' ESCAPED BY '\"' LINES TERMINATED BY '\r\n';";
}
s

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