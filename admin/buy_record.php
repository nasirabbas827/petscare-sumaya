<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

$query = "SELECT Buying.*, Pets.pet_name, Pets.price AS pet_price, Users.username AS buyer_name, Users.email AS buyer_email, Users.phone AS buyer_phone
          FROM Buying
          INNER JOIN Pets ON Buying.pet_id = Pets.id
          INNER JOIN Users ON Buying.buyer_id = Users.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin View Buying Records</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('admin_navbar.php'); ?> 
<div class="container">
    <h2 class="mt-3">View Buying Records</h2>
    <table class="table table-bordered">
        <tr>
            <th>Order ID</th>
            <th>Pet Name</th>
            <th>Buyer Name</th>
            <th>Buyer Email</th>
            <th>Buyer Phone</th>
            <th>Price</th>
            <th>Status</th>
            <th>Payment Method</th>
            <th>Timestamp</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['pet_name']; ?></td>
                <td><?php echo $row['buyer_name']; ?></td>
                <td><?php echo $row['buyer_email']; ?></td>
                <td><?php echo $row['buyer_phone']; ?></td>
                <td><?php echo $row['pet_price']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><?php echo $row['timestamp']; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
<!-- Include Bootstrap JS script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
