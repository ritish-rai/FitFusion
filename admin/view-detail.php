<?php
include 'includes/header.php';
include '../middleware/adminmiddle.php';

if (isset($_GET['id'])) {
    $package_id = $_GET['id'];
    $package_query = "SELECT * FROM user_packages WHERE id = '$package_id'";
    $package_data = mysqli_query($con, $package_query);

    if (mysqli_num_rows($package_data) <= 0) {
        echo 'Something went wrong';
        exit;
    }
} else {
    echo 'Something went wrong';
    exit;
}

$data = mysqli_fetch_array($package_data);
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success">
                    <span class="text-white fs-4">View Package</span>
                   
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Package Details -->
                        <div class="col-md-6">
                            <h4>Package Details</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="">User Name</label>
                                    <div class="border p-1"><?= htmlspecialchars($data['username']); ?></div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label class="fw-bold">Package Heading</label>
                                    <div class="border p-1"><?= htmlspecialchars($data['package_heading']); ?></div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label class="fw-bold">Description</label>
                                    <div class="border p-1"><?= htmlspecialchars($data['package_description']); ?></div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label class="fw-bold">Package Price</label>
                                    <div class="border p-1"><?= htmlspecialchars($data['package_price']); ?></div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label class="fw-bold">Created At</label>
                                    <div class="border p-1"><?= htmlspecialchars($data['created_at']); ?></div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
