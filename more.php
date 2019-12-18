<?php
session_start();
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
            <?php

if(isset($_SESSION['added_addition']))
{
    echo '<p class="info">'.$_SESSION['added_addition'];
    unset($_SESSION['added_addition']);
}
            ?>
            <div class="row justify-content-center">
        <a class="main-links col-md-4" href="cartforcustomer.php">Koszyk</a>
        <a class="main-links col-md-4" href="index.php">Domów pizzę</a>
        <a class="main-links col-md-4" href="finalize.php">Sfinalizuj zamówienie</a>
            </div>
            
<?php
require_once "connect.php";
?>

            <?php

mysqli_report(MYSQLI_REPORT_STRICT);
try
{
    $connect = @new mysqli($host, $db_user, $db_password, $db_name);
    if($connect->connect_errno!=0)
    {
        throw new Exception(mysqli_connect_errno());
    }
    else
    {
        $query="SELECT * FROM add_more GROUP BY category";
        if ($result = $connect->query($query)) 
        {
            $num_of_categories=$result->num_rows;
            $count=0;
            while($row=$result->fetch_assoc())
            {
                $current_category=$row['category'];
                echo '<h2 class="catadd">'.$row['category'].'</h2>';
                $query="SELECT * FROM add_more WHERE category='$current_category'";
                if($category_result=$connect->query($query))
                {
                    while ($category_row=$category_result->fetch_assoc())
                    {
                        echo '<div class="pizzadesc">';
                        echo '<p class="pizzah1">'.$category_row['name'].'</p>';
                        echo "Cena: ".$category_row['price'];
                        echo ' zł</br><a class="addpizza" href="addmore.php?add='.$row["id_add"].'&price='.$category_row['price'].'">Dodaj do zamówienia</a></br>';
                        echo "</div>";
                    }
                }
            }
            
            $result->free();
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
            </div></div></div></body></html>