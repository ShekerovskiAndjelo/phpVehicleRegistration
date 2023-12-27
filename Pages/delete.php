<?php
require_once('../Connection/Connection.php');

$database = new Database();

$connection = $database->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $statement = $connection->prepare("DELETE FROM registrations WHERE id = :id");
    $statement->bindParam(':id', $id);
    $statement->execute();

    header("Location: admin_panel.php");
    exit();
}
?>
