<?php

session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Doctor') {
    header("Location: ../index.php");
    exit();
}
// Check if the form was submitted
if (isset($_POST['update_profile'])) {
    $doctor_id = $_POST['doctor_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];

    // Perform update query on the database to update the doctor's profile
    $update_query = "UPDATE users SET username = '$username', email = '$email', phone = '$phone', city = '$city', address = '$address' WHERE id = '$doctor_id'";
    
    if ($conn->query($update_query) === TRUE) {
        $message = "Profile updated successfully.";
    } else {
        $message = "Error updating profile: " . $conn->error;
    }
}

// Fetch doctor's current profile information from the database
$doctor_id = $_SESSION['user_id']; // Replace with actual session variable
$select_query = "SELECT * FROM users WHERE id = '$doctor_id'";
$result = $conn->query($select_query);
$doctor = $result->fetch_assoc();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Profile Update</title>
    <!-- Add Bootstrap CDN link here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('navbar.php'); ?> 
<div class="container mb-5">
    <h2>Welcome, Doctor <?php echo $doctor['username']; ?></h2>
    <p>Email: <?php echo $doctor['email']; ?></p>
    <p>Phone: <?php echo $doctor['phone']; ?></p>

    <h2>Update Profile</h2>
    <p><?php echo isset($message) ? $message : ''; ?></p>
    <form method="POST">
        <input type="hidden" name="doctor_id" value="<?php echo $doctor['id']; ?>">

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" value="<?php echo $doctor['username']; ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo $doctor['email']; ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo $doctor['phone']; ?>" required>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" class="form-control" value="<?php echo $doctor['city']; ?>" required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address" class="form-control" required><?php echo $doctor['address']; ?></textarea>
        </div>

        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
    </form>
</div>
</body>
</html>
