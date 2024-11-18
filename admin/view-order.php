<?php
include 'includes/header.php';
include '../middleware/adminmiddle.php';
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4> User Packages </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Package Heading</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>View</th>
                        </thead>
                        <tbody>
                            <?php
                            // Query to fetch all user packages
                            $query = "SELECT * FROM user_packages ORDER BY created_at DESC";
                            $result = mysqli_query($con, $query);

                            if ($result) {
                                if (mysqli_num_rows($result) > 0) {
                                    foreach ($result as $row) {
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['id']); ?></td>
                                            <td><?= htmlspecialchars($row['username']); ?></td>
                                            <td><?= htmlspecialchars($row['package_heading']); ?></td>
                                            <td><?= htmlspecialchars($row['package_price']); ?></td>
                                            <td><?= htmlspecialchars($row['created_at']); ?></td>
                                            <td>
                                                <a href="view-detail.php?id=<?= htmlspecialchars($row['id']); ?>" class="btn btn-success">View
                                                    details</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6">No packages found</td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "Error: " . mysqli_error($con);
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
