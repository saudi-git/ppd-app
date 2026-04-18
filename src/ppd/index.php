<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = trim($_POST['username']);
	$password = $_POST['password'];

	$stmt = $conn->prepare("SELECT * FROM usersfunded WHERE username=? LIMIT 1");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();
	$user = $result->fetch_assoc();

	if ($user && password_verify($password, $user['password'])) {
		$_SESSION['user'] = $user['username'];
		$_SESSION['name'] = $user['name'];
		$_SESSION['role'] = $user['role'];
		header("Location: dashboard_docs.php");
		exit;
	} else {
		$error = "Invalid username or password.";
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="/admin/images/mpw-icon.png">
	<title>PPD-PIMS - Login</title>

	<!-- Bootstrap 3 -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<style>
		body {
			background-color: #f8f9fa;
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.panel {
			border-radius: 10px;
			box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
		}

		.panel-heading h1 {
			font-size: 22px;
			font-weight: bold;
			margin: 0;
		}
	</style>
</head>

<body>

	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-md-4 col-md-offset-4 col-sm-offset-2">
				<div class="panel panel-info">
					<div class="panel-heading text-center">
						<h1 class="panel-title">Administrator Login</h1>
					</div>
					<div class="panel-body">
						<form method="POST">

							<?php if (!empty($error)): ?>
								<div class="alert alert-danger">
									<?php echo htmlspecialchars($error); ?>
								</div>
							<?php endif; ?>

							<div class="form-group">
								<label for="username">Username</label>
								<input class="form-control" name="username" placeholder="Enter username" type="text" required>
							</div>

							<div class="form-group">
								<label for="password">Password</label>
								<input class="form-control" id="myInput" name="password" placeholder="Enter password" type="password" required>

								<div class="checkbox">
									<label>
										<input type="checkbox" onclick="togglePassword()"> Show Password
									</label>
								</div>
							</div>

							<button class="btn btn-info btn-block" type="submit">
								<span class="glyphicon glyphicon-log-in"></span> Login
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		function togglePassword() {
			var x = document.getElementById("myInput");
			x.type = (x.type === "password") ? "text" : "password";
		}
	</script>

</body>

</html>