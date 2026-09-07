<?php
require_once 'db.php';

if (isset($_POST['stud_id5'])) {
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

    $query = "UPDATE unfunded SET
                deo='$deo',
                stud_no='$stud_no',
                proj_name='$proj_name',
                municipality='$municipality',
                barangay='$barangay',
                sitio='$sitio',
                scale='$scale',
                cost='$cost',
                proponent='$proponent',
                position='$position',
                dat='$dat',
                forwarded='$forwarded',
                remarks='$remarks',
                attachment='$attachment',
                stat='$stat'
              WHERE stud_id5='$stud_id5'";

    if (mysqli_query($conn, $query)) {
        // Get updated row
        $updated = mysqli_query($conn, "SELECT * FROM unfunded WHERE stud_id5='$stud_id5'");
        $updatedRow = mysqli_fetch_assoc($updated);

        echo json_encode([
            'status' => 'success',
            'message' => 'Record updated successfully!',
            'updatedRecord' => $updatedRow
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Update failed: ' . mysqli_error($conn)
        ]);
    }
}
?>
