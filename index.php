<?php
require_once __DIR__ . '/bootstrap.php';
// $manager = new MongoDB\Driver\Manager('mongodb://localhost:27017');
$manager = new MongoDB\Driver\Manager('mongodb+srv://SamSayyed:mySampassword123@mydatabasecluster.ib0uvs4.mongodb.net/');

session_start();

if (!isset($_SESSION['loggedIn'])) {
    // Set a default value for 'loggedIn' key
    $_SESSION['loggedIn'] = false;
}

if ($_SESSION['loggedIn']) {
    $dbName = 'Accounts';
    $collectionName = 'Users';

    // Retrieve the user's information only if they are logged in
    $query = new MongoDB\Driver\Query(['email' => $_SESSION['user']]);
    $cursor = $manager->executeQuery("$dbName.$collectionName", $query);
    $documents = $cursor->toArray();

    if (!empty($documents)) {
        $document = $documents[0];
        $firstName = $document->firstname;
        $lastName = $document->lastname;

        // Retrieve user's ID and email from the database for the chrome extension
        $user_id = $document->_id;
        $email = $document->email;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeanArena Website</title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <nav id="navbar">
        <ul id="nav-left">
            <li><a href="index.php" id="brand">
                    <img src="images/logo-white.png" alt="MeanArena Website Logo">
                    MeanArena
                </a>
            </li>
            <li><a href="#main-body">Features</a></li>
            <li><a href="#contact">Contact Us</a></li>
            <li><a href="dashboard/dashboard.php">Dashboard</a></li>
        </ul>

        <?php
            if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
                echo '<img src="icons/user.png" alt="profile-icon" id="profile" class="icon">';
                echo '<ul id="dropdown" class="hide">';
                    echo '<li>';
                        echo '<h3>' . ucfirst($firstName) . ' ' . ucfirst($lastName) . '</h3>';
                    echo '</li>';
                    echo '<li>' . $email . '</li>';
                    echo '<hr>';
                    echo '<li id="dropdown-end">';
                        echo '<img src="icons/box-arrow-in-right.svg" alt="">';
                        echo '<a href="php/logout.php" id="color">Sign Out</a>';
                    echo '</li>';
                echo '</ul>';
            } else {
                echo '<a href="register/register.html">Sign Up</a>';
            }
        ?>
    </nav>

    <header>
        <!-- <img src="images/banner.jpg" alt=""> -->
        <h1>Stuck with difficult<br> WORDS<br> while reading?</h1>
        <p>MeanArena lets you save definitions and translations of words from any webpage</p>
        <button><a href="https://chrome.google.com/webstore/detail/meanarena-know-your-words/jnfdjooffpbiejajpahajemhhdfjdikc?hl=en-US">Install</a></button>
        <!-- <button>Contact Us</button> -->
    </header>
    <div id="main-body">
        <!-- <h2>Cool Features</h2> -->
        <div class="style">
            <img src="images/double-click.png">

            <div class="right">
                <h3>Double Click</h3>
                <p>Double click on any word, and the definition of that word will appear.</p>
            </div>
        </div>
        <div class="style">
            <div class="left">
                <h3>Multiple Dictionaries</h3>
                <p>Choose your preferred dictionary from Merriam Webster, Google Dictionary, Wordnik Dictionary</p>
            </div>

            <img src="images/multiple-dictionaries.png">
        </div>
        <div class="style">
            <img src="images/any-website.png">

            <div class="right">
                <h3>Works on Every Website</h3>
                <p>No matter which website is opened or which tab is opened, you can access the definitions.</p>
            </div>
        </div>
        <div class="style">
            <div class="left">
                <h3>Track your Learning</h3>
                <p>Save your words along with its definition in your dashboard, creating you your personalized
                    dictionary.</p>
            </div>

            <img src="images/track-learning.png">
        </div>
        <div class="style">
            <img src="images/webpage-scanning.png">

            <div class="right">
                <h3>WebPage Scanning</h3>
                <p>Refresh the page, and your saved words will be underlined. Hover over these words to see the
                    definition.
                </p>
            </div>
        </div>
    </div>

    <footer>
        <form method="POST" action="/Practice/php/contact.php" id="contact" >
            <h2>Get in touch</h2>
            <input type="text" name="name" id="name" placeholder="Name">
            <input type="email" name="email" id="email" placeholder="Email">
            <input type="text" name="message" id="message" placeholder="How can we help you?">
            <button type="submit" id="submitBtn" onclick="submitForm(event)">Submit</button>
        </form>
        <hr>
        <p id="end">copyright © 2023 - All rights reserved</p>
    </footer>

    <script src="index.js"></script>

</body>

</html>