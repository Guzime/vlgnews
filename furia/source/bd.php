<?php 
        global $dbh;
    try
    {
        $dbh = new PDO('mysql:host=localhost;dbname=test', "root", "");
    }
    catch (PDOException $exception)
    {
        echo $exception->getMessage();
    }
     
?>