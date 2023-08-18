<?php
include('config.php');

session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

if (isset($_POST["delete_user"])) {
    $delete_user_id = $_POST["delete_user"];
    $delete_query = "DELETE FROM Users WHERE id = $delete_user_id";

    if ($conn->query($delete_query)) {
        $message = "User deleted successfully.";
    } else {
        $message = "Error deleting user: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $new_status = $_POST['new_status'];

    $update_query = "UPDATE Users SET status = '$new_status' WHERE id = $user_id";
    
    if ($conn->query($update_query)) {
        $message = "User status updated successfully.";
    } else {
        $message = "Error updating user status: " . $conn->error;
    }
}

$query = "SELECT * FROM Users";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Update Status</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?> 
<div class="container">
    <h2 class="mt-3">Admin Update User Status</h2>
    <p><?php echo isset($message) ? $message : ''; ?></p>
    <table class="table table-bordered">
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Current Status</th>
            <th>New Status</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <select name="new_status" class="form-control">
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                    </form>
                </td>
                <td><a href="user_profile.php?id=<?php echo $row['id']; ?>" class="btn btn-info">View Profile</a></td>
                <td>
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        <input type="hidden" name="delete_user" value="<?php echo $row['id']; ?>">
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
