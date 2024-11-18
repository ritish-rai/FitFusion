<?php 
include('includes/header.php'); 
include('../middleware/adminmiddle.php'); 

?>
<div class="container">
    <div class="row">
       <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            <h4>Edit Packages</h4>
        </div>
        <?php if(isset($_GET['id'])) {
            $id=$_GET['id'];
            $prod=getbyId("packages",$id);
            if(mysqli_num_rows($prod)>0){
                $data=mysqli_fetch_array($prod); 
            ?>
            <div class="card-body">
                <form action="code.php" method="post" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <input type="hidden" name="product_id" value="<?= $data['id']?>">
                        <label for="product_name">Package Name:</label>
                        <input type="text" name="product_name" value="<?= $data['heading']?>" class="form-control" placeholder="Enter Product Name">
                    </div>
                    <div class="col-md-6">
                        <label for="product_price">Package Price:</label>
                        <input type="number" name="product_price"  value="<?= $data['price']?>" class="form-control" placeholder="Enter Product Price">
                    </div>
                    <div class="col-md-6">
                        <label for="product_image">Package Image:</label>
                        <input type="file" name="product_image" class="form-control">
                        <input type="hidden" name="old_image" value="<?= $data['img']?>">
                        <img src="../images/<?= $data['img']?>" alt="" height="50px" width="50px">
                    </div>
                    <div class="col-md-6">
                        <label for="product_description">Package Description:</label>
                        <textarea name="product_description" class="form-control" rows="5" cols="5"> <?= $data['discription']?> </textarea>
                    </div>
                    <div class="col-md-12">
                    <button type="submit" name="update_product" class="btn btn-success">Update</button>
                    </div>
            </div>
            <?php
            }
            else
            {
                echo "Product Not Found";
            }    
        } 
            else { 
                    echo '<script>alert("Invalid Request")</script>';
                 }
                ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>