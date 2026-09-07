<?php
include 'db.php';

// SQL query to fetch data
$sql = "SELECT deo, stud_no,stud_id5, proj_name, municipality, barangay, sitio, scale, cost, proponent, position,dat, remarks, attachment, forwarded, stat FROM unfunded ";
$result = $conn->query($sql);

// Fetch data and prepare JSON
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // $row['cost'] = '₱ ' . number_format(isset($row['cost']) && is_numeric($row['cost']) ? (float)$row['cost'] : 0, 2);
        $data[] = $row;
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($data);

// Close connection
$conn->close();
