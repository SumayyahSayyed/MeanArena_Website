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

// create a new WriteConcern instance with "majority" as the level
$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    $lastName = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // creating new Document with the user's data
    $document = new MongoDB\Driver\BulkWrite();
    $document->insert([
        'firstname' => $firstName,
        'lastname' => $lastName,
        'email' => $email,
        'password' => $password,
    ]);

    // inserting the document into the collection
    $manager->executeBulkWrite("$dbName.$collectionName", $document, $writeConcern);

    $_SESSION['user'] = $email;
    $_SESSION['loggedIn'] = true;
    setcookie('email', $email, time() + 3600, '/', 'localhost', true, true);
    
    echo "Done";
    header('Location: ../dashboard/dashboard.php');
    exit();
}
?>
