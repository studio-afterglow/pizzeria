<?php
session_start();
require_once "connect.php";

?>
<head>
        <meta charset="utf-8" />
        <title>Panel zamawiania pizzy</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <div class="background container-fluid">
        <div class="row justify-content-center">
        <div class="main-div">
            <div class="row justify-content-center">
        <a class="main-links col-md-4" href="cartforcustomer.php">Koszyk</a>
        <a class="main-links col-md-4" href="index.php">Domów pizzę</a>
        <a class="main-links col-md-4" href="finalize.php">Sfinalizuj zamówienie</a>
            </div>
        <form class="pickpizza" method="post" action="finalization.php">
            Imię i nazwisko: <br/><input type="text" name="name"><br/>
            Miejscowość: <br/><input type="text" name="location"><br />
            Ulica i numer domu/numer domu:<br/> <input type="text" name="house"><br />
            <input type="submit" value="Wyślij zamówienie">
        </form>
            </div></div></div>
    </body>
</html>