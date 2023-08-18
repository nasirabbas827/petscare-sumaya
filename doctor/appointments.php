<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Doctor') {
    header("Location: ../index.php");
    exit();
}

$doctor_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_id = $_POST['appointment_id'];
    $new_status = $_POST['status'];

    $update_query = "UPDATE Appointments SET status = '$new_status' WHERE id = $appointment_id";
    
    if ($conn->query($update_query)) {
        $message = "Appointment status updated successfully.";
    } else {
        $message = "Error updating appointment status: " . $conn->error;
    }
}


$query = "SELECT Appointments.*, Users.username AS user_name
          FROM Appointments
          INNER JOIN Users ON Appointments.user_id = Users.id
          WHERE Appointments.doctor_id = $doctor_id";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Appointments</title>
    <!-- Add Bootstrap CDN link here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('navbar.php'); ?> 
<div class="container">
    <h2>Doctor Appointments</h2>
    <table class="table">
        <tr>
            <th>Appointment ID</th>
            <th>User Name</th>
            <th>Reason</th>
            <th>Pet Name</th>
            <th>City</th>
            <th>Address</th>
            <th>Date</th>
            <th>Time</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo $row['reason']; ?></td>
                <td><?php echo $row['pet_name']; ?></td>
                <td><?php echo $row['city']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['appointment_date']; ?></td>
                <td><?php echo $row['appointment_time']; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td>
                    <select name="status" class="form-control">
                        <option value="pending" <?php if ($row['status'] === 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="approved" <?php if ($row['status'] === 'approved') echo 'selected'; ?>>Approved</option>
                        <option value="paid" <?php if ($row['status'] === 'paid') echo 'selected'; ?>>Paid</option>
                        <option value="checked" <?php if ($row['status'] === 'checked') echo 'selected'; ?>>Checked</option>
                        <option value="cancel" <?php if ($row['status'] === 'cancel') echo 'selected'; ?>>Cancel</option>
                    </select>
                </td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn btn-primary" name="update_status">Update</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
