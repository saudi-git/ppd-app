<?php
require_once 'db.php';

if (isset($_POST['stud_id4'])) {
    $stud_id = mysqli_real_escape_string($conn, $_POST['stud_id4']);

    // Delete the database record only (no file handling)
    $deleteQuery = "DELETE FROM `planningsection` WHERE `stud_id4` = '$stud_id'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete record: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
