<?php include "includes/head.php" ?>
<body>
<?php include "includes/menu.php" ?>
<div class="canvas bit-90">

    <div class="innerCanvas">
        <a href="table_settings.php"> <i class="fa fa-arrow-left fa-3x"></i></a>
        <a href="#"> <i class="fa fa-floppy-o fa-3x"></i> </a>
        <div class="inside_innerCanvas">
            <h2> Nieuwe tafel toevoegen </h2>
            <?php
            if(isset($_POST["save"])){
                create_table($_POST['nr']);
            }
            ?>
            <form method="POST">
                <input type="number" required name="nr" placeholder="Tafelnummer"><br>
                <input type="submit" name="save" value="Opslaan (Tijdelijke knop)">
            </form>
        </div>
    </div>

</div>
</body>
</html>
