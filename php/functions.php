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