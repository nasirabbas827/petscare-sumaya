<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Query to get counts
$total_users_query = "SELECT COUNT(*) AS total_users FROM Users";
$total_buyers_query = "SELECT COUNT(*) AS total_buyers FROM Users WHERE user_role = 'Buyer'";
$total_sellers_query = "SELECT COUNT(*) AS total_sellers FROM Users WHERE user_role = 'Seller'";
$total_doctors_query = "SELECT COUNT(*) AS total_doctors FROM Users WHERE user_role = 'Doctor'";
$total_appointments_query = "SELECT COUNT(*) AS total_appointments FROM Appointments";
$total_pets_query = "SELECT COUNT(*) AS total_pets FROM Pets";
$total_buy_records_query = "SELECT COUNT(*) AS total_buy_records FROM Buying";

// Execute queries
$total_users_result = $conn->query($total_users_query);
$total_buyers_result = $conn->query($total_buyers_query);
$total_sellers_result = $conn->query($total_sellers_query);
$total_doctors_result = $conn->query($total_doctors_query);
$total_appointments_result = $conn->query($total_appointments_query);
$total_pets_result = $conn->query($total_pets_query);
$total_buy_records_result = $conn->query($total_buy_records_query);

// Fetch counts
$total_users = $total_users_result->fetch_assoc()['total_users'];
$total_buyers = $total_buyers_result->fetch_assoc()['total_buyers'];
$total_sellers = $total_sellers_result->fetch_assoc()['total_sellers'];
$total_doctors = $total_doctors_result->fetch_assoc()['total_doctors'];
$total_appointments = $total_appointments_result->fetch_assoc()['total_appointments'];
$total_pets = $total_pets_result->fetch_assoc()['total_pets'];
$total_buy_records = $total_buy_records_result->fetch_assoc()['total_buy_records'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('admin_navbar.php'); ?> 
<div class="container mt-4">
    <h2>Admin Dashboard</h2>
    <div class="row mt-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">Count: <?php echo $total_users; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Buyers</h5>
                    <p class="card-text">Count: <?php echo $total_buyers; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Sellers</h5>
                    <p class="card-text">Count: <?php echo $total_sellers; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Doctors</h5>
                    <p class="card-text">Count: <?php echo $total_doctors; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Appointments</h5>
                    <p class="card-text">Count: <?php echo $total_appointments; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Pets</h5>
                    <p class="card-text">Count: <?php echo $total_pets; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Buy Records</h5>
                    <p class="card-text">Count: <?php echo $total_buy_records; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Include Bootstrap JS script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
