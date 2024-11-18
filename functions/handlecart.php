<?php
session_start();
header('Content-Type: application/json');
include('../config/dbcon.php');

if (isset($_SESSION['auth'])) {
    if (isset($_POST['scope']) && $_POST['scope'] === "add") {
        if (!isset($_POST['prod_id']) || !isset($_POST['prod_qty'])) {
            echo json_encode(["status" => 400, "error" => "Product ID or Quantity missing"]);
            exit;
        }
        
        $prod_id = mysqli_real_escape_string($con, $_POST['prod_id']);
        $prod_qty = mysqli_real_escape_string($con, $_POST['prod_qty']);
        $user_id = $_SESSION['auth_user']['user_id'];

        $chk_cart = "SELECT * FROM carts WHERE prod_id='$prod_id' AND user_id='$user_id'";
        $result_chk_cart = mysqli_query($con, $chk_cart);

        if (mysqli_num_rows($result_chk_cart) > 0) {
            echo json_encode("existing"); 
        } else {
            $insert_query = "INSERT INTO carts (user_id, prod_id, prod_qty) VALUES ('$user_id', '$prod_id', '$prod_qty')";
            $res = mysqli_query($con, $insert_query);

            if ($res) {
                $_SESSION['message'] = "Product added to cart!";
                echo json_encode(["status" => 201]);
            } else {
                echo json_encode(["status" => 500, "error" => mysqli_error($con)]);
            }
        }
    } elseif (isset($_POST['scope']) && $_POST['scope'] === "update") {
        if (!isset($_POST['prod_id']) || !isset($_POST['prod_qty'])) {
            echo json_encode(["status" => 400, "error" => "Product ID or Quantity missing"]);
            exit;
        }

        $prod_id = mysqli_real_escape_string($con, $_POST['prod_id']);
        $prod_qty = mysqli_real_escape_string($con, $_POST['prod_qty']);
        $user_id = $_SESSION['auth_user']['user_id'];
        
        $chk_cart = "SELECT * FROM carts WHERE prod_id='$prod_id' AND user_id='$user_id'";
        $result_chk_cart = mysqli_query($con, $chk_cart);

        if (mysqli_num_rows($result_chk_cart) > 0) {
            $update_query = "UPDATE carts SET prod_qty='$prod_qty' WHERE prod_id='$prod_id' AND user_id='$user_id'";
            $res = mysqli_query($con, $update_query);
            if ($res) {
                echo json_encode(["status" => 201]);
            } else {
                echo json_encode(["status" => 500, "error" => mysqli_error($con)]);
            }
        } else {
            echo json_encode(["status" => 404, "error" => "Product not found in cart"]);
        }
    } 
    elseif (isset($_POST['scope']) && $_POST['scope'] === "delete")
    {
        $cart_id = mysqli_real_escape_string($con, $_POST['cart_id']);
        $user_id = $_SESSION['auth_user']['user_id'];
        $chk_cart = "SELECT * FROM carts WHERE id='$cart_id' AND user_id='$user_id'";
        $result_chk_cart = mysqli_query($con, $chk_cart);

        if (mysqli_num_rows($result_chk_cart) > 0) {
            $delete_query = "DELETE FROM carts WHERE id='$cart_id'";
            $res = mysqli_query($con, $delete_query);
            if ($res) {
                echo json_encode(["status" => 201,"cart_id" => $cart_id]);
            } else {
                echo json_encode(["status" => 500, "error" => mysqli_error($con)]);
            }
        } else {
            echo json_encode(["status" => 404, "error" => "Product not found in cart"]);
        }
    }
    else {
        echo json_encode(["status" => 500, "error" => "Invalid scope"]);
    }
} else {
    echo json_encode(["status" => 401, "error" => "Not authenticated"]);
}
