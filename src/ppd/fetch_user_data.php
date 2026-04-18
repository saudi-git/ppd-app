<?php
include 'db.php';

// SQL query to fetch data
$sql = "SELECT id, username, password, role, created_at,name
        FROM usersfunded";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Keep raw date for editing
        $row['created_at_raw'] = $row['created_at'];

        // Format date for display
        if (!empty($row['created_at']) && $row['created_at'] != "0000-00-00 00:00:00") {
            $row['created_at'] = date("F j, Y", strtotime($row['created_at'])); 
        } else {
            $row['created_at'] = "";
        }

        $data[] = $row;
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($data);

// Close connection
$conn->close();
