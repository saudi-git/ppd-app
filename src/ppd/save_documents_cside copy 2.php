<?php
require_once 'db.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Required fields
    $stud_no = mysqli_real_escape_string($conn, $_POST['stud_no'] ?? '');
    $req = mysqli_real_escape_string($conn, $_POST['req'] ?? '');
    $dat = mysqli_real_escape_string($conn, $_POST['dat'] ?? '');
    $subject = mysqli_real_escape_string($conn, $_POST['subject'] ?? '');
    $con = mysqli_real_escape_string($conn, $_POST['con'] ?? '');
    $type = mysqli_real_escape_string($conn, $_POST['type'] ?? '');
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks'] ?? '');
    $rel = mysqli_real_escape_string($conn, $_POST['rel'] ?? '');
    $inputBy = mysqli_real_escape_string($conn, $_POST['inputBy'] ?? '');

    // Format date
    if (!empty($dat)) {
        $dat = date('Y-m-d', strtotime($dat));
    }

    // Default empty file name
    $fileNameToSave = "";

    // If file is uploaded
    if (!empty($_FILES['file']['name'])) {

        include "common_directory.php"; // must contain: $uploadFileDir = "/path/";

        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        $allowed = ['pdf', 'jpg', 'jpeg', 'png', 'docx', 'xlsx', 'txt', 'mp4'];

        if (!in_array($ext, $allowed)) {
            echo json_encode(["status" => "error", "message" => "Invalid file type"]);
            exit;
        }

        $fileNameToSave = uniqid("doc_", true) . "." . $ext;
        $target = $uploadFileDir . $fileNameToSave;

        if (!move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
            echo json_encode(["status" => "error", "message" => "Failed to upload file"]);
            exit;
        }
    }

    // INSERT
    $sql = "INSERT INTO documents 
            (stud_no, req, dat, subject, con, type, remarks, rel, inputBy, file, file2, file3, rem2, rem3)
                VALUES 
            ('$stud_no', '$req', '$dat', '$subject', '$con', '$type', '$remarks', '$rel', '$inputBy', '$fileNameToSave', '', '', '', '')";


    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Docs added successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }

    exit();
}
