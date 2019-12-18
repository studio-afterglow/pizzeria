<?php session_start(); 
    if((isset($_SESSION['logged']))&&($_SESSION['logged']==true)){
        header('Location: admin.php');
        exit();
    }
        
?>
<!DOCTYPE HTML>
<html land="pl">
    <head>
        <meta charset="utf-8" />
        <title>Panel obsługi zamówień - zaloguj</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <div class="background container-fluid">
        <div class="row justify-content-center">
        <div class="main-div">
        
        <form class="pickpizza" action="login.php" method="post">
            Login: <br /> <input type="text" name="login"><br/>
            Hasło: <br /> <input type="password" name="password"><br/>
            <input type="submit" value="zaloguj">
        </form>
        <?php
            if(isset($_SESSION['log_error']))
               {
                echo $_SESSION['log_error'];
                unset($_SESSION['log_error']);
               }
        ?>
            </div></div></div></body>
</html>