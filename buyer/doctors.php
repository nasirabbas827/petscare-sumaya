<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Buyer') {
    header("Location: ../index.php");
    exit();
}

$query = "SELECT * FROM Users WHERE user_role = 'Doctor'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buyer View Doctors</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('navbar.php'); ?> 
<div class="container mt-4">
    <h2>View Doctors</h2>
    <div class="row">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['username']; ?></h5>
                        <p class="card-text"><strong>Email:</strong> <?php echo $row['email']; ?></p>
                        <p class="card-text"><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
                        <p class="card-text"><strong>City:</strong> <?php echo $row['city']; ?></p>
                        <p class="card-text"><strong>Address:</strong> <?php echo $row['address']; ?></p>
                        <a href="schedule_appointment.php?doctor_id=<?php echo $row['id']; ?>" class="btn btn-primary">Schedule Appointment</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<!-- Include Bootstrap JS script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
