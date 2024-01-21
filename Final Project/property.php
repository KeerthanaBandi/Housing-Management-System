
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
function createProperty($conn, $propertyName, $propertyAddress, $amenities) {
    $sql = "INSERT INTO Property (PropertyName, PropertyAddress, Amenities) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $propertyName, $propertyAddress, $amenities);
        $stmt->execute();
        $stmt->close();
        return true;
    } else {
        return false;
    }
}

function readProperty($conn) {
    $sql = "SELECT PropertyName, PropertyAddress, Amenities FROM Property";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result;
    } else {
        return false;
    }
}

function updateProperty($conn, $oldPropertyName, $propertyName, $propertyAddress, $amenities) {
    $sql = "UPDATE Property SET PropertyName=?, PropertyAddress=?, Amenities=? WHERE PropertyName=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $propertyName, $propertyAddress, $amenities, $oldPropertyName);
        $stmt->execute();
        $stmt->close();
        return true;
    } else {
        return false;
    }
}


function deleteProperty($conn, $propertyName) {
    $sql = "DELETE FROM Property WHERE propertyName=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $propertyName);
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
    $propertyAddress = $_POST['PropertyAddress'];
    $amenities = $_POST['Amenities'];
    createProperty($conn, $propertyName, $propertyAddress, $amenities);
    header("Location: property.php");
    exit();
}

// Handle update operation
if (isset($_POST['update'])) {
    $propertyName = $_POST['PropertyName'];
    $propertyAddress = $_POST['PropertyAddress'];
    $amenities = $_POST['Amenities'];
    $oldPropertyName = $_POST['oldPropertyName']; // new line

    updateProperty($conn, $oldPropertyName, $propertyName, $propertyAddress, $amenities); // modified line
    header("Location: property.php");
    exit();
}

// Handle delete operation
if (isset($_GET['delete'])) {
    $propertyName = $_GET['delete'];
    deleteProperty($conn, $propertyName);
    header("Location: property.php");
    exit();
}

// Handle edit operation
$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $propertyName = $_GET['edit'];

    $sql = "SELECT * FROM Property WHERE PropertyName=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $propertyName);
    $stmt->execute();
    $result = $stmt->get_result();
    $property_to_edit = $result->fetch_assoc();
}
    
// Handle logout operation
if (isset($_POST['logout'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
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
                            <a class="nav-link" href="dashboard1.php">Apartments</a>
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
                            <input type="hidden" name="csrf_token" value="<?php echo isset($_SESSION['csrf_token']) ? htmlentities($_SESSION['csrf_token']) : ''; ?>">
                            <input type="submit" name="logout" value="Logout" class="btn btn-primary logout-button">
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <div class="container mt-4">

<!-- Add a form to create a new property entry -->
<div class="card my-4">
        <div class="card-body">
            <h3 class="card-title">Add / Edit Property</h3>
            <form method="POST" action="">
                <?php if ($edit) { ?>
                    <input type="hidden" name="oldPropertyName" value="<?php echo $propertyName ?>">
                    <input type="text" name="PropertyName" placeholder="Property Name" value="<?php echo $property_to_edit['PropertyName']; ?>" required class="form-control">
                    <input type="text" name="PropertyAddress" placeholder="Property Address" value="<?php echo $edit ? $property_to_edit['PropertyAddress'] : ''; ?>" required class="form-control mt-2">
                    <input type="text" name="Amenities" placeholder="Amenities" value="<?php echo $property_to_edit['Amenities']; ?>" required class="form-control mt-2">
                <?php } else { ?>
                    <input type="text" name="PropertyName" placeholder="Property Name" value="" required class="form-control">
                    <input type="text" name="PropertyAddress" placeholder="Property Address" value="" required class="form-control mt-2">
                    <input type="text" name="Amenities" placeholder="Amenities" value="" required class="form-control mt-2">
                <?php } ?>
                <input type="submit" name="<?php echo $edit ? 'update' : 'submit'; ?>" value="<?php echo $edit ? 'Update' : 'Add'; ?>" class="btn btn-primary mt-2 update">
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <h3 class="card-title">All Properties</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Property Name</th>
                        <th>Property Address</th>
                        <th>Amenities</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $property_data = readProperty($conn);
                    while ($row = mysqli_fetch_assoc($property_data)) { ?>
                        <tr>
                        <td><?php echo $row['PropertyName']; ?></td>
                        <td><?php echo $row['PropertyAddress']; ?></td>
                        <td><?php echo $row['Amenities']; ?></td>
                        <td>
<a href="property.php?edit=<?php echo $row['PropertyName']; ?>" class="btn btn-warning">Edit</a>
<a href="property.php?delete=<?php echo $row['PropertyName']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
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

















