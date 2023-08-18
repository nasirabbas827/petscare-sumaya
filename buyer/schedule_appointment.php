<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Buyer') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];
    
    $query = "SELECT * FROM Users WHERE id = $doctor_id AND user_role = 'Doctor'";
    $result = $conn->query($query);
    
    if ($result->num_rows == 1) {
        $doctor = $result->fetch_assoc();
    } else {
        header("Location: seller_view_doctors.php");
        exit();
    }
} else {
    header("Location: seller_view_doctors.php");
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reason = $_POST['reason'];
    $pet_name = $_POST['pet_name'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $status = 'pending';
    $payment_method = 'Cash on Payment';
    
    $insert_query = "INSERT INTO Appointments (user_id, doctor_id, reason, pet_name, city, address, appointment_date, appointment_time, status, payment_method)
                     VALUES ($user_id, $doctor_id, '$reason', '$pet_name', '$city', '$address', '$appointment_date', '$appointment_time', '$status', '$payment_method')";
    
    if ($conn->query($insert_query)) {
        $message = "Appointment request sent successfully. Your request is pending for approval.";
    } else {
        $message = "Error sending appointment request: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Request Appointment</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('navbar.php'); ?> 
<div class="container mt-4 mb-5">
    <h2>Request Appointment</h2>
    <p><?php echo $message; ?></p>
    <h3>Doctor Information:</h3>
    <p><strong>Doctor Name:</strong> <?php echo $doctor['username']; ?></p>
    <p><strong>Email:</strong> <?php echo $doctor['email']; ?></p>
    <p><strong>Phone:</strong> <?php echo $doctor['phone']; ?></p>
    <p><strong>City:</strong> <?php echo $doctor['city']; ?></p>
    <p><strong>Address:</strong> <?php echo $doctor['address']; ?></p>

    <h3>Appointment Details:</h3>
    <form method="POST">
        <div class="form-group">
            <label for="reason">Reason for Consulting:</label>
            <textarea class="form-control" id="reason" name="reason" required></textarea>
        </div>
        <div class="form-group">
            <label for="pet_name">Pet Name:</label>
            <input type="text" class="form-control" id="pet_name" name="pet_name" required>
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
        </div>
        <div class="form-group">
            <label for="appointment_date">Appointment Date:</label>
            <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
        </div>
        <div class="form-group">
            <label for="appointment_time">Appointment Time:</label>
            <input type="time" class="form-control" id="appointment_time" name="appointment_time" required>
        </div>
        <button type="submit" class="btn btn-primary">Request Appointment</button>
    </form>
</div>
<!-- Include Bootstrap JS script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
