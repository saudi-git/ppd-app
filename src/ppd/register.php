<?php
include 'db.php'; // your DB connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO usersfunded (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        echo "User created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<form method="POST">
    <label>Username:</label>
    <input type="text" name="username" required><br>

    <label>Password:</label>
    <input type="password" name="password" required><br>

    <label>Role:</label>
    <select name="role">
        <option value="admin">Admin</option>
        <option value="encoder">Encoder</option>
        <option value="outgoing">Outgoing</option>
        <option value="viewer">Viewer</option>
        <option value="planning">Planning</option>
        <option value="programming">Programming</option>
        <option value="ebarmm">E-Barmm</option>
    </select><br>

    <button type="submit">Register</button>
</form>