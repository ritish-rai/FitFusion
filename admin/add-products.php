<?php 
include('includes/header.php'); 
include('../middleware/adminmiddle.php'); 
// include ('../functions/myfunction.php');
?>
<div class="container">
    <div class="row">
       <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            <h4>Add Package</h4>
        </div>
        <div class="card-body">
            <form action="code.php" method="post" enctype="multipart/form-data">
                <div class="col-md-6">
                    <label for="product_name">Package Name:</label>
                    <input type="text" name="product_name" class="form-control" placeholder="Enter Product Name">
                </div>
                <div class="col-md-6">
                    <label for="product_price">Package Price:</label>
                    <input type="number" name="product_price" class="form-control" placeholder="Enter Product Price">
                </div>
                <div class="col-md-6">
                    <label for="product_image">Package Image:</label>
                    <input type="file" name="product_image" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="product_description">Package Description:</label>
                    <textarea name="product_description" class="form-control" rows="5" cols="5"></textarea>
                </div>
                <div class="col-md-12">
                <button type="submit" name="add_product" class="btn btn-success">Add Package</button>
                </div>
        </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>