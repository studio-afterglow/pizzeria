<?php

function showCart($id_session)
{
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    $session=$id_session;
    $summary=0;
    
    echo "<table>";
    echo "<tr><th>Nazwa</th><th>Cena</th><th></th>";
    
    try
    {
        $connect = @new mysqli($host, $db_user, $db_password, $db_name);
        if($connect->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            if($result = $connect->query("SELECT * FROM cart_pizzas c INNER JOIN pizza_list l ON c.id_pizza=l.id_pizza WHERE id_session='$session'"))
            {
                while ($row = $result->fetch_assoc())
                {
                   echo "<tr><td>Pizza: ".$row["pizza_name"]."</td><td>".$row["price"]."</td>";
                    echo '<td><a href="removefromcart.php?table=cart_pizzas&id='.$row["id_cart_pizzas"].'">Usuń z koszyka</a></td></tr>';
                    $summary=$summary+$row["price"];
                }
            }
            else
            {
                throw new Exception($connect->error);
            }
            if($result = $connect->query("SELECT * FROM cart_additions c INNER JOIN add_more l ON c.id_add=l.id_add WHERE id_session='$session'"))
            {
                while ($row = $result->fetch_assoc())
                {
                   echo "<tr><td>".$row["name"]."</td><td>".$row["price"]."</td>";
                    echo '<td><a class="addpizza" href="removefromcart.php?table=cart_additions&id='.$row["id_add_cart"].'">Usuń z koszyka</a></td></tr>';
                    $summary=$summary+$row["price"];
                }
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
    } 
    echo '<tr><th class="summary">Do zapłaty</th><th class="summary">'.$summary.'</th><th class="summary"></th></tr>';
}

?>