<?php
session_start();
session_destroy();
header("Location: login.php");
exit();




// create database some commed
// ✅ MySQL Setup Steps
// 🧱 Step 1: Create a MySQL Database
// Open http://localhost/phpmyadmin

// Create a database: myphp_auth

// Run this SQL:

// sql
// Copy
// Edit
// CREATE TABLE users (
//   id INT AUTO_INCREMENT PRIMARY KEY,
//   name VARCHAR(100),
//   phone VARCHAR(20),
//   email VARCHAR(100) UNIQUE,
//   password VARCHAR(255),
//   image VARCHAR(255)
// );