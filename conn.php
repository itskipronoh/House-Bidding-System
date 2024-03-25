<?php
$dbhost = 'localhost';
$dbname = 'hbs'; // Your PostgreSQL database name
$dbuser = 'postgres';
$dbpass = '1234';

try {
    // Establish a connection to the PostgreSQL database using PDO
    $conn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit(); // Stop executing the script if connection fails
}
?>

