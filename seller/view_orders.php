<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Seller') {
    header("Location: ../index.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

$query = "SELECT * FROM Users WHERE id = $seller_id";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $seller = $result->fetch_assoc();
}

$message = '';

// Update order status
if (isset($_POST["update_status"])) {
    $order_id = $_POST["order_id"];
    $new_status = $_POST["new_status"];

    $update_query = "UPDATE Buying SET status = '$new_status' WHERE id = $order_id AND pet_id IN (SELECT id FROM Pets WHERE seller_id = $seller_id)";

    if ($conn->query($update_query)) {
        $message = "Order status updated successfully.";
    } else {
        $message = "Error updating order status: " . $conn->error;
    }
}

$query = "SELECT Buying.*, Pets.pet_name, Pets.price AS pet_price, Users.username AS buyer_name, Users.email AS buyer_email
          FROM Buying
          INNER JOIN Pets ON Buying.pet_id = Pets.id
          INNER JOIN Users ON Buying.buyer_id = Users.id
          WHERE Pets.seller_id = $seller_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Selling Orders</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('navbar.php'); ?> 
<div class="container mt-4">
    <h2>My Selling Orders</h2>
    <p>Welcome, <?php echo $seller['username']; ?>! Here are your selling orders:</p>
    <table class="table">
        <tr>
            <th>Order ID</th>
            <th>Pet Name</th>
            <th>Buyer Name</th>
            <th>Buyer Email</th>
            <th>Price</th>
            <th>Status</th>
            <th>Payment Method</th>
            <th>Timestamp</th>
            <th>Update Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['pet_name']; ?></td>
                <td><?php echo $row['buyer_name']; ?></td>
                <td><?php echo $row['buyer_email']; ?></td>
                <td><?php echo $row['pet_price']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><?php echo $row['timestamp']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                        <select name="new_status" class="form-control">
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="cancel">Cancel</option>
                        </select>
                        <button type="submit" name="update_status" class="mt-2 btn btn-primary">Update</button>
                    </form>
                </td>
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

