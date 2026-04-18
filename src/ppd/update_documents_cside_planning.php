<?php
require_once 'db.php';

if (isset($_POST['stud_id4'])) {
    $id = mysqli_real_escape_string($conn, $_POST['stud_id4']);
    $stud_no = addslashes($_POST['stud_no']);
    $subject = addslashes($_POST['subject']);
    $date = addslashes($_POST['date']);
    $con_agency = addslashes($_POST['con_agency']);
    $status = addslashes($_POST['status']);
    $remarks = addslashes($_POST['remarks']);
    $attachment = addslashes($_POST['attachment']);
    $forwarded = addslashes($_POST['forwarded']);
    // --- Update record ---
    $sql = "UPDATE `planningsection` 
            SET 
                stud_no = '$stud_no',
                subject = '$subject',
                date = '$date',
                con_agency = '$con_agency',
                status = '$status',
                remarks = '$remarks',
                attachment = '$attachment',
                forwarded = '$forwarded'
            WHERE stud_id4 = '$id'";

    if (mysqli_query($conn, $sql)) {
        // ✅ AJAX request
        if (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            echo json_encode(['status' => 'success', 'message' => 'Record updated successfully.']);
        } else {
            // ✅ Normal form submission
            header('Location: indexdocs_cside_planning.php');
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
