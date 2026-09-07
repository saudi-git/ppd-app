<?php
require_once 'session.php';
include 'db.php';

$error = "";

if (isset($_GET['session']) && $_GET['session'] === 'expired') {
	$error = "Your session expired due to inactivity. Please log in again.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = trim($_POST['username']);
	$password = $_POST['password'];

	$stmt = $conn->prepare("SELECT * FROM usersfunded WHERE username=? LIMIT 1");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();
	$user = $result->fetch_assoc();

	if ($user && password_verify($password, $user['password'])) {
		// Prevent session fixation by issuing a fresh session ID after authentication.
		session_regenerate_id(true);

		$_SESSION['user'] = $user['username'];
		$_SESSION['name'] = $user['name'];
		$_SESSION['role'] = $user['role'];
		$_SESSION['LOGIN_TIME'] = time();
		$_SESSION['LAST_ACTIVITY'] = time();

		header("Location: /");
		exit;
	} else {
		$error = "Invalid username or password.";
	}
}

if (isset($_SESSION['user'])) {
	$roleDefaultPages = [
		'admin' => 'admin.php',
		'incoming' => 'indexdocs_cside.php',
		'outgoing' => 'outgoingdocs.php',
		'planning' => 'indexdocs_cside_funded2.php',
		'programming' => 'indexdocs_cside_funded2.php',
		'environmental' => 'environmentaldocs.php',
		'ebarmm' => 'indexdocs_cside_fundedgis.php',
		'viewer' => 'viewdocs.php',
		'unfunded' => 'unfunded_cside_status.php'
	];

	$roleNavbars = [
		'admin' => 'navbaradmin.php',
		'viewer' => 'navbarviewer.php',
		'unfunded' => 'navbarunfundedstatus.php'
	];

	$userRole = $_SESSION['role'] ?? '';
	$defaultPage = $roleDefaultPages[$userRole] ?? 'admin.php';
	$navbarFile = $roleNavbars[$userRole] ?? 'navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>PPD-PIMS</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/mpw-icon.png">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
	<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

	<style>
		body {
			margin: 0;
			background: #fff;
		}

		body.app-shell-loading .topnav {
			display: none;
		}

		.topnav {
			display: flex;
			justify-content: space-between;
			align-items: center;
			background-color: #f1f1f1;
			padding: 0 10px;
			flex-wrap: wrap;
		}

		.topnav .left-section,
		.topnav .right-section {
			display: flex;
			align-items: center;
		}

		.navbar-logo {
			width: 45px;
			height: 45px;
			margin-right: 10px;
		}

		.navbar-brand {
			font-size: 18px;
			font-weight: 500;
			color: #9d9d9d;
			text-decoration: none;
		}

		.dropdown {
			position: relative;
			margin-left: 10px;
		}

		.dropbtn {
			background: none;
			border: none;
			font-size: 16px;
			cursor: pointer;
			color: #9d9d9d;
			padding: 14px 10px;
			display: flex;
			align-items: center;
			gap: 5px;
		}

		.dropbtn i {
			margin-right: 5px;
		}

		.dropdown-content {
			display: none;
			position: absolute;
			background-color: #f9f9f9;
			min-width: 160px;
			box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
			z-index: 1000;
		}

		.dropdown-content a {
			color: black;
			padding: 10px 16px;
			text-decoration: none;
			display: block;
		}

		.dropdown-content a:hover {
			background-color: #ddd;
		}

		.dropdown:hover .dropdown-content {
			display: block;
		}

		.icon {
			display: none;
			font-size: 24px;
			cursor: pointer;
			color: #9d9d9d;
		}

		#app-content {
			min-height: calc(100vh - 56px);
		}

		.app-loading,
		.app-error {
			margin: 28px auto;
			max-width: 720px;
			padding: 14px 16px;
			border-radius: 4px;
			text-align: center;
		}

		.app-loading {
			background: #f5f7fa;
			color: #38424f;
		}

		.app-error {
			background: #f8d7da;
			color: #721c24;
		}

		@media screen and (max-width: 768px) {

			.topnav .left-section,
			.topnav .right-section {
				display: none;
				flex-direction: column;
				width: 100%;
			}

			.topnav.responsive .left-section,
			.topnav.responsive .right-section {
				display: flex;
			}

			.dropdown-content {
				position: relative;
			}

			.topnav.responsive .dropbtn {
				width: 100%;
				text-align: left;
			}

			.icon {
				display: block;
			}
		}
	</style>
</head>

<body class="app-shell-loading" data-default-page="<?php echo htmlspecialchars($defaultPage, ENT_QUOTES, 'UTF-8'); ?>" data-user-role="<?php echo htmlspecialchars($userRole, ENT_QUOTES, 'UTF-8'); ?>">
	<?php
	if (is_file(__DIR__ . '/' . $navbarFile)) {
		ob_start();
		include $navbarFile;
		$navbarHtml = ob_get_clean();

		if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $navbarHtml, $matches)) {
			echo $matches[1];
		} else {
			echo $navbarHtml;
		}
	} else {
		echo '<p><a href="logout.php">Logout</a></p>';
	}
	?>

	<main id="app-content">
		<div class="app-loading">Loading...</div>
	</main>

	<script src="js/app-shell.js"></script>
</body>

</html>
<?php
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="/images/mpw-icon.png">
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
