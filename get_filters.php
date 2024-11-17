<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employees_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

$filters = [
    'countries' => [],
    'cities' => []
];

$result = $conn->query("SELECT DISTINCT Country FROM employees");
while($row = $result->fetch_assoc())
{
    $filters['countries'][] = $row['Country'];
}

$result = $conn->query("SELECT DISTINCT City FROM employees");
while($row = $result->fetch_assoc())
{
    $filters['cities'][] = $row['City'];
}

$conn->close();

echo json_encode($filters);
?>
