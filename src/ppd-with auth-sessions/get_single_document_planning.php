<?php
require_once 'db.php'; // or conn.php - use your connection file

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['error' => 'invalid id']);
    exit;
}

$sql = "SELECT stud_id4, stud_no, subject, date, con_agency, status, remarks, attachment, forwarded FROM planningsection WHERE stud_id4 = $id LIMIT 1";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);

if ($row) {
    // ensure date format and any other normalization match your DataTable expectations
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'not found']);
}
