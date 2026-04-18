<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and escape user inputs
    $stud_no    = mysqli_real_escape_string($conn, $_POST['stud_no']);
    $subject    = mysqli_real_escape_string($conn, $_POST['subject']);
    $date       = mysqli_real_escape_string($conn, $_POST['date']);
    $con_agency = mysqli_real_escape_string($conn, $_POST['con_agency']);
    $forwarded  = mysqli_real_escape_string($conn, $_POST['forwarded']);
    $status     = mysqli_real_escape_string($conn, $_POST['status']);
    $remarks    = mysqli_real_escape_string($conn, $_POST['remarks']);
    $attachment = mysqli_real_escape_string($conn, $_POST['attachment']);

    // ✅ Ensure date is properly formatted for MySQL
    $date = date('Y-m-d', strtotime($date));

    // Insert data into database
    $sql = "
        INSERT INTO planningsection 
        (stud_no, subject, date, con_agency, forwarded, status, remarks, attachment) 
        VALUES 
        ('$stud_no', '$subject', '$date', '$con_agency', '$forwarded', '$status', '$remarks', '$attachment')
    ";

    // ✅ Execute and handle result
    if (mysqli_query($conn, $sql)) {
        header("Location: indexdocs_cside_planning.php");
        exit;
    } else {
        echo "<script>alert('Error saving data: " . addslashes(mysqli_error($conn)) . "');</script>";
    }
}
?>
