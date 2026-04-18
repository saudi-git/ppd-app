
<?php
require_once 'db.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Unknown error occurred'];

if (isset($_POST['stud_id2'])) {
    $stud_id = mysqli_real_escape_string($conn, $_POST['stud_id2']);

    // Fetch file names first
    $query = mysqli_query($conn, "SELECT file FROM `funded` WHERE `stud_id2` = '$stud_id'");
    
    if ($query && mysqli_num_rows($query) > 0) {
        $fetch = mysqli_fetch_assoc($query);
        $uploadPath = __DIR__ . '/funded_uploads/';

        // Delete files if they exist
        foreach (['file'] as $col) {
            if (!empty($fetch[$col])) {
                $filePath = $uploadPath . $fetch[$col];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Delete the database record
        if (mysqli_query($conn, "DELETE FROM `funded` WHERE `stud_id2` = '$stud_id'")) {
            $response = ['success' => true, 'message' => 'Record and files deleted successfully'];
        } else {
            $response['message'] = 'Failed to delete database record: ' . mysqli_error($conn);
        }
    } else {
        $response['message'] = 'Record not found';
    }
} else {
    $response['message'] = 'No ID provided';
}

echo json_encode($response);
$conn->close();
?>
