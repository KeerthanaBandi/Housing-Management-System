
<?php
session_start();

// Database credentials
$host = "localhost";
$user = "root";
$password = "";
$database = "EliteHMS";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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


function readApartments($conn, $propertyName = null, $houseType = null, $availability = null) {
    $sql = "SELECT 
                Availability.ID,
                Property.PropertyName, 
                Property.PropertyAddress, 
                Property.Amenities, 
                HouseType.HouseType, 
                HouseType.Bedrooms, 
                HouseType.Bathrooms, 
                HouseType.SqFt, 
                HouseType.Rent, 
                HouseType.Images, 
                HouseType.AdditionalDetails, 
                HouseType.BalconyOrPatio,
                Availability.Availability
            FROM 
                Property
                INNER JOIN Availability ON Property.PropertyName = Availability.PropertyName
                INNER JOIN HouseType ON Availability.HouseType = HouseType.HouseType";
    $conditions = array();
    if ($propertyName) {
        $conditions[] = " Property.PropertyName = '$propertyName'";
    }
    if ($houseType) {
        $conditions[] = " HouseType.HouseType = '$houseType'";
    }
    if ($availability) {
        $conditions[] = " Availability.Availability = '$availability'";
    }
    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    $sql .= " ORDER BY Availability.ID, Property.PropertyName, HouseType.HouseType ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return false;
    }
}





// Handle Filter
if (isset($_POST['submit'])) {
    $propertyName = $_POST['PropertyName'];
    $houseType = $_POST['HouseType'];
    $availability = $_POST['Availability'];
    $availability_data = readApartments($conn, $propertyName, $houseType, $availability);
} else {
    // Show all data initially
    $availability_data = readApartments($conn);
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
                    <li class="nav-item" >
                    <form method="POST" action="" class="green-btn align-right" >
                        <input type="submit" name="logout" value="Logout" class="btn btn-primary logout-button">
                    </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">

<!-- Add a form to create a new availability entry -->
<div class="card my-4">
    <div class="card-body">
        <h3 class="card-title">Check Apartments</h3>
        <form method="POST" action="">
            <div class="form-group">
                <label for="property_name">Property Name</label>
                <select name="PropertyName" class="form-control">
                    <option value="">Select a Property</option>
                    <?php
                    $sql = "SELECT PropertyName FROM property";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row['PropertyName']; ?>"><?php echo $row['PropertyName']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="house_type">House Type</label>
                <select name="HouseType" class="form-control" >
                    <option value="">Select a House Type</option>
                    <?php
                    $sql = "SELECT HouseType FROM housetype";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row['HouseType']; ?>"><?php echo $row['HouseType']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="availability">Availability</label>
                <select name="Availability" class="form-control" >
                    <option value="" disabled selected>Select availability</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

            <input type="submit" name="submit" value="Go" class="btn btn-primary mt-2">
        </form>
    </div>
</div>




    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Availability</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Property Name</th>
                        <th>Property Address</th>
                        <th>Amenities</th>
                        <th>House Type</th>
                        <th>Bedrooms</th>
                        <th>Bathrooms</th>
                        <th>SqFt</th>
                        <th>Rent</th>
                        <th>Additional Details</th>
                        <th>Balcony or Patio</th>
                        <th>Availability</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    if ($availability_data !== false) {
        while ($row = mysqli_fetch_assoc($availability_data)) { ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['PropertyName']; ?></td>
                <td><?php echo $row['PropertyAddress']; ?></td>
                <td><?php echo $row['Amenities']; ?></td>
                <td><?php echo $row['HouseType']; ?></td>
                <td><?php echo $row['Bedrooms']; ?></td>
                <td><?php echo $row['Bathrooms']; ?></td>
                <td><?php echo $row['SqFt']; ?></td>
                <td><?php echo $row['Rent']; ?></td>
                <td><?php echo $row['AdditionalDetails']; ?></td>
                <td><?php echo $row['BalconyOrPatio']; ?></td>
                <td><?php echo $row['Availability']; ?></td>
            </tr>
        <?php }
    } else {
        echo "<tr><td colspan='12'>No data found</td></tr>";
    }
    ?>
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
















