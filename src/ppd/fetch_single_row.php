<?php
require_once 'db.php';

header('Content-Type: application/json');

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

if (!$id) {
    echo json_encode(["success" => false, "message" => "ID not provided"]);
    exit;
}

$query = $conn->query("SELECT * FROM documents WHERE stud_id8 = '$id'");

if ($query && $row = $query->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["success" => false, "message" => "Not found"]);
}
?>
