<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Buyer') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM Users WHERE id = $user_id";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
}

$message = '';

$query = "SELECT Buying.*, Pets.pet_name, Pets.pet_picture, Pets.price, Pets.seller_id, Users.username AS seller_name
          FROM Buying
          INNER JOIN Pets ON Buying.pet_id = Pets.id
          INNER JOIN Users ON Pets.seller_id = Users.id
          WHERE Buying.buyer_id = $user_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Purchases</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('navbar.php'); ?> 
<div class="container mt-4">
    <h2>My Purchases</h2>
    <p>Welcome, <?php echo $user['username']; ?>! Here are your purchased pets:</p>
    <table class="table">
        <tr>
            <th>Pet ID</th>
            <th>Pet Name</th>
            <th>Price</th>
            <th>Seller Name</th>
            <th>Status</th>
            <th>Payment Method</th>
            <th>Timestamp</th>
            <th>Pet Picture</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['pet_id']; ?></td>
                <td><?php echo $row['pet_name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['seller_name']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><?php echo $row['timestamp']; ?></td>
                <td><img src="../seller/<?php echo $row['pet_picture']; ?>" width="100" height="100" alt="Pet Picture"></td>
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

