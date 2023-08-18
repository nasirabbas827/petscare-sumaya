<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Seller') {
    header("Location: ../index.php");
    exit();
}

$seller_id = $_SESSION['user_id'];
$message = '';

// Delete pet
if (isset($_POST["delete_pet"])) {
    $delete_pet_id = $_POST["delete_pet"];
    $delete_query = "DELETE FROM Pets WHERE id = $delete_pet_id AND seller_id = $seller_id";

    if ($conn->query($delete_query)) {
        $message = "Pet deleted successfully.";
    } else {
        $message = "Error deleting pet: " . $conn->error;
    }
}

// Fetch seller's pets
$query = "SELECT * FROM Pets WHERE seller_id = $seller_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Manage Pets</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('navbar.php'); ?> 
<div class="container mt-4">
    <h2>Manage Your Pets</h2>
    <p><?php echo $message; ?></p>
    <table class="table">
        <thead>
            <tr>
                <th>Pet ID</th>
                <th>Pet Name</th>
                <th>Gender</th>
                <th>City</th>
                <th>Price</th>
                <th>Picture</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['pet_name']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['city']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><img src="<?php echo $row['pet_picture']; ?>" width="100" height="100" alt="Pet Picture"></td>
                    <td><a href="edit_pet.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this pet?');">
                            <input type="hidden" name="delete_pet" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<!-- Include Bootstrap JS script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

