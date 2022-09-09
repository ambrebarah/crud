<?php

session_start();

// check user login
if(empty($_SESSION['user_id']))
{
    header("Location: ./index.php");
}

// Database connection
require '../model/db.php';
$db = DB();


require '../model/user.php';
$app = new User();

$user = $app->UserDetails($_SESSION['user_id']); // get user details

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="well">
            <h2>
                Profile
            </h2>
            <h3>Hello <?php echo $user->prenom ?>,</h3>
            <a href="home.php" class="btn btn-primary">home</a>
            <a href="edit.php" class="btn btn-primary">edit</a>
            <p>
               <?php 
               echo "<b>Nom:</b> " . $user->nom;
               echo "<br /><b>Prenom:</b> " . $user->prenom;
               echo "<br /><b>Email:</b> " .$user->email;
               echo "<br /><b>Bio:</b> " .$user->bio;
              
               ?>
            </p>
            <a href="../controller/logout.php" class="btn btn-primary">Logout</a>
            <a href="delete.php?delete_id=<?php echo $user->user_id; ?>">DELETE</a>
        </div>
    </div>
</body>
</html>
