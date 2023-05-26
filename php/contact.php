<?php
require_once __DIR__ . '/bootstrap.php';
$manager = new MongoDB\Driver\Manager('mongodb+srv://SamSayyed:mySampassword123@mydatabasecluster.ib0uvs4.mongodb.net/');


$dbName = 'Accounts';
$collection = "Contact";

// create a new WriteConcern instance with "majority" as the level
$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_EMAIL);

    // creating new Document with the user's data
    $document = new MongoDB\Driver\BulkWrite();
    $document->insert([
        'name' => $name,
        'email' => $email,
        'message' => $message
    ]);

    // inserting the document into the collection
    $manager->executeBulkWrite("$dbName.$collection", $document, $writeConcern);

    header('Location: ../index.php');
    exit();
}
?>