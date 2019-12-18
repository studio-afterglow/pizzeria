<?php
session_start();
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$table=$_GET['table'];
$id=$_GET['id'];
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
        if($table="cart_pizzas")
        {
            if($connect->query("DELETE FROM cart_pizzas WHERE id_cart_pizzas='$id'"))
            {
                header('Location: cartforcustomer.php');
            }
            else
            {
                throw new Exception($connect->error);
            }
        }
        else
        {
           if($connect->query("DELETE FROM cart_additions WHERE id_add_cart='$id'"))
            {
                header('Location: cartforcustomer.php');
            }
            else
            {
                throw new Exception($connect->error);
            } 
        }
    }
}
    catch(Exception $e)
        {
            echo '<span style="color:red">Błąd serwera!</span>';
            echo '<br />Informacja developerska: '.$e;
        } 
?>