<?php

require_once("db.php");

class User
{


    public function Register($nom, $email, $prenom, $password, $bio)
    {
        try {
            $db = DB();
            $query = $db->prepare("INSERT INTO users(nom, email, prenom, password, bio) VALUES (:nom,:email,:prenom,:password, :bio)");
            $query->bindParam("nom", $nom, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("prenom", $prenom, PDO::PARAM_STR);
            $query->bindParam("bio", $bio, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);
            $query->execute();
            return $db->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    

  
    public function isEmail($email)
    {
        try {
            $db = DB();
            $query = $db->prepare("SELECT user_id FROM users WHERE email=:email");
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    public function Login($email, $password)
    {
        try {
            $db = DB();
            $query = $db->prepare("SELECT user_id FROM users WHERE email=:email AND password=:password");
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                return $result->user_id;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    public function UserDetails($user_id)
    {
        try {
            $db = DB();
            $query = $db->prepare("SELECT user_id, nom, prenom, email, bio FROM users WHERE user_id=:user_id");
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function EditProfil($user_id, $nom, $prenom, $email, $bio)
    {
        try {
            $db = DB();
            $query = $db->prepare("UPDATE users SET nom=:nom, prenom=:prenom, email=:email, bio=:bio FROM users WHERE user_id=:user_id");
            $query->bindparam(":nom",$nom);
			$query->bindparam(":prenom",$prenom);
			$query->bindparam(":email",$email);
			$query->bindparam(":bio",$bio);
			$query->bindparam(":user_id",$user_id);
			// execution de la requete :
			$query->execute();
			return true;	
		} catch (PDOException $e) {
            
			echo $e->getMessage();	
			return false;
        }
    }

    public function delete($user_id) // suppression d'un utilisateur par l'user_id.
	{
		$query = $db->prepare("DELETE FROM users WHERE user_id=:user_id"); // préparation.
		$query->bindparam(":user_id",$user_id); // affectation du valeur
		$query->execute(); // execution 
		return true; // toujoure on retourne true or false pour 
	} 
}
