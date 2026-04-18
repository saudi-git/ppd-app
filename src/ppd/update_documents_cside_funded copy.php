<?php
require_once 'db.php';

if (isset($_POST['stud_id2'])) {
    $id = mysqli_real_escape_string($conn, $_POST['stud_id2']);
    $deo = addslashes($_POST['deo']);
    $stud_no = addslashes($_POST['stud_no']);
    $proj_name = addslashes($_POST['proj_name']);
    $municipality = addslashes($_POST['municipality']);
    $barangay = addslashes($_POST['barangay']);
    $sitio = addslashes($_POST['sitio']);
    $cy = addslashes($_POST['cy']);
    $fund_source = addslashes($_POST['fund_source']);
    $moi = addslashes($_POST['moi']);
    $proj_target = addslashes($_POST['proj_target']);
    $proj_plan = addslashes($_POST['proj_plan']);
    $cost = addslashes($_POST['cost']);
    $proponent = addslashes($_POST['proponent']);
    $status = addslashes($_POST['status']);
    $ro_remarks = addslashes($_POST['ro_remarks']);
    $deo_remarks = addslashes($_POST['deo_remarks']);

    // --- Update record ---
    $sql = "UPDATE `funded` 
            SET 
                deo = '$deo',
                stud_no = '$stud_no',
                proj_name = '$proj_name',
                municipality = '$municipality',
                barangay = '$barangay',
                sitio = '$sitio',
                cy = '$cy',
                fund_source = '$fund_source',
                moi = '$moi',
                proj_target = '$proj_target',
                proj_plan = '$proj_plan',
                cost = '$cost',
                proponent = '$proponent',
                status = '$status',
                ro_remarks = '$ro_remarks',
                deo_remarks = '$deo_remarks'
            WHERE stud_id2 = '$id'";

    if (mysqli_query($conn, $sql)) {
        // ✅ AJAX request
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['status' => 'success', 'message' => 'Record updated successfully.']);
        } else {
            // ✅ Normal form submission
            header('Location: indexdocs_cside_funded.php');
        }
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating data: ' . mysqli_error($conn)]);
        exit();
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit();
}
?>
