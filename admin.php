<?php session_start(); 
    if((!isset($_SESSION['logged'])) || ($_SESSION['logged']==false)){
        header('Location: logform.php');
        exit();
    }
        
?>
<!DOCTYPE HTML>
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
        <?php
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        $summary=0;
        ?>
        <form method="post">
            Sortuj po:
            <select name="sortedby">
                <option>data zamówienia</option>
                <option>miejscowości</option>
            </select>
            <input type="submit" value="Sortuj">
        </form>
        <table>
        <tr><td>Adres</td><td>Wartość zamówienia</td><td>Data zamówienia</td><td></td></tr>
        
        <?php
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
                if(isset($_POST['sortedby']) && $_POST['sortedby']=="miejscowości"){
                   if($result = $connect->query("SELECT * FROM order_list ORDER BY location"))
                    {
                        while ($row = $result->fetch_assoc())
                        {
                            echo "<tr><td>".$row["location"]."</td><td>".$row["price"]."</td><td>".$row["time"]."</td>";
                            echo '<td><a href="showorderdetails.php?id='.$row["id_order"].'">Pokaż szczegóły zamówienia</a></td></tr>';
                        }
                    }
                    else
                    {
                        throw new Exception($connect->error);
                    }
                }
                else
                {
                if($result = $connect->query("SELECT * FROM order_list"))
                {
                    while ($row = $result->fetch_assoc())
                    {
                        echo "<tr><td>".$row["location"]."</td><td>".$row["price"]."</td><td>".$row["time"]."</td>";
                        echo '<td><a href="showorderdetails.php?id='.$row["id_order"].'">Pokaż szczegóły zamówienia</a></td></tr>';
                    }
                }
                else
                {
                    throw new Exception($connect->error);
                } 
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
            </table></div></div></div></body>
</html>