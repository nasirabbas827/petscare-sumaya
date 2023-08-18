<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Buyer') {
    header("Location: index.php");
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    $update_query = "UPDATE Users SET username = '$username', email = '$email', phone = '$phone', address = '$address'
                     WHERE id = $user_id";
    
    if ($conn->query($update_query)) {
        $message = "Profile updated successfully.";
    } else {
        $message = "Error updating profile: " . $conn->error;
    }
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM Users WHERE id = $user_id";
$result = $conn->query($query);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buyer Update Profile</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>


<?php include('navbar.php'); ?> 
<div class="container mt-4">
    <h2>Update Your Profile</h2>
    <p><?php echo $message; ?></p>
    <form method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
        
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo $user['phone']; ?>" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address" class="form-control" required><?php echo $user['address']; ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
<!-- Include Bootstrap JS script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
