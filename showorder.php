<?php

function showOrder($id_order)
{
    require "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    $order=$id_order;
    $summary=0;
    
    echo "<table>";
    echo "<tr><th>Nazwa</th><th>Cena</th>";
    
    try
    {
        $connect = new mysqli($host, $db_user, $db_password, $db_name);
        if($connect->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            if($result = $connect->query("SELECT * FROM ordered_pizzas o INNER JOIN pizza_list l ON o.id_pizza=l.id_pizza WHERE id_order='$order'"))
            {
                while ($row = $result->fetch_assoc())
                {
                   echo "<tr><td>Pizza: ".$row["pizza_name"]."</td><td>".$row["price"]."</td>";
                    $summary=$summary+$row["price"];
                }
            }
            else
            {
                throw new Exception($connect->error);
            }
            if($result = $connect->query("SELECT * FROM ordered_additions o INNER JOIN add_more l ON o.id_add=l.id_add WHERE id_order='$order'"))
            {
                while ($row = $result->fetch_assoc())
                {
                   echo "<tr><td>".$row["name"]."</td><td>".$row["price"]."</td>";
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
        echo '<br />Informacja developerska: '.$e;
    } 
    echo '<tr><th class="summary">Do zapłaty</th><th class="summary">'.$summary.'</th></tr>';
}

?>