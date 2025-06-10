<?php
function getdb(){
    $servername = "localhost";
    $username = "usuario";
    $password = "senha";
    $db = "fiscal";
    
    try {
        $conn = mysqli_connect($servername, $username, $password, $db); //echo "Connected successfully"; 
    }
    catch(exception $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    return $conn;
}
?>