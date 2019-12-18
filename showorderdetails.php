<?php
if((isset($_SESSION['logged']) && $_SESSION['logged']==true))
   {
    header('Location: logform.php');
    exit();
}
session_start();
$id=$_GET["id"];
?>
<html land="pl">
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
            <a class="main-links col-md-12" href="admin.php">Wróć do głównego panelu</a></div>
            
<?php

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
try
{
    $connect = @new mysqli($host, $db_user, $db_password, $db_name);
    $connect->set_charset("utf8");
    if($connect->connect_errno!=0)
    {
        throw new Exception(mysqli_connect_errno());
    }
    else
    {
        if($result = $connect->query("SELECT * FROM order_list WHERE id_order='$id'"))
        {
            $row=$result->fetch_assoc();
            echo '<div class="orderinfo">';
            echo 'Imię i nazwisko: '.$row["name"].'<br/>miejscowość: '.$row["location"].'<br/>adres: '.$row["house"].'<br/>zamówione: '.$row["time"];
            $id_order=$row['id_order'];
            echo '<br/><br/><a class="addpizza" href="deleteorder.php?id='.$id_order.'">Usuń zamówienie z bazy</a>';
            echo "</div>";
            
        }
        else
        {
            throw new Exception($connect->error);
        }
        $connect->close();
    }
}
    catch(Exception $e)
        {
            echo '<span style="color:red">Błąd serwera!</span>';
            echo '<br />Informacja developerska: '.$e;
        } 
?>

        <?php
        require_once "showorder.php";
        showOrder($id_order);
        
        ?>
            </div></div></div></body>
</html>