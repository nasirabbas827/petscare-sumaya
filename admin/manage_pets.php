<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

$message = '';

// Delete pet
if (isset($_POST["delete_pet"])) {
    $delete_pet_id = $_POST["delete_pet"];
    $delete_query = "DELETE FROM Pets WHERE id = $delete_pet_id";

    if ($conn->query($delete_query)) {
        $message = "Pet deleted successfully.";
    } else {
        $message = "Error deleting pet: " . $conn->error;
    }
}

$query = "SELECT Pets.*, Users.username AS seller_name FROM Pets
          INNER JOIN Users ON Pets.seller_id = Users.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin View Pets</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('admin_navbar.php'); ?> 
<div class="container">
    <h2 class="mt-3">View Pets</h2>
    <p><?php echo $message; ?></p>
    <table class="table table-bordered">
        <tr>
            <th>Pet ID</th>
            <th>Picture</th>
            <th>Pet Name</th>
            <th>Gender</th>
            <th>City</th>
            <th>Price</th>
            <th>Seller Name</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><img src="../seller/<?php echo $row['pet_picture']; ?>" width="100" height="100" alt="Pet Picture"></td>
                <td><?php echo $row['pet_name']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['city']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['seller_name']; ?></td>
                <td>
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this pet?');">
                        <input type="hidden" name="delete_pet" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
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
