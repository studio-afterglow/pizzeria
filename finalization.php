<?php
session_start();
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$name=$_POST['name'];
$location=$_POST['location'];
$house=$_POST['house'];
$session=session_id();
$summary=0;

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
        if($connect->query("INSERT INTO order_list VALUES (NULL, '$session','$summary','$name','$location','$house',CURRENT_TIMESTAMP, CURTIME() )"))
        {
        }
        else
        {
            throw new Exception($connect->error);
        }
        if($result = $connect->query("SELECT * FROM order_list WHERE session='$session'"))
        {
            $row=$result->fetch_assoc();
            $current_order_id=$row['id_order'];
        }
        else
        {
            throw new Exception($connect->error);
        }
        if($result = $connect->query("SELECT * FROM cart_pizzas WHERE id_session='$session'"))
            {
                while ($row = $result->fetch_assoc())
                {
                    $id_pizza=$row["id_pizza"];
                    $price=$row["price"];
                    if($connect->query("INSERT INTO ordered_pizzas VALUES (NULL, '$current_order_id','$id_pizza','$price')"))
                    {
                        $summary=$summary+$row["price"];
                        $connect->query("DELETE FROM cart_pizzas WHERE id_session='$session'");
                    }
                    else
                    {
                        throw new Exception($connect->error);  
                    }
                }
        }
            else
            {
                throw new Exception($connect->error);
    }
        if($result = $connect->query("SELECT * FROM cart_additions WHERE id_session='$session'"))
            {
                while ($row = $result->fetch_assoc())
                {
                    $id_add=$row["id_add"];
                    $price=$row["price"];
                    if($connect->query("INSERT INTO ordered_additions VALUES (NULL, '$id_add','$current_order_id','$price')"))
                    {
                        $summary=$summary+$row["price"];
                       $connect->query("DELETE FROM cart_additions WHERE id_session='$session'"); 
                    }
                    else
                    {
                        throw new Exception($connect->error);
                    }
                }
        }
        
        if($connect->query("UPDATE order_list SET price='$summary' WHERE id_order='$current_order_id'"))
            {
            header('Location: orderfinalized.php');
        }
        else
        {
            throw new Exception($connect->error);
        }
        
    }}
    catch(Exception $e)
        {
            echo '<span style="color:red">Błąd serwera!</span>';
            echo '<br />Informacja developerska: '.$e;
        } 
session_regenerate_id();
?>