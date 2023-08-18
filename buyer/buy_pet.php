<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Buyer') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $pet_id = $_GET['id'];
    
    $query = "SELECT Pets.*, Users.username AS seller_name FROM Pets
              INNER JOIN Users ON Pets.seller_id = Users.id
              WHERE Pets.id = $pet_id";
    $result = $conn->query($query);
    
    if ($result->num_rows == 1) {
        $pet = $result->fetch_assoc();
    } else {
        header("Location: buyer_home.php");
        exit();
    }
} else {
    header("Location: buyer_home.php");
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $buyer_id = $_SESSION['user_id'];
    $payment_method = $_POST['payment_method'];
    $status = 'pending';
    
    $insert_query = "INSERT INTO Buying (buyer_id, pet_id, payment_method, status)
                     VALUES ($buyer_id, $pet_id, '$payment_method', '$status')";
    
    if ($conn->query($insert_query)) {
        $message = "Purchase initiated successfully. Your request is pending for approval.";
    } else {
        $message = "Error initiating purchase: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buy Pet</title>
</head>
<body>
<?php include('navbar.php'); ?> 
<h2>Buy Pet</h2>
<p><?php echo $message; ?></p>
<table>
    <tr>
        <th>Pet ID</th>
        <td><?php echo $pet['id']; ?></td>
    </tr>
    <tr>
        <th>Pet Name</th>
        <td><?php echo $pet['pet_name']; ?></td>
    </tr>
    <tr>
        <th>Gender</th>
        <td><?php echo $pet['gender']; ?></td>
    </tr>
    <tr>
        <th>City</th>
        <td><?php echo $pet['city']; ?></td>
    </tr>
    <tr>
        <th>Price</th>
        <td><?php echo $pet['price']; ?></td>
    </tr>
    <tr>
        <th>Seller Name</th>
        <td><?php echo $pet['seller_name']; ?></td>
    </tr>
    <tr>
        <th>Pet Picture</th>
        <td><img src="../seller/<?php echo $pet['pet_picture']; ?>" width="200" height="200" alt="Pet Picture"></td>
    </tr>
</table>
<br>
<h3>Select Payment Method:</h3>
<form method="POST">
    <label for="payment_method">Payment Method:</label>
    <select id="payment_method" name="payment_method">
        <option value="Cash Payment">Cash Payment</option>
    </select><br><br>
    <input type="submit" value="Buy">
</form>
</body>
</html>
