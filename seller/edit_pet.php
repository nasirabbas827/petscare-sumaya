<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Seller') {
    header("Location: ../index.php");
    exit();
}

$seller_id = $_SESSION['user_id'];
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_id = $_POST['pet_id'];
    $pet_name = $_POST['pet_name'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $price = $_POST['price'];

    $update_query = "UPDATE Pets SET pet_name = '$pet_name', gender = '$gender', city = '$city', price = $price WHERE id = $pet_id AND seller_id = $seller_id";

    if ($conn->query($update_query)) {
        $message = "Pet details updated successfully.";
    } else {
        $message = "Error updating pet details: " . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $pet_id = $_GET['id'];

    // Fetch pet details
    $pet_query = "SELECT * FROM Pets WHERE id = $pet_id AND seller_id = $seller_id";
    $pet_result = $conn->query($pet_query);

    if ($pet_result->num_rows == 1) {
        $pet_data = $pet_result->fetch_assoc();
    } else {
        header("Location: view_pets.php");
        exit();
    }
} else {
    header("Location: view_pets.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pet</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('navbar.php'); ?> 
<div class="container mt-4">
    <h2>Edit Pet Details</h2>
    <p><?php echo $message; ?></p>
    <form method="POST">
        <input type="hidden" name="pet_id" value="<?php echo $pet_data['id']; ?>">

        <div class="form-group">
            <label for="pet_name">Pet Name:</label>
            <input type="text" id="pet_name" name="pet_name" value="<?php echo $pet_data['pet_name']; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" class="form-control">
                <option value="Male" <?php if ($pet_data['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($pet_data['gender'] === 'Female') echo 'selected'; ?>>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo $pet_data['city']; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo $pet_data['price']; ?>" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Details</button>
    </form>
</div>
<!-- Include Bootstrap JS script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
