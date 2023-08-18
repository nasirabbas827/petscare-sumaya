<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

$query = "SELECT Appointments.*, Users.username AS user_name, Doctors.username AS doctor_name
          FROM Appointments
          INNER JOIN Users ON Appointments.user_id = Users.id
          INNER JOIN Users AS Doctors ON Appointments.doctor_id = Doctors.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin View Appointments</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('admin_navbar.php'); ?> 
<div class="container">
    <h2 class="mt-3">View Appointments</h2>
    <table class="table table-bordered">
        <tr>
            <th>Appointment ID</th>
            <th>User Name</th>
            <th>Doctor Name</th>
            <th>Reason</th>
            <th>Pet Name</th>
            <th>City</th>
            <th>Address</th>
            <th>Date</th>
            <th>Time</th>
            <th>Payment Method</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo $row['doctor_name']; ?></td>
                <td><?php echo $row['reason']; ?></td>
                <td><?php echo $row['pet_name']; ?></td>
                <td><?php echo $row['city']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['appointment_date']; ?></td>
                <td><?php echo $row['appointment_time']; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><?php echo $row['status']; ?></td>
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
