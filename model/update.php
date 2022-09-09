<?php
    require_once 'db.php';

    $db = Db();
 
    if(ISSET($_POST['update'])){
        try{
            $user_id = $_POST['user_id'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $bio = $_POST['bio'];

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `users`SET `nom` = '$nom', `prenom` = '$prenom', `email` = '$email', `bio` = '$bio' WHERE `user_id` = '$user_id'";
            $db->exec($sql);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
 
        $db = null;
        header('location:../view/profil.php');
    }
?>