<?php
session_start();
require "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        .dashboard-container {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            color: white;
            width: 400px;
            text-align: center;
            margin: auto;
            margin-top: 80px;
        }
        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #00c851;
            margin-bottom: 20px;
        }
        .logout-btn {
            background: red;
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body class="auth-body">
    <div class="dashboard-container">
        <img src="uploads/<?php echo htmlspecialchars($user['image']); ?>" alt="Profile" class="profile-pic" />
        <h2>Hello, <?php echo htmlspecialchars($user['name']); ?> 👋</h2>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        <a class="logout-btn" href="logout.php">Logout</a>
    </div>
</body>
</html>
