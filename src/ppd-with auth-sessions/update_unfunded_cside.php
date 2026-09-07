<?php
require_once 'conn.php';

if (isset($_POST['update'])) {
    // Sanitize all inputs
    $stud_id5 = mysqli_real_escape_string($conn, $_POST['stud_id5']);
    $deo = mysqli_real_escape_string($conn, $_POST['deo']);
    $stud_no = mysqli_real_escape_string($conn, $_POST['stud_no']);
    $proj_name = mysqli_real_escape_string($conn, $_POST['proj_name']);
    $municipality = mysqli_real_escape_string($conn, $_POST['municipality']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $sitio = mysqli_real_escape_string($conn, $_POST['sitio']);
    $scale = mysqli_real_escape_string($conn, $_POST['scale']);
    $cost = mysqli_real_escape_string($conn, $_POST['cost']);
    $proponent = mysqli_real_escape_string($conn, $_POST['proponent']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $dat = mysqli_real_escape_string($conn, $_POST['dat']);
    $forwarded = mysqli_real_escape_string($conn, $_POST['forwarded']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $attachment = mysqli_real_escape_string($conn, $_POST['attachment']);
    $stat = mysqli_real_escape_string($conn, $_POST['stat']);

    // ✅ Check if record exists
    $check = mysqli_query($conn, "SELECT * FROM unfunded WHERE stud_id5 = '$stud_id5'");
    if (mysqli_num_rows($check) == 0) {
        echo "<script>alert('Record not found for stud_id5: $stud_id5');</script>";
        exit();
    }

    // ✅ Update query
    $query = "UPDATE `unfunded` SET 
                `stud_no` = '$stud_no', 
                `deo` = '$deo', 
                `proj_name` = '$proj_name', 
                `municipality` = '$municipality', 
                `barangay` = '$barangay', 
                `sitio` = '$sitio', 
                `scale` = '$scale', 
                `cost` = '$cost', 
                `proponent` = '$proponent', 
                `position` = '$position', 
                `dat` = '$dat',
                `forwarded` = '$forwarded',
                `remarks` = '$remarks',
                `attachment` = '$attachment',
                `stat` = '$stat'
              WHERE `stud_id5` = '$stud_id5'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Successfully updated!'); window.location='unfunded_cside.php';</script>";
    } else {
        echo "<script>alert('Update failed: " . mysqli_error($conn) . "');</script>";
    }
}
?>
