<?php
require_once('../Connection/Connection.php');

$database = new Database();

$connection = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $registrationTo = $_POST['registration_to'];

    $statement = $connection->prepare("UPDATE registrations SET registration_to = :registration_to WHERE id = :id");
    $statement->bindParam(':registration_to', $registrationTo);
    $statement->bindParam(':id', $id);
    $statement->execute();

    header("Location: admin_panel.php");
    exit();
} else {
    $id = $_GET['id'];

    $statement = $connection->prepare("SELECT * FROM registrations WHERE id = :id");
    $statement->bindParam(':id', $id);
    $statement->execute();
    $registration = $statement->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Registration</title>
</head>
<body>
    <h2>Edit Registration</h2>
    <form method="POST" action="edit.php">
        <input type="hidden" name="id" value="<?php echo $registration['id']; ?>">
        <label for="registration_to">Registration To:</label>
        <input type="date" name="registration_to" value="<?php echo $registration['registration_to']; ?>" required>
        <input type="submit" value="Update">
    </form>
</body>
</html>
