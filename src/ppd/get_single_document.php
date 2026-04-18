<?php
require_once 'db.php'; // or conn.php - use your connection file

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['error' => 'invalid id']);
    exit;
}

$sql = "SELECT stud_id8, stud_no, req, dat, subject, con, `type`, remarks, rel, file, inputBy FROM documents WHERE stud_id8 = $id LIMIT 1";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);

if ($row) {
    // ensure date format and any other normalization match your DataTable expectations
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'not found']);
}
