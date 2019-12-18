<?php
session_start();
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$id=$_GET['id'];

try
{
    $connect = @new mysqli($host, $db_user, $db_password, $db_name);
    if($connect->connect_errno!=0)
    {
        throw new Exception(mysqli_connect_errno());
    }
    else
    {
        if($connect->query("DELETE FROM order_list WHERE id_order='$id'"))
        {}
        else
        {
            throw new Exception($connect->error);
        }
        if($connect->query("DELETE FROM ordered_additions WHERE id_order='$id'"))
        {}
        else
        {
            throw new Exception($connect->error);
        }
        if($connect->query("DELETE FROM ordered_pizzas WHERE id_order='$id'"))
        {
            header('Location: admin.php');
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