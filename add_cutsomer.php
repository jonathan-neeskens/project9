<?php include "includes/head.php" ?>
<body>
<?php include "includes/menu.php" ?>
<div class="canvas bit-90">

    <div class="innerCanvas">
        <a href="customers.php"> <i class="fa fa-arrow-left fa-3x"></i></a>        <a href="#"> <i class="fa fa-floppy-o fa-3x"></i> </a>
        <div class="inside_innerCanvas">
        <h2> Nieuwe gebruiker aanmaken </h2>
            <?php
            if(isset($_POST["save"])){
                create_user($_POST['name'], $_POST['adress'], $_POST['city'], $_POST['mail'], $_POST['phone']);
            }
            ?>
        <form method="POST">
            <input type="text" required name="name" placeholder="Volledige naam"><br>
            <input type="text" required name="adress" placeholder="Adres"><br>
            <input type="text" required name="city" placeholder="Woonplaats"><br>
            <input type="email" required name="mail" placeholder="E-mail adres"><br>
            <input type="tel" required name="phone" placeholder="Telefoonnummer"><br>
            <input type="submit" name="save" value="Opslaan (Tijdelijke knop)">
        </form>
        </div>
    </div>

</div>
</body>
</html>
