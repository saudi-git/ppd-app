<?php
require_once 'db.php';
header('Content-Type: application/json');

// Ensure request is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

// ✅ Collect and sanitize inputs
$deo = mysqli_real_escape_string($conn, $_POST['deo'] ?? '');
$proj_name = mysqli_real_escape_string($conn, $_POST['proj_name'] ?? '');
$municipality = mysqli_real_escape_string($conn, $_POST['municipality'] ?? '');
$barangay = mysqli_real_escape_string($conn, $_POST['barangay'] ?? '');
$sitio = mysqli_real_escape_string($conn, $_POST['sitio'] ?? '');
$scale = mysqli_real_escape_string($conn, $_POST['scale'] ?? '');
$cost = mysqli_real_escape_string($conn, $_POST['cost'] ?? '');
$proponent = mysqli_real_escape_string($conn, $_POST['proponent'] ?? '');
$position = mysqli_real_escape_string($conn, $_POST['position'] ?? '');
$dat = mysqli_real_escape_string($conn, $_POST['dat'] ?? '');
$remarks = mysqli_real_escape_string($conn, $_POST['remarks'] ?? '');
$attachment = mysqli_real_escape_string($conn, $_POST['attachment'] ?? '');
$forwarded = mysqli_real_escape_string($conn, $_POST['forwarded'] ?? '');
$stat = mysqli_real_escape_string($conn, $_POST['stat'] ?? '');

// ✅ Validate required fields
if (empty($deo) || empty($proj_name)) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill out all required fields.']);
    exit();
}

// ✅ Store date in MySQL format (YYYY-MM-DD)
$dat = !empty($dat) ? date('Y-m-d', strtotime($dat)) : null;

// ✅ SQL Insert
$sql = "INSERT INTO unfunded 
        (deo, proj_name, municipality, barangay, sitio, scale, cost, proponent, position, dat, remarks, attachment, forwarded, stat)
        VALUES 
        ('$deo', '$proj_name', '$municipality', '$barangay', '$sitio', '$scale', '$cost', '$proponent', '$position', 
        " . ($dat ? "'$dat'" : "NULL") . ", 
        '$remarks', '$attachment', '$forwarded', '$stat')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => 'success', 'message' => 'Added successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error saving: ' . mysqli_error($conn)]);
}

exit();
?>
