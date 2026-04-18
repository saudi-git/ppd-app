
<?php
require_once 'db.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Required fields
    $deo          = mysqli_real_escape_string($conn, $_POST['deo'] ?? '');
    $stud_no      = mysqli_real_escape_string($conn, $_POST['stud_no'] ?? '');
    $proj_name    = mysqli_real_escape_string($conn, $_POST['proj_name'] ?? '');
    $municipality = mysqli_real_escape_string($conn, $_POST['municipality'] ?? '');
    $barangay     = mysqli_real_escape_string($conn, $_POST['barangay'] ?? '');
    $sitio        = mysqli_real_escape_string($conn, $_POST['sitio'] ?? '');
    $cy           = mysqli_real_escape_string($conn, $_POST['cy'] ?? '');
    $fund_source  = mysqli_real_escape_string($conn, $_POST['fund_source'] ?? '');
    $moi          = mysqli_real_escape_string($conn, $_POST['moi'] ?? '');
    $proj_target  = mysqli_real_escape_string($conn, $_POST['proj_target'] ?? '');
    $proj_plan    = mysqli_real_escape_string($conn, $_POST['proj_plan'] ?? '');
    $cost         = mysqli_real_escape_string($conn, $_POST['cost'] ?? '');
    $proponent    = mysqli_real_escape_string($conn, $_POST['proponent'] ?? '');
    // $status       = mysqli_real_escape_string($conn, $_POST['status'] ?? '');
    // $ro_remarks   = mysqli_real_escape_string($conn, $_POST['ro_remarks'] ?? '');
    // $deo_remarks  = mysqli_real_escape_string($conn, $_POST['deo_remarks'] ?? '');




    // Default empty file name
    $fileNameToSave = "";

    /* ===============================
    FILE UPLOAD VALIDATION
    =============================== */
    if (!empty($_FILES['file']['name'])) {

        // 🔴 THIS IS THE IMPORTANT PART YOU ASKED ABOUT
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Upload cancelled or failed.'
            ]);
            exit;
        }

        // include "common_directory.php"; 
        $uploadFileDir = "funded_uploads/"; // relative to your project

        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        $allowed = ['pdf', 'jpg', 'jpeg', 'png', 'docx', 'xlsx', 'txt', 'mp4'];

        if (!in_array($ext, $allowed)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid file type.'
            ]);
            exit;
        }

        $fileNameToSave = uniqid("doc_", true) . "." . $ext;
        $target = $uploadFileDir . $fileNameToSave;

        if (!move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to upload file.'
            ]);
            exit;
        }
    }

    /* ===============================
       DATABASE INSERT
    =============================== */
   $sql = "INSERT INTO funded (
            deo,
            stud_no,
            proj_name,
            municipality,
            barangay,
            sitio,
            cy,
            fund_source,
            moi,
            proj_target,
            proj_plan,
            cost,
            proponent,
            file
        ) VALUES (
            '$deo',
            '$stud_no',
            '$proj_name',
            '$municipality',
            '$barangay',
            '$sitio',
            '$cy',
            '$fund_source',
            '$moi',
            '$proj_target',
            '$proj_plan',
            '$cost',
            '$proponent',
            '$fileNameToSave'
        )";

    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Project added successfully!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => mysqli_error($conn)
        ]);
    }

    exit();
}
