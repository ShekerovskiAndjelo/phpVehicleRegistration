<?php
require_once('../Connection/connection.php');

$database = new Database();

$connection = $database->getConnection();

$modelName = $_POST['model_name'];


$statement = $connection->prepare("SELECT * FROM vehicle_models WHERE name = :model_name");
$statement->bindParam(':model_name', $modelName);
$statement->execute();
$modelExists = $statement->fetch();

if ($modelExists) {

  $errorExists = "Error: Vehicle model already exists.";
} else {

  $statement = $connection->prepare("INSERT INTO vehicle_models (name) VALUES (:model_name)");
  $statement->bindParam(':model_name', $modelName);
  $statement->execute();


  $added = "Vehicle model added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Style/style.css">
  <title>Import vehicle model</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="row mt-4">
        <div class="col rounded-4 bg-danger text-white text-center">
            <?php if (!empty($errorExists)) : ?>
                <p><?php echo $errorExists; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col rounded-4 bg-success text-white text-center">
            <?php if (!empty($added)) : ?>
                <p><?php echo $added; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container mt-5">
  <div class="row">
    <div class="col">
    <a href="../Import/vehicle_model_form.php" class="btn btn-primary">Back to import form</a>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>