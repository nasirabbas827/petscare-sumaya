<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT Appointments.*, Users.username AS doctor_name
          FROM Appointments
          INNER JOIN Users ON Appointments.doctor_id = Users.id
          WHERE Appointments.user_id = $user_id";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Appointments</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('navbar.php'); ?> 
<div class="container mt-4">
    <h2>View Appointments</h2>
    <table class="table">
        <tr>
            <th>Appointment ID</th>
            <th>Doctor Name</th>
            <th>Reason</th>
            <th>Pet Name</th>
            <th>City</th>
            <th>Address</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Payment Method</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['doctor_name']; ?></td>
                <td><?php echo $row['reason']; ?></td>
                <td><?php echo $row['pet_name']; ?></td>
                <td><?php echo $row['city']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['appointment_date']; ?></td>
                <td><?php echo $row['appointment_time']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
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
