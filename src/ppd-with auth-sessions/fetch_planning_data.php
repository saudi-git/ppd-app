<?php
require_once 'db.php';

// Fetch data from the planningsection table
$query = "
    SELECT  
        stud_id4, 
        stud_no, 
        subject, 
        date, 
        con_agency, 
        status, 
        remarks, 
        attachment, 
        forwarded 
    FROM planningsection
";

$result = $conn->query($query);

$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return JSON response
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// Close DB connection
$conn->close();
