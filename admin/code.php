<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../config/dbcon.php');
include('../functions/myfunction.php');

if (isset($_POST['add_product'])) {
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $description = $_POST['product_description'];
    $img = $_FILES['product_image']['name'];

    $path = "../images";
    $img_ext = pathinfo($img, PATHINFO_EXTENSION);
    $img_name = $name . "." . $img_ext;

    $prod_query = "INSERT INTO packages (heading,  price, discription, img) VALUES ('$name',  '$price', '$description', '$img_name')";
    $res = mysqli_query($con, $prod_query);

    if ($res) {
        move_uploaded_file($_FILES['product_image']['tmp_name'], $path . '/' . $img_name);
        redirect("add-products.php", "Added Successfully");
    } else {
        redirect("add-products.php", "Something Went Wrong");
    }
} elseif (isset($_POST['update_product'])) {
    $prod_id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $description = $_POST['product_description'];
    $new_img = $_FILES['product_image']['name'];
    $old_img = $_POST['old_image'];

    if ($new_img != "") {
        $img_ext = pathinfo($new_img, PATHINFO_EXTENSION);
        $update_filename = $name . "." . $img_ext;
    } else {
        $update_filename = $old_img;
    }

    $path = "../images";
    $update_query = "UPDATE packages SET heading='$name', price='$price', discription='$description', img='$update_filename' WHERE id='$prod_id'";
    $res = mysqli_query($con, $update_query);

    if ($res) {
      
        if ($_FILES['product_image']['error'] == 0 && $_FILES['product_image']['name'] != "") {
            $upload_success = move_uploaded_file($_FILES['product_image']['tmp_name'], $path . '/' . $update_filename);
            if ($upload_success) {
                
                if ($old_img != $update_filename && file_exists("../images/" . $old_img)) {
                    unlink("../images/" . $old_img);
                }
            } else {
                redirect("edit-product.php?id=$prod_id", "Image upload failed.");
            }
        }
        redirect("edit-product.php?id=$prod_id", "Product Updated Successfully");
    } else {
        redirect("edit-product.php?id=$prod_id", "Something Went Wrong");
    }
} elseif (isset($_POST['delete_product'])) {
    $prod_id = mysqli_real_escape_string($con, $_POST['pid']);

    $prod_query = "SELECT * FROM packages WHERE id='$prod_id'";
    $prod_run = mysqli_query($con, $prod_query);
    $prod_data = mysqli_fetch_array($prod_run);
    $img = $prod_data['img'];

    $del_query = "DELETE FROM packages WHERE id='$prod_id'";
    $del_run = mysqli_query($con, $del_query);

    if ($del_run) {
        if (file_exists("../images/" . $img)) {
            unlink("../images/" . $img);
        }
        redirect("products.php", "Product Deleted Successfully");
    } else {
        redirect("products.php", "Something Went Wrong");
    }
}
?>
