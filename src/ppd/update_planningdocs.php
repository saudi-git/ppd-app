<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['stud_id8']);
    $req = mysqli_real_escape_string($conn, $_POST['req']);
    $dat = mysqli_real_escape_string($conn, $_POST['dat']);
    $stud_no = mysqli_real_escape_string($conn, $_POST['stud_no']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $con = mysqli_real_escape_string($conn, $_POST['con']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $rem2 = mysqli_real_escape_string($conn, $_POST['rem2']);
    $rel = mysqli_real_escape_string($conn, $_POST['rel']);

    $update_date = "";
    $update_file2 = "";

    // ✅ Handle date update if provided
    if (!empty($dat)) {
        $dat = date('Y-m-d', strtotime($dat));
        $update_date = ", dat = '$dat'";
    }

    // ✅ Handle file2 upload
    if (isset($_FILES['file2']) && $_FILES['file2']['error'] === UPLOAD_ERR_OK) {
        include "common_directory.php";

        $query = mysqli_query($conn, "SELECT file2 FROM documents WHERE stud_id8 = '$id'");
        $row = mysqli_fetch_assoc($query);
        $oldFile2 = $row['file2'];

        $fileTmpPath = $_FILES['file2']['tmp_name'];
        $fileName = $_FILES['file2']['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'xlsx', 'txt', 'mp4'];
        if (in_array($fileExt, $allowed)) {
            if (!is_dir($uploadFileDir)) mkdir($uploadFileDir, 0755, true);

            $newFileName = uniqid() . '.' . $fileExt;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Delete old file if exists
                if (!empty($oldFile2) && file_exists($uploadFileDir . $oldFile2)) {
                    unlink($uploadFileDir . $oldFile2);
                }
                $update_file2 = ", file2 = '$newFileName'";
            } else {
                echo json_encode(["status" => "error", "message" => "Error moving file"]);
                exit;
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid file type"]);
            exit;
        }
    }

    // ✅ Build query dynamically
    $sql = "UPDATE `documents` SET 
                stud_no = '$stud_no',
                req = '$req',
                subject = '$subject',
                con = '$con',
                type = '$type',
                remarks = '$remarks',
                rem2 = '$rem2',
                rel = '$rel'
                $update_date
                $update_file2
            WHERE stud_id8 = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "DB error: " . mysqli_error($conn)
        ]);
    }
}
?>
