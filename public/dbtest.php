<?php

/**
 * Database connection data
 */
$host = "localhost";
$db_name = "mvc";
$user = "root";
$password = "root";

/**
 * Create a connection
 */
$conn = new mysqli($host, $user, $password, $db_name);

/**
 * Check the connection
 */
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
} else {
    echo "Connected successfully, connection data is ok.";
}
