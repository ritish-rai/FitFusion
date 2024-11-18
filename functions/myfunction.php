<?php
include('../config/dbcon.php');

function redirect($url, $msg)
{
    $_SESSION['message'] = $msg;
    header("Location: $url");  
    exit();
}
function getAll($table)
{
    global $con;
    $query="SELECT * FROM $table";
    return $res=mysqli_query($con,$query);
}
function getbyId($table,$id)
{
    global $con;
    $query="SELECT * FROM $table WHERE id='$id'";
    return $res=mysqli_query($con,$query);
}


?>
