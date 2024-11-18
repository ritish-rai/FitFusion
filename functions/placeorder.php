<?php
session_start();
require 'orderfunc.php';

if (isset($_SESSION['auth']))
{
    if(isset($_POST['placeOrderBtn']))
    {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $pincode = mysqli_real_escape_string($con, $_POST['pincode']);
        $address = mysqli_real_escape_string($con, $_POST['address']);
        $payment_mode = mysqli_real_escape_string($con, $_POST['payment_mode']);
        $payment_id = mysqli_real_escape_string($con, $_POST['payment_id']);

        if ($name == '' || $email == '' || $phone == '' || $pincode == '' || $address == '')
        {
            $_SESSION['message'] = "All fields are mandatory";
            header("Location: ../checkout.php");
            exit(0);
        }

        $cartItems = getCartItems();
        $totalprice = 0;
        foreach ($cartItems as $citem)
        {
            $totalprice += $citem['price'] * $citem['prod_qty'];
        }

        $uid = $_SESSION['auth_user']['user_id'];
        $tracking_no = "techsevi" . rand(1111, 9999);
        $insert_query = "INSERT INTO orders (tracking_no, user_id, name, email, phone, address, pincode, total_price, payment_mode, payment_id) VALUES ('$tracking_no', '$uid', '$name', '$email', '$phone', '$address', '$pincode', '$totalprice', '$payment_mode', '$payment_id')";

        $res = mysqli_query($con, $insert_query);

        if ($res)
        {
            $order_id = mysqli_insert_id($con);
            foreach ($cartItems as $citem)
            {
                $prod_id = $citem['prod_id'];
                $prod_qty = $citem['prod_qty'];
                $prod_price = $citem['price'];
                $insert_items_query = "INSERT INTO order_items (order_id, prod_id, qty, price) VALUES ('$order_id', '$prod_id', '$prod_qty', '$prod_price')";
                $run = mysqli_query($con, $insert_items_query);
            }
            $deleteCartQuery="DELETE FROM carts WHERE user_id='$uid'";
            $delrun= mysqli_query($con, $deleteCartQuery);
            $_SESSION["message"] = "Order Placed successfully";
            header("Location: ../myorder.php");
            die();
        }
    }
}
else
{
    header('Location: index.php');
}
?>
