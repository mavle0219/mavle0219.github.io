<?php

include 'connect.php';

session_start();

$admin = $_SESSION['admin'];

$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$admin]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

if (!isset($admin)) {
  header('location:login.php');
}
// Specify the target directory for file uploads
$targetDir = "upload/";

// If the "upload" folder doesn't exist, create it
if (!is_dir($targetDir)) {
  mkdir($targetDir, 0755, true);
}

// Get the file name and full path
$fileName = basename($_FILES["file"]["name"]);
$targetFile = $targetDir . $fileName;

// Move the uploaded file to the target location
if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
  echo "File uploaded successfully.";
} else {
  echo "Error uploading file.";
}
?>
