<?php
require_once 'db.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // ✅ Check if username already exists
    $check = mysqli_query($conn, "SELECT * FROM usersfunded WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username already exists!']);
        exit();
    }

    // ✅ Insert new user
    $sql = "INSERT INTO usersfunded (username,name, password, role)
            VALUES ('$username', '$name', '$passwordHash', '$role')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'User added successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error saving user: ' . mysqli_error($conn)]);
    }
    exit();
}
