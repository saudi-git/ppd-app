<?php
include 'db.php';

// SQL query to fetch data
$sql = "SELECT stud_id8, stud_no, dat, req, subject, con, type, remarks, rel, file, file2, file3, inputBy, rem2, rem3 
        FROM documents";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Keep raw date for editing
        $row['dat_raw'] = $row['dat'];

        // Format date for display
        if (!empty($row['dat']) && $row['dat'] != "0000-00-00") {
            $row['dat'] = date("F j, Y", strtotime($row['dat'])); // e.g. September 3, 2025
        } else {
            $row['dat'] = "";
        }

        $data[] = $row;
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($data);

// Close connection
$conn->close();
