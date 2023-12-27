<?php
require_once('../Connection/Connection.php');

$database = new Database();

$connection = $database->getConnection();

$vehicle = null;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registrationNumber = $_POST['registration_number'];

    $statement = $connection->prepare("SELECT * FROM registrations WHERE registration_number = :registration_number");
    $statement->bindParam(':registration_number', $registrationNumber);
    $statement->execute();
    $vehicle = $statement->fetch(PDO::FETCH_ASSOC);

    if ($vehicle === false) {
        $message = "Registration number not found.";
    } else {
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../Style/style.css">
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
                <a class="nav-link active" aria-current="page" href="admin_login.php">Login</a>

            </div>
        </div>
    </nav>

    <!-- center input -->

<div class="container">
    <div class="row mt-4">
        <div class="col rounded-4 bg-danger text-white text-center">
        <?php if (!empty($message)) : ?>
                    <p><?php echo $message; ?></p>
                <?php endif; ?>
        </div>
    </div>
</div>

    <div class="container">
        <div class="row mt-5">
            <div class="col bg-success rounded-4 p-4 text-white">
                <h1 class="text-center">Vehicle registration</h1>
                <form method="POST" action="home_page.php">
                    <div class="mb-3">
                        <label for="registration_number" class="form-label">Enter your registration number to check its validity</label>
                        <input type="text" class="form-control" name="registration_number" id="registration_number">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>



    <!-- table display IF || No such record -->
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <?php if (is_array($vehicle)) : ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Vehicle model</th>
                                <th scope="col">Vehicle type</th>
                                <th scope="col">Vehicle chassis number</th>
                                <th scope="col">Vehicle production year</th>
                                <th scope="col">Registration number</th>
                                <th scope="col">Fuel type</th>
                                <th scope="col">Registration to</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td><?php echo $vehicle['vehicle_model_id']; ?></td>
                                <td><?php echo $vehicle['vehicle_type_id']; ?></td>
                                <td><?php echo $vehicle['chassis_number']; ?></td>
                                <td><?php echo $vehicle['production_year']; ?></td>
                                <td><?php echo $vehicle['registration_number']; ?></td>
                                <td><?php echo $vehicle['fuel_type_id']; ?></td>
                                <td><?php echo $vehicle['registration_to']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>