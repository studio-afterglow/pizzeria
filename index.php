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
            <div class="row justify-content-center">
        <a class="main-links col-md-4" href="cartforcustomer.php">Koszyk</a>
        <a class="main-links col-md-4" href="more.php">Domów dodatki</a>
        <a class="main-links col-md-4" href="finalize.php">Sfinalizuj zamówienie</a>
            </div>
        
        <form method="post" class="pickpizza">
            Rozmiar pizzy:   
            <select name="size">
                <option <?php
                       if(isset($_POST['size']) && $_POST['size']=="Mała")
                       {
                           echo "selected";
                       }
                       ?>>Mała</option>
                <option <?php
                       if(isset($_POST['size']) && $_POST['size']=="Duża")
                       {
                           echo "selected";
                       }
                       ?>>Duża</option>
            </select>
            Ciasto:   
            <select name="crust">
                <option <?php
                       if(isset($_POST['crust']) && $_POST['crust']=="Cienkie")
                       {
                           echo "selected";
                       }
                       ?>>Cienkie</option>
                <option <?php
                       if(isset($_POST['crust']) && $_POST['crust']=="Grube")
                       {
                           echo "selected";
                       }
                       ?>>Grube</option>
            </select>
            <br />Wegetariańska:   
            <input type="checkbox" name="vegetarian" <?php
                       if(isset($_POST['vegetarian']))
                       {
                           echo "checked";
                       }
                       ?>/>
            Pikantna:   
            <input type="checkbox" name="hot" <?php
                       if(isset($_POST['hot']))
                       {
                           echo "checked";
                       }
                       ?>/>
            <br /><input type="submit" value="Pokaż pasujące pizze">
        </form>

<?php
    require_once "connect.php";
            
    mysqli_report(MYSQLI_REPORT_STRICT);
    if(isset($_POST['size'])){
        $crust=$_POST['crust'];
        $size=$_POST['size'];
        if(isset($_POST['vegetarian']))
        {
            $vegetarian=1;
        }
        else $vegetarian=0;
        if(isset($_POST['hot']))
        {
            $hot=1;
        }
        else $hot=0;
       try{
            $connect = @new mysqli($host, $db_user, $db_password, $db_name);
           $connect->set_charset("utf8");
            if($connect->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {
                if($vegetarian==1)
                {
                    if($hot==1)
                    {
                       $query="SELECT * FROM pizza_list where crust='$crust' AND is_vegetarian='$vegetarian' AND is_hot='$hot'";
                    }
                    else
                    {
                        $query="SELECT * FROM pizza_list where crust='$crust' AND is_vegetarian='$vegetarian'";
                    }
                }
                else
                {
                   if($hot==1)
                   {
                       $query="SELECT * FROM pizza_list where crust='$crust' AND is_hot='$hot'";
                   }
                    else
                    {
                        $query="SELECT * FROM pizza_list where crust='$crust'";
                    }
                }
                if ($result = $connect->query($query)) 
                {
                    if($result->num_rows==0)
                    {
                        echo "Nie znaleziono takiej pizzy. Zmień lub rozszerz nieco kryteria!";
                    }
                    while ($row = $result->fetch_assoc()) 
                    {
                        echo '<div class="pizzadesc">';
                        printf ('<p class="pizzah1">%s </p>', $row["pizza_name"]);
                        echo $row["description"]."</br>Cena: ";
                        if($_POST['size']=="Mała")
                        {
                            echo $row['price_small'];
                            $pizza_price=$row['price_small'];
                        }
                        else
                        {
                           echo $row['price_large']; 
                           $pizza_price=$row['price_small']; 
                        }
                        echo ' zł</br><a  class="addpizza" href="addpizza.php?pizza='.$row["id_pizza"].'&price='.$pizza_price.'">Dodaj do zamówienia</a></div>';
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
    }
    

?>
        <?php
        if(isset($_SESSION['added_pizza'])){
        echo '<p class="info">'.$_SESSION['added_pizza'].'</p>';
        unset($_SESSION['added_pizza']);
    }
        ?>
        </div></div></div>
    </body>
</html>