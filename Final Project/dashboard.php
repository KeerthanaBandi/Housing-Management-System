
<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
function createAvailability($conn, $propertyName, $houseType, $availability) {
    $sql = "INSERT INTO availability (PropertyName, HouseType, Availability) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $propertyName, $houseType, $availability);
        $stmt->execute();
        $stmt->close();
        return true;
    } else {
        return false;
    }
}

function readAvailability($conn) {
    $sql = "SELECT id, PropertyName, HouseType, Availability FROM availability";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result;
    } else {
        return false;
    }
}

function updateAvailability($conn, $id, $propertyName, $houseType, $availability) {
    $sql = "UPDATE availability SET PropertyName=?, HouseType=?, Availability=? WHERE id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssi", $propertyName, $houseType, $availability, $id);
        $stmt->execute();
        $stmt->close();
        return true;
    } else {
        return false;
    }
}



function deleteAvailability($conn, $id) {
    $sql = "DELETE FROM availability WHERE id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        return true;
    } else {
        return false;
    }
}

// Handle create operation
if (isset($_POST['submit'])) {
    $propertyName = $_POST['PropertyName'];
    $houseType = $_POST['HouseType'];
    $availability = $_POST['Availability'];

    createAvailability($conn, $propertyName, $houseType, $availability);
    header("Location: dashboard.php");
    exit();
}

// Handle update operation
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $propertyName = $_POST['PropertyName'];
    $houseType = $_POST['HouseType'];
    $availability = $_POST['Availability'];

    updateAvailability($conn, $id, $propertyName, $houseType, $availability);
    header("Location: dashboard.php");
    exit();
}


// Handle delete operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    deleteAvailability($conn, $id);
    header("Location: dashboard.php");
    exit();
}

// Handle edit operation
$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];

    $sql = "SELECT * FROM availability WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $availability_to_edit = $result->fetch_assoc();
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
        <h3 class="card-title"><?php echo $edit ? 'Edit Availability' : 'Add Availability'; ?></h3>
        <form method="POST" action="">
            <?php if ($edit) { ?>
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="int" id="id" name="id" value="<?php echo $availability_to_edit['ID']; ?>" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="property_name">Property Name</label>
                    <input type="text" id="property_name" name="PropertyName" value="<?php echo $availability_to_edit['PropertyName']; ?>" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="house_type">House Type</label>
                    <input type="text" id="house_type" name="HouseType" value="<?php echo $availability_to_edit['HouseType']; ?>" class="form-control" readonly>
                </div>
            <?php } else { ?>
                <div class="form-group">
                    <label for="property_name">Property Name</label>
                    <select name="PropertyName" class="form-control" required>
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
                    <select name="HouseType" class="form-control" required>
                        <option value="">Select a House Type</option>
                        <?php
                        $sql = "SELECT HouseType FROM housetype";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <option value="<?php echo $row['HouseType']; ?>"><?php echo $row['HouseType']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <div class="form-group">
                <label for="availability">Availability</label>
                <select name="Availability" class="form-control" required>
                    <option value="" disabled selected>Select availability</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

            <input type="submit" name="<?php echo $edit ? 'update' : 'submit'; ?>" value="<?php echo $edit ? 'Update' : 'Add'; ?>" class="btn btn-primary mt-2 update">
        </form>
    </div>



    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Availability</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Property Name</th>
                        <th>House Type</th>
                        <th>Availability</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $availability_data = readAvailability($conn);
                    while ($row = mysqli_fetch_assoc($availability_data)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
<td><?php echo $row['PropertyName']; ?></td>
<td><?php echo $row['HouseType']; ?></td>
<td><?php echo $row['Availability']; ?></td>
<td>
<a href="dashboard.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
<a href="dashboard.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
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
















