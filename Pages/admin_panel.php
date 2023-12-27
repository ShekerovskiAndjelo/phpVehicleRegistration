<?php
session_start();

require_once('../Connection/Connection.php');

$database = new Database();

$connection = $database->getConnection();

$statement = $connection->prepare("SELECT * FROM vehicle_models");
$statement->execute();
$vehicleModels = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $connection->prepare("SELECT * FROM vehicle_types");
$statement->execute();
$vehicleTypes = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $connection->prepare("SELECT * FROM fuel_types");
$statement->execute();
$fuelTypes = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicleModel = $_POST['vehicle_model'];
    $vehicleType = $_POST['vehicle_type'];
    $chassisNumber = $_POST['chassis_number'];
    $productionYear = $_POST['production_year'];
    $registrationNumber = $_POST['registration_number'];
    $fuelType = $_POST['fuel_type'];
    $registrationTo = $_POST['registration_to'];


    $statement = $connection->prepare("INSERT INTO registrations (vehicle_model_id, vehicle_type_id, chassis_number, production_year, registration_number, fuel_type_id, registration_to) VALUES (:vehicle_model_id, :vehicle_type_id, :chassis_number, :production_year, :registration_number, :fuel_type_id, :registration_to)");
    $statement->bindParam(':vehicle_model_id', $vehicleModel);
    $statement->bindParam(':vehicle_type_id', $vehicleType);
    $statement->bindParam(':chassis_number', $chassisNumber);
    $statement->bindParam(':production_year', $productionYear);
    $statement->bindParam(':registration_number', $registrationNumber);
    $statement->bindParam(':fuel_type_id', $fuelType);
    $statement->bindParam(':registration_to', $registrationTo);
    $statement->execute();
}

$statement = $connection->prepare("SELECT r.*, m.name AS vehicle_model, t.name AS vehicle_type, f.name AS fuel_type
                    FROM registrations AS r
                    INNER JOIN vehicle_models AS m ON r.vehicle_model_id = m.id
                    INNER JOIN vehicle_types AS t ON r.vehicle_type_id = t.id
                    INNER JOIN fuel_types AS f ON r.fuel_type_id = f.id");
$statement->execute();
$registeredVehicles = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- HTML form for vehicle registration -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Admin panel</title>
    <link rel="stylesheet" href="../Style/style.css">
    <style>
        .expired-row {
            text-decoration: none;
            background-color: red;
        }
        .expiring-row {
            text-decoration: none;
            background-color: orange;
        }
        .expired-action {
            color: red;
        }
        .expiring-action {
            color: orange;
        }
    </style>
</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="home_page.php">Vehicle registration</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>
                <a class="nav-link active" aria-current="page" href="home_page.php">Logout</a>

            </div>
        </div>
    </nav>


    <!-- link za import novi -->
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <a href="../Import/vehicle_model_form.php" class="btn btn-warning">Add new vehicles model</a>

            </div>
        </div>
    </div>

    <!-- form -->
    <div class="container">
        <div class="row">
            <div class="col">
                <form method="POST" action="admin_panel.php" class="mt-5">

                    <div class="row">
                        <div class="col">
                            <label for="vehicle_model" class="text-white">Vehicle Model:</label>
                            <select name="vehicle_model" class="form-select" required>
                                <?php foreach ($vehicleModels as $vehicleModel) : ?>
                                    <option value="<?php echo $vehicleModel['id']; ?>"><?php echo $vehicleModel['name']; ?></option>
                                <?php endforeach; ?>
                            </select><br>
                        </div>
                        <div class="col">
                            <label for="vehicle_type" class="text-white">Vehicle Type:</label>
                            <select name="vehicle_type" class="form-select" required>
                                <?php foreach ($vehicleTypes as $vehicleType) : ?>
                                    <option value="<?php echo $vehicleType['id']; ?>"><?php echo $vehicleType['name']; ?></option>
                                <?php endforeach; ?>
                            </select><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="chassis_number" class="text-white">Vehicle Chassis Number:</label>
                            <input type="text" name="chassis_number" class="form-control" required><br>
                        </div>
                        <div class="col">
                            <label for="production_year" class="text-white">Vehicle Production Year:</label>
                            <input type="date" name="production_year" class="form-control" required><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="registration_number" class="text-white">Registration Number:</label>
                            <input type="text" name="registration_number" class="form-control" required><br>
                        </div>
                        <div class="col">
                            <label for="fuel_type" class="text-white">Fuel Type:</label>
                            <select name="fuel_type" class="form-select" required>
                                <?php foreach ($fuelTypes as $fuelType) : ?>
                                    <option value="<?php echo $fuelType['id']; ?>"><?php echo $fuelType['name']; ?></option>
                                <?php endforeach; ?>
                            </select><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="registration_to" class="text-white">Registration To:</label>
                            <input type="date" name="registration_to" class="form-control" required><br>
                        </div>
                        <div class="col mt-4">
                            <button type="submit" class="btn btn-success" value="Register">Register</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Vehicle Model</th>
                            <th scope="col">Vehicle Type</th>
                            <th scope="col">Chassis Number</th>
                            <th scope="col">Production Year</th>
                            <th scope="col">Registration Number</th>
                            <th scope="col">Fuel Type</th>
                            <th scope="col">Registration To</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registeredVehicles as $vehicle) : ?>
                            <?php
                            $registrationToDate = strtotime($vehicle['registration_to']);
                            $currentDate = strtotime(date('Y-m-d'));
                            $daysRemaining = floor(($registrationToDate - $currentDate) / (60 * 60 * 24));
                            $rowClass = '';
                            $actionClass = '';

                            if ($daysRemaining < 0) {
                                $rowClass = 'expired-row';
                                $actionClass = 'expired-action';
                            } elseif ($daysRemaining <= 30) {
                                $rowClass = 'expiring-row';
                                $actionClass = 'expiring-action';
                            }
                            ?>
                            <tr class="<?php echo $rowClass; ?>">
                                <td><?php echo $vehicle['vehicle_model']; ?></td>
                                <td><?php echo $vehicle['vehicle_type']; ?></td>
                                <td><?php echo $vehicle['chassis_number']; ?></td>
                                <td><?php echo $vehicle['production_year']; ?></td>
                                <td><?php echo $vehicle['registration_number']; ?></td>
                                <td><?php echo $vehicle['fuel_type']; ?></td>
                                <td><?php echo $vehicle['registration_to']; ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $vehicle['id']; ?>" class="<?php echo $actionClass; ?>">Edit</a>
                                    <a href="delete.php?id=<?php echo $vehicle['id']; ?>" class="<?php echo $actionClass; ?>">Delete</a>
                                    <?php if ($rowClass == 'expired-row' || $rowClass == 'expiring-row') : ?>
                                        <a href="extend.php?id=<?php echo $vehicle['id']; ?>" class="<?php echo $actionClass; ?>">Extend</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>