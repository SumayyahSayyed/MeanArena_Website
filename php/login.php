<?php
require_once __DIR__ . '/bootstrap.php';
// set cookie to expire in 15 days
$cookie_lifetime = 15 * 24 * 60 * 60;
session_set_cookie_params($cookie_lifetime, '/', 'localhost', true, true);

session_start();

// $manager = new MongoDB\Driver\Manager('mongodb://localhost:27017');
$manager = new MongoDB\Driver\Manager('mongodb+srv://SamSayyed:mySampassword123@mydatabasecluster.ib0uvs4.mongodb.net/');



$dbName = 'Accounts';
$collectionName = 'Users';

// check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // retrieve email and password from the form
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // search for the user's document in the database
    $query = new MongoDB\Driver\Query(['email' => $email]);
    $cursor = $manager->executeQuery("$dbName.$collectionName", $query);

    // check if the document is found
    $result = $cursor->toArray();
    if (count($result) === 1) {
        // retrieve the hashed password from the document
        $document = $result[0];
        $hashedPassword = $document->password;
    
        // retrieve user's ID and email from the database
        $user_id = $document->_id;
        $email = $document->email;
    
        // check if the password is correct
        if (password_verify($password, $hashedPassword)) {
            // set session variables
            $_SESSION['user'] = $email;
            $_SESSION['loggedIn'] = true;
            setcookie('email', $email, time() + 3600, '/', 'localhost', true, true);
            session_regenerate_id(true);
    
            header('Location: ../dashboard/dashboard.php');
            exit();
        } else {
            // if the password is incorrect, show an error message with the password field highlighted
            header("Location: ../login/login.html?error=invalid_password&email=$email");
            exit();
        }
    } else {
        // if the email is incorrect, show an error message with the email field highlighted
        header("Location: ../login/login.html?error=invalid_email&email=$email");
        exit();
    }

    
}
?>