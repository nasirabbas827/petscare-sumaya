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

$query = "SELECT Pets.*, Users.username AS seller_name FROM Pets
          INNER JOIN Users ON Pets.seller_id = Users.id";
$result = $conn->query($query);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Buyer Home</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('navbar.php'); ?> 
<div class="container mt-4">
    <h2>Welcome, Buyer <?php echo $user['username']; ?></h2>
    <p>Email: <?php echo $user['email']; ?></p>
    <p>Phone: <?php echo $user['phone']; ?></p>

    <h2>View Pets</h2>
    <p><?php echo $message; ?></p>
    <div class="row">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="../seller/<?php echo $row['pet_picture']; ?>" class="card-img-top" alt="Pet Picture" style="height: 200px;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['pet_name']; ?></h5>
                        <p class="card-text">Gender: <?php echo $row['gender']; ?></p>
                        <p class="card-text">City: <?php echo $row['city']; ?></p>
                        <p class="card-text">Price: $<?php echo $row['price']; ?></p>
                        <p class="card-text">Seller: <?php echo $row['seller_name']; ?></p>
                        <a href="buy_pet.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Buy</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<!-- Include Bootstrap JS script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
