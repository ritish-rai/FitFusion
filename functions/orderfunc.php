<?php
include '../config/dbcon.php';
function getCartItems()
{
    global $con;
    $uid = $_SESSION['auth_user']['user_id'];
    $query = "SELECT c.id as cid, c.prod_id, c.prod_qty, p.pid as pid, p.name, p.img, p.price 
              FROM carts as c, product as p
              WHERE c.prod_id = p.pid AND c.user_id = '$uid' 
              ORDER BY c.id DESC";
    return $res = mysqli_query($con, $query);
}
?>