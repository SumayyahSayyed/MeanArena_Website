<?php
session_start();

if (isset($_COOKIE['user_id'])) {
  echo "true";
} else {
  // redirect to login page
  header('Location: ../login/login.html');
  exit();
}
?>
