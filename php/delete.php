<?php
require_once __DIR__ . '/bootstrap.php';
use MongoDB\BSON\ObjectID;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use MongoDB\Driver\BulkWrite;

session_start();

$uri = 'mongodb+srv://SamSayyed:mySampassword123@mydatabasecluster.ib0uvs4.mongodb.net/';
$manager = new Manager($uri);
$database = 'Accounts';

// Get the email address of the current user
$collectionName = 'Users';
$filter = ['email' => $_SESSION['user']];
$options = [];
$query = new Query($filter, $options);
$cursor = $manager->executeQuery("$database.$collectionName", $query);
$document = $cursor->toArray()[0];
$email = $document->email;

// Delete the word from the database
$collectionName = $email . '_words';
$filter = ['_id' => new ObjectID($_POST['id'])];
$bulk = new BulkWrite();
$bulk->delete($filter, ['limit' => 1]);
$result = $manager->executeBulkWrite("$database.$collectionName", $bulk);

if ($result->getDeletedCount() > 0) {
    echo 'success';
} else {
    echo 'error';
}

?>