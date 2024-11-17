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

$filters = [];
$sql = "SELECT * FROM employees WHERE 1";

if (isset($_GET['country']) && $_GET['country'] !== '')
{
    $country = $conn->real_escape_string($_GET['country']);
    $sql .= " AND Country = '$country'";
}

if (isset($_GET['city']) && $_GET['city'] !== '')
{
    $city = $conn->real_escape_string($_GET['city']);
    $sql .= " AND City = '$city'";
}

$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'Salary';
$sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'asc';
$sql .= " ORDER BY $sortBy $sortOrder";

$result = $conn->query($sql);

while($row = $result->fetch_assoc())
{
    echo "<tr>
            <td>" . htmlspecialchars($row['Name']) . "</td>
            <td>" . htmlspecialchars($row['Surname']) . "</td>
            <td>" . htmlspecialchars($row['Country']) . "</td>
            <td>" . htmlspecialchars($row['City']) . "</td>
            <td>" . htmlspecialchars($row['Salary']) . "</td>
          </tr>";
}

$conn->close();
?>
