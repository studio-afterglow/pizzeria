<?php
session_start();
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$id_pizza=$_GET['pizza'];
$price=$_GET['price'];
$session=session_id();

try
{
    $connect = @new mysqli($host, $db_user, $db_password, $db_name);
    if($connect->connect_errno!=0)
    {
        throw new Exception(mysqli_connect_errno());
    }
    else
    {
        if($connect->query("INSERT INTO cart_pizzas VALUES (NULL, '$session','$id_pizza','$price')"))
        {
            $_SESSION['added_pizza']="Dodano pizzę do koszyka. Możesz dodać kolejną lub przejść dalej";
            header('Location: index.php');
        }
        else
        {
            throw new Exception($connect->error);
        }
    }
}
    catch(Exception $e)
        {
            echo '<span style="color:red">Błąd serwera!</span>';
            echo '<br />Informacja developerska: '.$e;
        } 
?>