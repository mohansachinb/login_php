<?php
session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];
    $profileImage = $_FILES["profile_image"];

    if ($password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } else {
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $imageName = uniqid() . "_" . basename($profileImage["name"]);
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($profileImage["tmp_name"], $targetFile)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // $stmt = $conn->prepare("INSERT INTO users (name, phone, email, password, image) VALUES (?, ?, ?, ?, ?)");
            // $stmt->bind_param("sssss", $name, $phone, $email, $hash, $imageName);

            // if ($stmt->execute()) {
            //     header("Location: login.php");
            //     exit();
            // } else {
            //     $error = "Email already exists!";
            // }
            // Check if email exists
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $error = "Email already registered.";
} else {
    $stmt = $conn->prepare("INSERT INTO users (name, phone, email, password, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $phone, $email, $hash, $imageName);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Something went wrong. Try again!";
    }
}

        } else {
            $error = "Failed to upload image.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body class="auth-body">
    <div class="glass-card">
        <h2>Create Account</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <input type="file" name="profile_image" accept="image/*" required>
            <button type="submit">Sign Up</button>
            <p class="switch">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
