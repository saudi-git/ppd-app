<?php
require_once 'db.php';
header('Content-Type: application/json');

if (!isset($_POST['stud_id8'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit;
}

$id = mysqli_real_escape_string($conn, $_POST['stud_id8']);
$req = mysqli_real_escape_string($conn, $_POST['req']);
$dat = mysqli_real_escape_string($conn, $_POST['dat']);
$stud_no = mysqli_real_escape_string($conn, $_POST['stud_no']);
$subject = mysqli_real_escape_string($conn, $_POST['subject']);
$con = mysqli_real_escape_string($conn, $_POST['con']);
$type = mysqli_real_escape_string($conn, $_POST['type']);
$remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
$rel = mysqli_real_escape_string($conn, $_POST['rel']);
$inputBy = mysqli_real_escape_string($conn, $_POST['inputBy']);

/* ===============================
   DATE VALIDATION
=============================== */
if (!empty($dat)) {
    if (!strtotime($dat)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid date format']);
        exit;
    }
    $dat = date('Y-m-d', strtotime($dat));
}

$update_file = "";

/* ===============================
   FILE UPLOAD HANDLING
=============================== */
if (!empty($_FILES['file']['name'])) {

    // ✅ CANCEL / FAILED UPLOAD CHECK
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'Upload cancelled or failed']);
        exit;
    }

    include "common_directory.php";

    // Get old file
    $query = mysqli_query($conn, "SELECT file FROM documents WHERE stud_id8 = '$id'");
    $row = mysqli_fetch_assoc($query);
    $oldFile = $row['file'] ?? '';

    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'xlsx', 'txt', 'mp4'];

    if (!in_array($fileExtension, $allowed)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid file type. Allowed: ' . implode(", ", $allowed)
        ]);
        exit;
    }

    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true);
    }

    $newFileName = uniqid("doc_", true) . "." . $fileExtension;
    $dest_path = $uploadFileDir . $newFileName;

    if (!move_uploaded_file($fileTmpPath, $dest_path)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'There was an error moving the uploaded file.'
        ]);
        exit;
    }

    // Delete old file
    if (!empty($oldFile) && file_exists($uploadFileDir . $oldFile)) {
        unlink($uploadFileDir . $oldFile);
    }

    $update_file = ", file = '$newFileName'";
}

/* ===============================
   UPDATE QUERY
=============================== */
$sql = "UPDATE documents SET
            stud_no = '$stud_no',
            req = '$req',
            dat = '$dat',
            subject = '$subject',
            con = '$con',
            type = '$type',
            remarks = '$remarks',
            rel = '$rel',
            inputBy = '$inputBy'
            $update_file
        WHERE stud_id8 = '$id'";

if (mysqli_query($conn, $sql)) {

    // AJAX vs normal submit
    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
    ) {

        echo json_encode([
            'status' => 'success',
            'message' => 'Record updated successfully.'
        ]);
    } else {
        header('Location: indexdocs_cside.php');
    }
    exit;
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error updating data: ' . mysqli_error($conn)
    ]);
    exit;
}
