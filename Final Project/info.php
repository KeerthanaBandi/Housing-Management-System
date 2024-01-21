
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

// get selected property name from previous screen
$property_name = urldecode($_GET['property_name']);

function readApartments($conn, $property_name, $bedrooms = null) {
    $sql = "SELECT HouseType, PropertyAddress, Bedrooms, Bathrooms, SqFt, Rent, AdditionalDetails, BalconyOrPatio, COUNT(*) AS NumHousetypes FROM availableapartments WHERE PropertyName ='$property_name'";
    $conditions = array();
    if ($bedrooms) {
        $conditions[] = " Bedrooms = '$bedrooms'";
    }
    if (count($conditions) > 0) {
        $sql .= " AND" . implode(' AND', $conditions);
    }
    $sql .= " GROUP BY HouseType ORDER BY Bedrooms ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return false;
    }
}





// Handle Filter
if (isset($_POST['submit'])) {
    $bedrooms = $_POST['Bedrooms'];
    $availability_data = readApartments($conn, $property_name, $bedrooms);
} else {
    // Show all data initially
    $availability_data = readApartments($conn, $property_name);
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
    <style>
        body {
            background: url("bg2.jpeg");
            background-size: contain;
            background-repeat: repeat;
        }


        .container {
            margin-top: 50px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .card-title {
            margin-bottom: 20px;
            font-weight: bold;
        }

        .table {
            margin-top: 20px;
        }

        .table th,
        .table td {
            vertical-align: middle !important;
        }

        .table thead th {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .table tbody tr:hover {
            background-color: #ffc451;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0062cc;
            border-color: #0062cc;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Availability in <?php echo $property_name; ?></h3>
                <?php
                // Fetch the property address from the database
                $sql = "SELECT PropertyAddress, Amenities FROM availableapartments WHERE PropertyName = '$property_name' LIMIT 1";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $property_address = $row['PropertyAddress'];
                $amenities = $row['Amenities'];
                ?>
                <h6 class="card-title">Address: <?php echo $property_address; ?></h6>
                <h6 class="card-title">Amenities: <?php echo $amenities; ?></h6>
                <table class="table">
                    <thead>
                        <tr>
                            <th>House Type</th>
                            <th>Bedrooms</th>
                            <th>Bathrooms</th>
                            <th>SqFt</th>
                            <th>Rent</th>
                            <th>Additional Details</th>
                            <th>Balcony Or Patio</th>
                            <th>Number of Available Houses/Apartments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($availability_data !== false) {
                            while ($row = mysqli_fetch_assoc($availability_data)) { ?>
                                <tr>
                                    <td><?php echo $row['HouseType']; ?></td>
                                    <td><?php echo $row['Bedrooms']; ?></td>
                                    <td><?php echo $row['Bathrooms']; ?></td>
                                    <td><?php echo $row['SqFt']; ?></td>
                                    <td><?php echo $row['Rent']; ?></td>
                                    <td><?php echo $row['AdditionalDetails']; ?></td>
                                    <td><?php echo $row['BalconyOrPatio']; ?></td>
                                    <td><?php echo $row['NumHousetypes']; ?></td>
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
		</div>
	</div>
    

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
















