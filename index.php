<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Pet Clinic</title>
    <!-- Add Bootstrap CDN link here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
.jumbotron {
            height: 500px;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('./image/dog.jpg');
            background-size: cover;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .jumbotron h1 {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .jumbotron p {
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
<?php
    include('navbar.php');
    include('config.php');

    $petsQuery = "SELECT Pets.*, Users.username AS seller_name FROM Pets
                  INNER JOIN Users ON Pets.seller_id = Users.id";
    $petsResult = $conn->query($petsQuery);

    $doctorsQuery = "SELECT * FROM Users WHERE user_role = 'doctor'";
    $doctorsResult = $conn->query($doctorsQuery);
?>

<div class="jumbotron text-center">
    <h1>Welcome to Pet Clinic</h1>
    <p>Your One-Stop Destination for Pets and Veterinary Services</p>
    <a href="login.php" class="btn btn-primary btn-lg">Login to Buy</a>
</div>

<div class="container">
    <h2>Available Pets</h2>
    <div class="row">
        <?php while ($row = $petsResult->fetch_assoc()) { ?>
            <div class="col-md-4 mb-4">
                <div class="card mt-3">
                    <img src="./seller/<?php echo $row['pet_picture']; ?>" class="card-img-top" alt="Pet Picture" style="height: 200px;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['pet_name']; ?></h5>
                        <p class="card-text">Gender: <?php echo $row['gender']; ?></p>
                        <p class="card-text">City: <?php echo $row['city']; ?></p>
                        <p class="card-text">Price: $<?php echo $row['price']; ?></p>
                        <p class="card-text">Seller: <?php echo $row['seller_name']; ?></p>
                        <a href="login.php" class="btn btn-primary">Buy</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <h2>Our Dedicated Doctors</h2>
    <div class="row">
        <?php while ($row = $doctorsResult->fetch_assoc()) { ?>
            <div class="col-md-4 mb-4">
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['username']; ?></h5>
                        <p class="card-text">City: <?php echo $row['city']; ?></p>
                        <a href="login.php" class="btn btn-primary">Schedule Appointment</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<footer class="bg-dark text-white text-center py-3">
    &copy; <?php echo date("Y"); ?> Pet Clinic. All rights reserved.
</footer>
</body>
</html>
