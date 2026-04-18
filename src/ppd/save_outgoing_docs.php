<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get text inputs safely
    $stud_no = mysqli_real_escape_string($conn, $_POST['stud_no']);
    $req = mysqli_real_escape_string($conn, $_POST['req']);
    $dat = mysqli_real_escape_string($conn, $_POST['dat']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $con = mysqli_real_escape_string($conn, $_POST['con']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $rel = mysqli_real_escape_string($conn, $_POST['rel']);

    // Store date in YYYY-MM-DD (SQL standard)
    $dat = date('M-d-Y', strtotime($dat));

    $fileNameToSave = ''; // Default for first file
    $file2NameToSave = ''; // Default for second file

    // ===== File 1 =====
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'xlsx', 'txt', 'mp4'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // $uploadFileDir = "uploads/"; 
            include "common_directory.php";

            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            $newFileName = uniqid() . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $fileNameToSave = $newFileName;
            } else {
                echo "<script>alert('Error moving first uploaded file.');</script>";
            }
        } else {
            echo "<script>alert('Upload failed for first file. Allowed types: " . implode(", ", $allowedfileExtensions) . "');</script>";
        }
    }

    // ===== File 2 =====
    if (isset($_FILES['file2']) && $_FILES['file2']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath2 = $_FILES['file2']['tmp_name'];
        $fileName2 = $_FILES['file2']['name'];
        $fileExtension2 = strtolower(pathinfo($fileName2, PATHINFO_EXTENSION));

        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'xlsx', 'txt', 'mp4'];

        // Different folder for file2 (optional)
        $uploadFileDir2 = "uploads2/"; 
        if (!is_dir($uploadFileDir2)) {
            mkdir($uploadFileDir2, 0755, true);
        }

        $newFileName2 = uniqid() . '.' . $fileExtension2;
        $dest_path2 = $uploadFileDir2 . $newFileName2;

        if (move_uploaded_file($fileTmpPath2, $dest_path2)) {
            $file2NameToSave = $newFileName2;
        } else {
            echo "<script>alert('Error moving second uploaded file.');</script>";
        }
    }

    // Save record in DB
    $sql = "INSERT INTO `documents` 
        (`stud_no`, `req`, `dat`, `subject`, `con`, `type`, `remarks`, `rel`, `file`, `file2`) 
        VALUES 
        ('$stud_no','$req','$dat','$subject','$con','$type','$remarks','$rel','$fileNameToSave','$file2NameToSave')";

    if (mysqli_query($conn, $sql)) {
        header("Location: indexdocs_outgoing.php"); 
        exit();
    } else {
        echo "<script>alert('Error saving data: " . mysqli_error($conn) . "');</script>";
    }
}
?>
