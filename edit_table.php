<?php include "includes/head.php" ?>
<body>
<?php include "includes/menu.php" ?>
<div class="canvas bit-90">

    <div class="innerCanvas">
        <a href="table_settings.php"> <i class="fa fa-arrow-left fa-3x"></i></a>
        <a href="#"> <i class="fa fa-floppy-o fa-3x"></i> </a>
        <div class="inside_innerCanvas">
            <h2> Tafel wijzigen </h2>
            <?php
            if(isset($_POST["change"])){
                change_table("change", $_GET['id'], $_POST['table_nr']);
            }

            if(isset($_POST["delete"])){
                change_table("delete", $_GET['id'], "");
            }

            $query1 = mysqli_query($link, "SELECT * FROM `tables` WHERE id = $_GET[id]");
            $row1 = mysqli_fetch_assoc($query1)


            ?>
            <form method="POST">
                <h3>Tafelnummer:</h3>
                <input type="text" required name="price" value="<?php echo $row1['table_nr'] ?>"><br>

                <br>
                <input type="submit" name="change" value="Wijzigingen opslaan"> <br>
                <input type="submit" style="background: red!important;" name="delete" value="Tafel verwijderen">
            </form>
        </div>
    </div>

</div>
</body>
</html>

