<?php

require_once('../Connection/Connection.php');


$adminUsers = [
    ['username' => 'admin1', 'password' => password_hash('password1', PASSWORD_DEFAULT)],
    ['username' => 'admin2', 'password' => password_hash('password2', PASSWORD_DEFAULT)],
    
];

foreach ($adminUsers as $adminUser) {
    $username = $adminUser['username'];
    $password = $adminUser['password'];

    $database = new Database();

    $connection = $database->getConnection();

    $statement = $connection->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $statement->bindParam(':username', $username);
    $statement->bindParam(':password', $password);
    $statement->execute();
}



?>