<?php
require_once __DIR__ . "/vendor/autoload.php";
// $manager = new MongoDB\Driver\Manager('mongodb://localhost:27017');
$manager = new MongoDB\Driver\Manager('mongodb+srv://SamSayyed:mySampassword123@mydatabasecluster.ib0uvs4.mongodb.net/');

session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: ../login/login.html');
    exit();
}
if (isset($_SESSION['timeout']) && $_SESSION['timeout'] < time()) {
    header('Location: ../login/login.html');
    exit;
} else {
    $_SESSION['timeout'] = time() + (15 * 24 * 60 * 60);
}

$dbName = 'Accounts';
$collectionName = 'Users';

// retrieve the user's information
$query = new MongoDB\Driver\Query(['email' => $_SESSION['user']]);
$cursor = $manager->executeQuery("$dbName.$collectionName", $query);
$document = $cursor->toArray()[0];
$firstName = $document->firstname;
$lastName = $document->lastname;

// retrieve user's ID and email from the database for chrome extension
$user_id = $document->_id;
$email = $document->email;
setcookie('user_id', $user_id, time() + (86400 * 15));
setcookie('email', $email, time() + (86400 * 15));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
    <nav id="navbar">
        <ul id="nav-left">
            <li>
                <img src="../icons/icons8-hamburger.svg" alt="Hamburger-icon" id="hamburger"
                    class="rotate clockwise icon">
            </li>
            <li>
                <a href="dashboard.php" id="brand">
                    <img src="../images/logo-white.png">
                    MeanArena <span>Dashboard</span>
                </a>
            </li>
        </ul>
        <img src="../icons/user.png" alt="profile-icon" id="profile" class="icon">
        <!-- <a href="register/register.html">Logout</a> -->
    </nav>
    <main id="main-body">

        <div id="side">
            <div class="items">
                <img src="../icons/journal-text.svg" alt="">
                <h4>Saved Items</h4>

            </div>
            
        </div>
        <ul id="mainbody-box">
        <?php
          $accounts_db = new MongoDB\Database($manager, 'Accounts');
          $user_collection = $accounts_db->{$email . '_words'};
          $result = $user_collection->find();
          // Render the data in HTML
          foreach ($result as $doc) {
            echo '<li class="box">';
                echo '<h3>' . ucfirst($doc->Word) . '</h3>';
                echo '<p>' . $doc->Definition . '</p>';
                    echo '<div class="end">';
                    echo '<label>' . $doc->Dictionary . '</label>';
                    echo '<img src="../icons/trash.svg" alt="bin-icon" id="bin"  onclick="deleteWord(\'' . $doc->_id . '\', this)">';
                echo'</div>';
            echo'</li>';
          }
          ?>
            
        </ul>
        <ul id="dropdown" class="hide">
            <li>
                <h3><?php echo ucfirst($firstName) . ' ' . ucfirst($lastName); ?></h3>
            </li>
            <li><?php echo $email; ?></li>
            <hr>
            <li id="dropdown-end">
                <img src="../icons/box-arrow-in-right.svg" alt="">
                <a href="../php/logout.php">Sign Out</a>
            </li>
        </ul>
    </main>
    <hr>
    <footer id="end">
        <a href="../index.php" class="items">MeanArena</a>  
        <p>copyright © 2023 - All rights reserved</p>
    </footer>
    <script src="dashboard.js"></script>
</body>

</html>