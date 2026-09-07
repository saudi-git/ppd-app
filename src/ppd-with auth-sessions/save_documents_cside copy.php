<?php
require_once 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('post_max_size', "50M");
ini_set('upload_max_filesize', "50M");

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect values
    $stud_no = $_POST['stud_no'] ?? '';
    $req = $_POST['req'] ?? '';
    $dat = $_POST['dat'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $con = $_POST['con'] ?? '';
    $type = $_POST['type'] ?? '';
    $remarks = $_POST['remarks'] ?? '';
    $rel = $_POST['rel'] ?? '';
    $inputBy = $_POST['inputBy'] ?? '';

    // Convert date
    if (!empty($dat)) {
        $dat = date('Y-m-d', strtotime($dat));
    }

    $fileNameToSave = '';

    // File upload
    if (!empty($_FILES['file']['name'])) {

        include "common_directory.php";

        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        $allowed = ['pdf','jpg','jpeg','png','docx','xlsx','txt','mp4'];

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

    // PREPARED STATEMENT
    $stmt = $conn->prepare("
        INSERT INTO documents 
        (stud_no, req, dat, subject, con, type, remarks, rel, file, inputBy)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "ssssssssss",
        $stud_no, $req, $dat, $subject,
        $con, $type, $remarks, $rel,
        $fileNameToSave, $inputBy
    );

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
