




<?php
session_start();

require_once("./model/db.php");

require  './model/user.php';
$app = new DemoLib();

$login_error_message = '';
$register_error_message = '';

// check Login request
if (!empty($_POST['btnLogin'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email == "") {
        $login_error_message = 'email field is required!';
    } else if ($password == "") {
        $login_error_message = 'Password field is required!';
    } else {
        $user_id = $app->Login($email, $password); // check user login
        if($user_id > 0)
        {
            $_SESSION['user_id'] = $user_id; // Set Session
            header("Location: ./view/profil.php"); // Redirect user to the profile.php
        }
        else
        {
            $login_error_message = 'Invalid login details!';
        }
    }
}


// check Register request
if (!empty($_POST['btnRegister'])) {
    if ($_POST['email'] == "") {
        $register_error_message = 'Name field is required!';
    } else if ($_POST['email'] == "") {
        $register_error_message = 'Email field is required!';
    } else if ($_POST['prenom'] == "") {
        $register_error_message = 'prenom field is required!';
    } else if ($_POST['bio'] == "") {
        $register_error_message = 'bio field is required!';
    } else if ($_POST['nom'] == "") {
        $register_error_message = 'nom field is required!';
    } else if ($_POST['password'] == "") {
        $register_error_message = 'Password field is required!';
    } else {
        $user_id = $app->Register($_POST['nom'], $_POST['email'], $_POST['prenom'],$_POST['bio'], $_POST['password']);
        // set session and redirect user to the profile page
        $_SESSION['user_id'] = $user_id;
        header("Location: ./view/profil.php");
    }
}
?>