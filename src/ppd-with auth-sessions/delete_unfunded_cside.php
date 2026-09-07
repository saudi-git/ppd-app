<?php
require_once 'db.php';

if (isset($_POST['stud_id5'])) {
    $stud_id5 = mysqli_real_escape_string($conn, $_POST['stud_id5']);
    $query = "DELETE FROM `unfunded` WHERE `stud_id5` = '$stud_id5'";

    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
