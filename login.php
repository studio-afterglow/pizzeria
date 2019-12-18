<?php

    session_start();

    if((!isset($_POST['login'])) || (!isset($_POST['password']))){
        header('Location: logform.php');
        exit();
    }

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
        $login=mysqli_real_escape_string($connect, $_POST['login']);
        $password=$_POST['password'];
        if($result = $connect->query("SELECT * FROM admin_base WHERE login='$login'"))
        {
            
            if($result->num_rows>0)
            {
                $row=$result->fetch_assoc();
                if(password_verify($password, $row['password'])){
                    $_SESSION['logged']=true;
                    header("Location: admin.php");
                }
                else
                {
                    $hint=$row['hint'];
                    $_SESSION['log_error']="Nieprawidłowe hasło. Twoja podpowiedź: '$hint'";
                    header('Location: logform.php');
                }
            }
            else
            {
                $_SESSION['log_error']="Nie ma takiego użytkownika '$login'";
                header('Location: logform.php');
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


?>