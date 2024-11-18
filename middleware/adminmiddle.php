<?php


include('../functions/myfunction.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header('Location: ../index.php');
    exit();
    
}

?>

