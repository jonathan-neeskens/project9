<?php
    include "includes/head.php";
    $_SESSION['menu_array'] = $_POST['menu'];

    if(isset($_POST["save_reservation"])){
        if (!$_POST['name'] AND !$_POST['address'] AND !$_POST['city'] AND !$_POST['mail'] AND !$_POST['phone']) {
            $_SESSION['customer_id'] = $_POST['customer_id'];
            header('Location: add_reservation_step4.php');
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
            header('Location: add_reservation_step4.php');
        }
    }
?>
<body>
<?php include "includes/menu.php" ?>
<div class="canvas bit-90">

    <div class="innerCanvas">
        <a href="add_reservation_step1.php"> <i class="fa fa-arrow-left fa-3x"></i></a>
        <a href="#"> <i class="fa fa-floppy-o fa-3x"></i> </a>
        <div class="inside_innerCanvas">
            <h2> 3. Selecteer een klant of voeg deze toe. </h2>
            <form method="POST">
                <select required name="customer_id">
                    <option selected disabled> Kies een klant... </option>
                    <?php
                        select_customer();
                    ?>
                </select> of

                <button class="add_customer"> + </button>

                <br>
                <div class="create_user">
                    <input type="text" name="name" placeholder="Volledige naam"><br>
                    <input type="text" name="address" placeholder="Adres"><br>
                    <input type="text" name="city" placeholder="Woonplaats"><br>
                    <input type="email" name="mail" placeholder="E-mail adres"><br>
                    <input type="tel" name="phone" placeholder="Telefoonnummer"><br>
                </div>
                <input type="submit" name="save_reservation" value="Kies deze klant"> <br>
            </form>
        </div>

    </div>
    <script>


        $('.add_customer').click(function() {
            event.preventDefault();

            var clicks = $(this).data('clicks');
            if (clicks) {
                $(".create_user").addClass("visible");
                $("select").prop("disabled",true);
                $("select").prop("required",false);
                $("input").prop("required",true);
            } else {
                $(".create_user").removeClass("visible");
                $("select").prop("disabled",false);
                $("select").prop("required",true);
                $("input").prop("required",false);
            }
            $(this).data("clicks", !clicks);
        });
    </script>
</body>
</html>