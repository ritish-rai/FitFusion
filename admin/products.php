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
                <h4> Packages </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Package ID</th>
                            <th>Package Name</th>
                            <th>Package Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $prod = getAll("packages");

                            // Validate query result
                            if ($prod && mysqli_num_rows($prod) > 0) {
                                foreach ($prod as $items) {
                                ?>
                                <tr>
                                    <td><?php echo $items['id']; ?></td>
                                    <td><?php echo $items['heading']; ?></td>
                                    <td>
                                        <img src="../images/<?php echo $items['img']; ?>" 
                                             width="50px" height="50px" 
                                             alt="<?php echo $items['heading']; ?>">
                                    </td>
                                    <td>
                                        <a href="edit-product.php?id=<?php echo $items['id']; ?>" 
                                           class="btn btn-success">EDIT</a>
                                        <form action="code.php" method="post">
                                            <input type="hidden" name="pid" value="<?php echo $items['id']; ?>">
                                            <button type="submit" class="btn btn-danger" name="delete_product">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                                }
                            } else {
                                echo "<tr><td colspan='4'>No products found</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
           </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
