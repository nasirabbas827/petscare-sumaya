<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $query = "SELECT * FROM Users WHERE id = $user_id";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        header("Location: manage_users.php");
        exit();
    }
} else {
    header("Location: manage_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>
<?php include('admin_navbar.php'); ?> 
<h2>User Profile</h2>
<table>
    <tr>
        <th>User ID</th>
        <td><?php echo $user['id']; ?></td>
    </tr>
    <tr>
        <th>Username</th>
        <td><?php echo $user['username']; ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?php echo $user['email']; ?></td>
    </tr>
    <tr>
        <th>Phone</th>
        <td><?php echo $user['phone']; ?></td>
    </tr>
    <tr>
        <th>Age</th>
        <td><?php echo $user['age']; ?></td>
    </tr>
    <tr>
        <th>City</th>
        <td><?php echo $user['city']; ?></td>
    </tr>
    <tr>
        <th>Address</th>
        <td><?php echo $user['address']; ?></td>
    </tr>
    <tr>
        <th>User Role</th>
        <td><?php echo $user['user_role']; ?></td>
    </tr>
    <tr>
        <th>Status</th>
        <td><?php echo $user['status']; ?></td>
    </tr>
</table>
</body>
</html>
