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
    $rel = mysqli_real_escape_string($conn, $_POST['rel']);
    
    


    $dat = date('M-d-Y', strtotime($dat));

    $update_file = "";

    // 1. Check if a new file is uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // 2. Get the old file name from database
        $query = mysqli_query($conn, "SELECT file FROM documents WHERE stud_id8 = '$id'");
        $row = mysqli_fetch_assoc($query);
        $oldFile = $row['file'];

        // 3. Prepare the new file
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
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

            // 4. Move new file
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $update_file = ", file = '$newFileName'";

                // 5. Delete the old file if it exists
                if (!empty($oldFile) && file_exists($uploadFileDir . $oldFile)) {
                    unlink($uploadFileDir . $oldFile);
                }
            } else {
                echo "<script>alert('There was an error moving the uploaded file.')</script>";
                exit();
            }
        } else {
            echo "<script>alert('Upload failed. Allowed file types: " . implode(", ", $allowedfileExtensions) . "')</script>";
            exit();
        }
    }

    // 6. Final update query
    $sql = "UPDATE `documents` SET stud_no = '$stud_no',req = '$req',dat = '$dat', subject = '$subject', con = '$con', type = '$type', remarks = '$remarks', rel = '$rel' $update_file WHERE stud_id8 = '$id'";

    if (mysqli_query($conn, $sql)) {
        header('Location: indexdocs_cside.php');
        exit();
    } else {
        echo "<script>alert('Error updating data: " . mysqli_error($conn) . "')</script>";
    }
}
