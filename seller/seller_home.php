<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Seller') {
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_name = $_POST['pet_name'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $price = $_POST['price'];

    // Upload pet picture (you need to handle the image upload)
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["pet_picture"]["name"]);
    move_uploaded_file($_FILES["pet_picture"]["tmp_name"], $target_file);

    $seller_id = $_SESSION['user_id'];

    $insert_query = "INSERT INTO Pets (seller_id, pet_name, gender, city, price, pet_picture)
                     VALUES ($seller_id, '$pet_name', '$gender', '$city', $price, '$target_file')";

    if ($conn->query($insert_query)) {
        $message = "Pet added successfully.";
    } else {
        $message = "Error adding pet: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Seller Home</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('navbar.php'); ?> 
<div class="container mt-4 mb-5">
    <h2>Welcome, Seller <?php echo $user['username']; ?></h2>
    <p>Email: <?php echo $user['email']; ?></p>
    <p>Phone: <?php echo $user['phone']; ?></p>

    <h2>Add Pet for Selling</h2>
    <p><?php echo $message; ?></p>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="pet_picture">Pet Picture:</label>
            <input type="file" class="form-control-file" id="pet_picture" name="pet_picture" accept="image/*" required>
        </div>

        <div class="form-group">
            <label for="pet_name">Pet Name:</label>
            <input type="text" class="form-control" id="pet_name" name="pet_name" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select class="form-control" id="gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Pet</button>
    </form>
</div>
<!-- Include Bootstrap JS script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
