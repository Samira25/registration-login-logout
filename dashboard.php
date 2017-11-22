<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
</head>
<body>

	<h1>Welcome! <?php session_start(); echo $_SESSION['name']; ?></h1>
	<a href="logout.php">Logout</a>

</body>
</html>