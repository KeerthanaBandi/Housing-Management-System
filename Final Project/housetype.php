
<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Increase upload limit
ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '20M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);


// Rest of your PHP code...


// Database credentials
$host = "localhost";
$user = "root";
$password = "";
$database = "EliteHMS";

// Create a database connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

// CRUD functions
function createHouseType($conn, $houseType, $bedrooms, $bathrooms, $sqFt, $rent, $image, $additionalDetails, $balconyOrPatio) {
    $sql = "INSERT INTO HouseType (HouseType, Bedrooms, Bathrooms, SqFt, Rent, Images, AdditionalDetails, BalconyOrPatio) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("siiiibss", $houseType, $bedrooms, $bathrooms, $sqFt, $rent, $image, $additionalDetails, $balconyOrPatio);
        $stmt->execute();
        $stmt->close();
        return true;
    } else {
        return false;
    }
}





function readHouseType($conn) {
    $sql = "SELECT HouseType, Bedrooms, Bathrooms, SqFt, Rent, Images, AdditionalDetails, BalconyOrPatio FROM HouseType ORDER BY Bedrooms ASC, Bathrooms ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result;
    } else {
        return false;
    }
}

function updateHouseType($conn, $houseType, $bedrooms, $bathrooms, $sqFt, $rent, $images, $additionalDetails, $balconyOrPatio) {
    $sql = "UPDATE HouseType SET Bedrooms=?, Bathrooms=?, SqFt=?, Rent=?, Images=?, AdditionalDetails=?, BalconyOrPatio=? WHERE HouseType=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $image = file_get_contents($_FILES['Images']['tmp_name']);
        $stmt->bind_param("iiiibsss", $bedrooms, $bathrooms, $sqFt, $rent, $image, $additionalDetails, $balconyOrPatio, $houseType);
        $stmt->send_long_data(4, $image);
        $stmt->execute();
        $stmt->close();
        return true;
    } else {
        return false;
    }
}


function deleteHouseType($conn, $houseType) {
    $sql = "DELETE FROM HouseType WHERE HouseType=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $houseType);
        $stmt->execute();
        $stmt->close();
        return true;
    } else {
        return false;
    }
}

// Handle create operation
if (isset($_POST['submit'])) {
    $houseType = $_POST['HouseType'];
    $bedrooms = $_POST['Bedrooms'];
    $bathrooms = $_POST['Bathrooms'];
    $sqFt = $_POST['SqFt'];
    $rent = $_POST['Rent'];
    $image = file_get_contents($_FILES['Images']['tmp_name']);
    $additionalDetails = $_POST['AdditionalDetails'];
    $balconyOrPatio = $_POST['BalconyOrPatio'];
    createHouseType($conn, $houseType, $bedrooms, $bathrooms, $sqFt, $rent, $image, $additionalDetails, $balconyOrPatio);
    header("Location: housetype.php");
    exit();
}

// Handle update operation
if (isset($_POST['update'])) {
    $houseType = $_POST['HouseType'];
    $bedrooms = $_POST['Bedrooms'];
    $bathrooms = $_POST['Bathrooms'];
    $sqFt = $_POST['SqFt'];
    $rent = $_POST['Rent'];
    $images = $_POST['Images'];
    $additionalDetails = $_POST['AdditionalDetails'];
    $balconyOrPatio = $_POST['BalconyOrPatio'];

    updateHouseType($conn, $houseType, $bedrooms, $bathrooms, $sqFt, $rent, $images, $additionalDetails, $balconyOrPatio);
    header("Location: housetype.php");
    exit();
}

// Handle delete operation
if (isset($_GET['delete'])) {
    $houseType = $_GET['delete'];
    deleteHouseType($conn, $houseType);
    header("Location: housetype.php");
    exit();
}

// Handle edit operation
$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $houseType = $_GET['edit'];

    $sql = "SELECT * FROM HouseType WHERE HouseType=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $houseType);
    $stmt->execute();
    $result = $stmt->get_result();
    $houseType_to_edit = $result->fetch_assoc();
}
    
    // Handle logout
    if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
    }
    
    ?>
    
    <!DOCTYPE html>
    <html>
    <head>
        <title>Admin Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="buttons.css" rel="stylesheet">
    </head>
    <body>
    <div class="background">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">EliteHMS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Apartments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="housetype.php">House Types</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="property.php">Properties</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="allapartments.php">All Apartments</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="">
                                <input type="submit" name="logout" value="Logout" class="btn btn-primary logout-button">
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-4">

<!-- Add a form to create a new property entry -->
<!-- Add a form to create a new property entry -->
<div class="card my-4">
    <div class="card-body">
        <h3 class="card-title">Add / Edit HouseType</h3>
        <form method="POST" action="" enctype="multipart/form-data">
            <?php if ($edit) { ?>                   
                <input type="text" name="HouseType" placeholder="HouseType" value="<?php echo $houseType_to_edit['HouseType']; ?>" required class="form-control">
                <input type="int" name="Bedrooms" placeholder="Bedrooms" value="<?php echo $edit ? $houseType_to_edit['Bedrooms'] : ''; ?>" required class="form-control mt-2">
                <input type="int" name="Bathrooms" placeholder="Bathrooms" value="<?php echo $houseType_to_edit['Bathrooms']; ?>" required class="form-control mt-2">
                <input type="int" name="SqFt" placeholder="SqFt" value="<?php echo $houseType_to_edit['SqFt']; ?>" required class="form-control mt-2">
                <input type="int" name="Rent" placeholder="Rent" value="<?php echo $edit ? $houseType_to_edit['Rent'] : ''; ?>" required class="form-control mt-2">
                <input type="file" name="Images" placeholder="Images" class="form-control mt-2">
                <?php if ($houseType_to_edit['Images']) { ?>
                    <img src="data:image/jpeg;base64, <?php echo base64_encode($houseType_to_edit['Images']); ?>" alt="<?php echo $houseType_to_edit['HouseType']; ?>" width="100">
                <?php } ?>
                <input type="text" name="AdditionalDetails" placeholder="AdditionalDetails" value="<?php echo $edit ? $houseType_to_edit['AdditionalDetails'] : ''; ?>" required class="form-control mt-2">
                <input type="text" name="BalconyOrPatio" placeholder="BalconyOrPatio" value="<?php echo $houseType_to_edit['BalconyOrPatio']; ?>" required class="form-control mt-2">
            <?php } 
            else { ?>
                <input type="text" name="HouseType" placeholder="HouseType" value="" required class="form-control">
                <input type="int" name="Bedrooms" placeholder="Bedrooms" value="" required class="form-control mt-2">
                <input type="int" name="Bathrooms" placeholder="Bathrooms" value="" required class="form-control mt-2">
                <input type="int" name="SqFt" placeholder="SqFt" value="" required class="form-control mt-2">
                <input type="int" name="Rent" placeholder="Rent" value="" required class="form-control mt-2">
                <input type="file" name="Images" placeholder="Images" class="form-control mt-2">
                <input type="text" name="AdditionalDetails" placeholder="AdditionalDetails" value="" required class="form-control mt-2">
                <input type="text" name="BalconyOrPatio" placeholder="BalconyOrPatio" value="" required class="form-control mt-2">
            <?php } ?>
                <input type="submit" name="<?php echo $edit ? 'update' : 'submit'; ?>" value="<?php echo $edit ? 'Update' : 'Add'; ?>" class="btn btn-primary mt-2 update">
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <h3 class="card-title">All House types</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>HouseType</th>
                        <th>Bedrooms</th>
                        <th>Bathrooms</th>
                        <th>SqFt</th>
                        <th>Rent</th>
                        <th>Images</th>
                        <th>AdditionalDetails</th>
                        <th>BalconyOrPatio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $houseType_data = readHouseType($conn);
                    while ($row = mysqli_fetch_assoc($houseType_data)) { ?>
                        <tr>
                        <td><?php echo $row['HouseType']; ?></td>
                        <td><?php echo $row['Bedrooms']; ?></td>
                        <td><?php echo $row['Bathrooms']; ?></td>
                        <td><?php echo $row['SqFt']; ?></td>
                        <td><?php echo $row['Rent']; ?></td>
                        <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['Images']); ?>" alt="<?php echo $row['HouseType']; ?>" width="100"></td>
                        <td><?php echo $row['AdditionalDetails']; ?></td>
                        <td><?php echo $row['BalconyOrPatio']; ?></td>
                        <td>
<a href="housetype.php?edit=<?php echo $row['HouseType']; ?>" class="btn btn-warning">Edit</a>
<a href="housetype.php?delete=<?php echo $row['HouseType']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

















