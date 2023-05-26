<?php
require_once __DIR__ . '/bootstrap.php';
// $manager = new MongoDB\Driver\Manager('mongodb://localhost:27017');
$manager = new MongoDB\Driver\Manager('mongodb+srv://SamSayyed:mySampassword123@mydatabasecluster.ib0uvs4.mongodb.net/');


session_start();

// set cookie to expire in 15 days
$cookie_lifetime = 15 * 24 * 60 * 60;
setcookie('email', '', time() - 3600, '/', 'localhost', true, true);
session_set_cookie_params($cookie_lifetime, '/', 'localhost', true, true);

unset($_SESSION['user']);
unset($_SESSION['loggedIn']);
session_destroy();
header('Location: ../login/login.html');
exit();
?>





