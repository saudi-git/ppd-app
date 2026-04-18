<?php
require_once 'db.php';

if (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Check if user exists first
    $check = mysqli_query($conn, "SELECT * FROM usersfunded WHERE id = '$id'");
    if (mysqli_num_rows($check) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
        exit();
    }

    // Only hash and update password if it's not empty
    $passwordSQL = '';
    if (!empty($password)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $passwordSQL = ", password='$passwordHash'";
    }

    // Update query
    $sql = "UPDATE usersfunded SET username='$username',name='$name', role='$role'$passwordSQL WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'User successfully updated!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating: ' . mysqli_error($conn)]);
    }
    exit();
}
?>
