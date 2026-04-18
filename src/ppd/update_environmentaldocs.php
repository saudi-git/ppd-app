<?php
require_once 'db.php';

if (isset($_POST['update'])) {
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

    $update_file2 = "";

    // ✅ Only reformat date if provided
    $update_date = "";
    if (!empty($dat)) {
        $dat = date('Y-m-d', strtotime($dat));
        $update_date = ", dat = '$dat'";
    }

    // ✅ Handle file2 upload
    if (isset($_FILES['file2']) && $_FILES['file2']['error'] === UPLOAD_ERR_OK) {
        $query = mysqli_query($conn, "SELECT file2 FROM documents WHERE stud_id8 = '$id'");
        $row = mysqli_fetch_assoc($query);
        $oldFile2 = $row['file2'];

        $fileTmpPath = $_FILES['file2']['tmp_name'];
        $fileName = $_FILES['file2']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'xlsx', 'txt', 'mp4'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // $uploadFileDir = 'uploads/';
            include "common_directory.php";

            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            $newFileName = uniqid() . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $update_file2 = ", file2 = '$newFileName'";
                if (!empty($oldFile2) && file_exists($uploadFileDir . $oldFile2)) {
                    unlink($uploadFileDir . $oldFile2);
                }
            } else {
                echo "<script>alert('There was an error moving the uploaded file2.')</script>";
                exit();
            }
        } else {
            echo "<script>alert('Upload failed. Allowed file types: " . implode(", ", $allowedfileExtensions) . "')</script>";
            exit();
        }

        // ✅ Your requested snippet (inserted as-is)
        if (!empty($_FILES['file2']['name'])) {
            $file2_name = $_FILES['file2']['name'];
            $file2_tmp = $_FILES['file2']['tmp_name'];
            move_uploaded_file($file2_tmp, "admin/uploads/" . $file2_name);

            $sql = "UPDATE documents SET file2 = '$file2_name' WHERE stud_id8 = '$id'";
        }
    }

    // ✅ Build query dynamically so date is only updated if changed
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
        header('Location: environmentaldocs.php');
        exit();
    } else {
        echo "<script>alert('Error updating data: " . mysqli_error($conn) . "')</script>";
    }
}
?>  
