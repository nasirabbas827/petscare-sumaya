<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM Users WHERE email = '$email' AND password = "YOUR_OWN_API_KEY"";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['status'] === 'approved') {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_role'] = $row['user_role'];
            
            switch ($row['user_role']) {
                case 'Doctor':
                    header("Location: doctor/doctor_home.php");
                    break;
                case 'Seller':
                    header("Location: seller/seller_home.php");
                    break;
                case 'Buyer':
                    header("Location: buyer/buyer_home.php");
                    break;
                default:
                    break;
            }
            exit();
        } else {
            $message = "Your account is not approved yet. Please wait for approval.";
        }
    } else {
        $message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
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
<div class="container">
    <h2>User Login</h2>
    <p><?php echo isset($message) ? $message : ''; ?></p>
    <form method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
</body>
</html>

