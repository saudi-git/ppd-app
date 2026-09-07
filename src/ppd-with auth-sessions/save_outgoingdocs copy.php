<?php
require_once 'db.php';

// Optional: Enable detailed errors during testing (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Securely get form inputs
    $stud_no = mysqli_real_escape_string($conn, $_POST['stud_no']);
    $req = mysqli_real_escape_string($conn, $_POST['req']);
    $dat = mysqli_real_escape_string($conn, $_POST['dat']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $con = mysqli_real_escape_string($conn, $_POST['con']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $rem3 = mysqli_real_escape_string($conn, $_POST['rem3']);
    $rel = mysqli_real_escape_string($conn, $_POST['rel']);
    $inputBy = mysqli_real_escape_string($conn, $_POST['inputBy']);

    // ✅ Store date in MySQL-compatible format (YYYY-MM-DD)
    $dat = date('Y-m-d', strtotime($dat));

    $fileNameToSave = ''; // Default if no file uploaded

    // ✅ File upload handling
    if (isset($_FILES['file3']) && $_FILES['file3']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file3']['tmp_name'];
        $fileName = $_FILES['file3']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Allowed extensions & MIME types
        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'xlsx', 'txt', 'mp4'];
        $allowedMimes = [
            'image/jpeg', 'image/png', 'application/pdf',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/plain', 'video/mp4'
        ];

        // Check extension
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // ✅ Check MIME type (extra security)
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $fileTmpPath);
            finfo_close($finfo);

            if (in_array($mime, $allowedMimes)) {
                include "common_directory.php"; // contains $uploadFileDir

                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0755, true);
                }

                // Generate unique filename
                $newFileName = uniqid('file_', true) . '.' . $fileExtension;
                $dest_path = $uploadFileDir . $newFileName;

                // Move file to upload directory
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $fileNameToSave = $newFileName;
                } else {
                    echo "<script>alert('Error moving uploaded file.');</script>";
                }
            } else {
                echo "<script>alert('Invalid file type detected.');</script>";
            }
        } else {
            echo "<script>alert('Upload failed. Allowed types: " . implode(", ", $allowedfileExtensions) . "');</script>";
        }
    }

    // ✅ Insert record into database
    $sql = "INSERT INTO `documents`
            (`stud_no`, `req`, `dat`, `subject`, `con`, `type`, `remarks`, `rem3`, `rel`, `inputBy`, `file3`)
            VALUES
            ('$stud_no', '$req', '$dat', '$subject', '$con', '$type', '$remarks', '$rem3', '$rel', '$inputBy', '$fileNameToSave')";

    if (mysqli_query($conn, $sql)) {
        header("Location: outgoingdocs.php");
        exit();
    } else {
        echo "<script>alert('Error saving data: " . mysqli_error($conn) . "');</script>";
    }
}
?>
