<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize input
    $stud_no = mysqli_real_escape_string($conn, $_POST['stud_no']);
    $req = mysqli_real_escape_string($conn, $_POST['req']);
    $dat = mysqli_real_escape_string($conn, $_POST['dat']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $con = mysqli_real_escape_string($conn, $_POST['con']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $rel = mysqli_real_escape_string($conn, $_POST['rel']);
    $inputBy = mysqli_real_escape_string($conn, $_POST['inputBy']);

    // Standardize date (YYYY-MM-DD)
    $dat = date('Y-m-d', strtotime($dat));

    $fileNameToSave = '';

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Allowed types
        $allowedfileExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'docx', 'xlsx', 'txt', 'mp4'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            include "common_directory.php";

            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            $newFileName = uniqid('doc_', true) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $fileNameToSave = $newFileName;
            } else {
                $response = ['status' => 'error', 'message' => 'Error moving uploaded file.'];
                echo json_encode($response);
                exit;
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Invalid file type.'];
            echo json_encode($response);
            exit;
        }
    }

    // Insert into database
    $sql = "INSERT INTO `documents` (`stud_no`, `req`, `dat`, `subject`, `con`, `type`, `remarks`, `rel`, `file`, `inputBy`) 
            VALUES ('$stud_no','$req','$dat','$subject','$con','$type','$remarks','$rel','$fileNameToSave','$inputBy')";

    if (mysqli_query($conn, $sql)) {
        // ✅ Detect if AJAX request
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['status' => 'success']);
        } else {
            header("Location: indexdocs_cside.php");
        }
    } else {
        $response = ['status' => 'error', 'message' => mysqli_error($conn)];
        echo json_encode($response);
    }
}
?>
