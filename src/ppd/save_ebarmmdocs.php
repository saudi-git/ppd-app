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
    $rem2 = mysqli_real_escape_string($conn, $_POST['rem2']);
    $rel = mysqli_real_escape_string($conn, $_POST['rel']);

    // Store date in YYYY-MM-DD (SQL standard)
    $dat = date('M-d-Y', strtotime($dat));

    $fileNameToSave = ''; // Default value if no file is uploaded

    // File upload handling
    if (isset($_FILES['file2']) && $_FILES['file2']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file2']['tmp_name'];
        $fileName = $_FILES['file2']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allowed file types
        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'xlsx', 'txt', 'mp4'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // $uploadFileDir = "uploads/"; // relative to your project
            include "common_directory.php";

            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            $newFileName = uniqid() . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $fileNameToSave = $newFileName;
            } else {
                echo "<script>alert('Error moving uploaded file.');</script>";
            }
        } else {
            echo "<script>alert('Upload failed. Allowed types: " . implode(", ", $allowedfileExtensions) . "');</script>";
        }
    }

    // Save record in DB
    $sql = "INSERT INTO `documents` (`stud_no`, `req`, `dat`, `subject`, `con`, `type`, `remarks`, `rem2`, `rel`, `file2`) 
            VALUES ('$stud_no','$req','$dat','$subject','$con','$type','$remarks','$rem2','$rel','$fileNameToSave')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ebarmmdocs.php"); // redirect back to your main page
        exit();
    } else {
        echo "<script>alert('Error saving data: " . mysqli_error($conn) . "');</script>";
    }
}
?>
