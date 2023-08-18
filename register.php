<?php
session_start();
include('config.php');

// Initialize variables
$username = $email = $password = $phone = $age = $city = $address = $user_role = $status = '';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $user_role = $_POST['user_role'];
    $status = 'pending'; // Default status for new registrations
    
    // Insert data into Users table
    $query = "INSERT INTO Users (username, email, password, phone, age, city, address, user_role, status)
              VALUES ('$username', '$email', '$password', '$phone', $age, '$city', '$address', '$user_role', '$status')";
    
    if ($conn->query($query) === TRUE) {
        $message = "Registration successful!";
    } else {
        $message = "Error: " . $query . "<br>" . $conn->error;
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <!-- Add Bootstrap CDN link here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        form {
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<?php
include('navbar.php');
?>
<div class="container mb-4">
    <h2>User Registration</h2>
    <p><?php echo $message; ?></p>
    <form method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="user_role">User Role:</label>
            <select id="user_role" name="user_role" class="form-control">
                <option value="Doctor">Doctor</option>
                <option value="Seller">Seller</option>
                <option value="Buyer">Buyer</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
</body>
</html>
