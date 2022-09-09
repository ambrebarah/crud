<?php
// including the database connection file
include_once("../model/db.php");

session_start();

// check user login
if(empty($_SESSION['user_id']))
{
    header("Location: profil.php");
}

$db = Db();

if(isset($_POST['update']))
{	
	$user_id = $_POST['user_id'];
	
	$nom=$_POST['nom'];
	$prenom=$_POST['prenom'];
	$email=$_POST['email'];	
    $bio=$_POST['bio'];	
    $password=$_POST['password'];	

	

	if(empty($nom) || empty($prenom) || empty($email) || empty($bio)  || empty($password)) {	
			
		if(empty($nom)) {
			echo "<font color='red'>nom field is empty.</font><br/>";
		}
		
		if(empty($prenom)) {
			echo "<font color='red'>prenom field is empty.</font><br/>";
		}
		
		if(empty($email)) {
			echo "<font color='red'>Email field is empty.</font><br/>";
		}
        
		if(empty($bio)) {
			echo "<font color='red'>bio field is empty.</font><br/>";
		}
        if(empty($password)) {
			echo "<font color='red'>password field is empty.</font><br/>";
		}				
	} else {	
		//updating the table
		$sql = "UPDATE users SET nom=:nom, prenom=:prenom, email=:email,  bio=:bio, password=:password WHERE user_id=:user_id";
		$query = $db->prepare($sql);
				
		$query->bindparam(':user_id', $user_id);
		$query->bindparam(':nom', $nom);
		$query->bindparam(':prenom', $prenom);
		$query->bindparam(':email', $email);
        $query->bindparam(':bio', $bio);
        $enc_password = hash('sha256', $password);
        $query->bindParam("password", $enc_password, PDO::PARAM_STR);
		$query->execute();
		
	
				
	
		header("Location: profil.php");
	}
}
?>
<?php
require '../model/user.php';
$app = new User();

$user = $app->UserDetails($_SESSION['user_id']); // get user details



?>
<html>
<head>	
	<title>Edit </title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>
	<a href="profil.php">profil</a>
    <a href="home.php" class="btn btn-primary">home</a>
	<br/><br/>
	
	<form name="form1" method="post" action="edit.php">
		<table border="0">
			<tr> 
				<td>Name</td>
				<td><input type="text" name="nom" value="<?php echo $user->nom;?>"></td>
			</tr>
			<tr> 
				<td>prenom</td>
				<td><input type="text" name="prenom" value="<?php echo $user->prenom;?>"></td>
			</tr>
			<tr> 
				<td>Email</td>
				<td><input type="email" name="email" value="<?php echo $user->email;?>"></td>
			</tr>
            <tr> 
				<td>bio</td>
				<td><input type="text" name="bio" value="<?php echo $user->bio;?>"></td>
			</tr>
            <tr> 
				<td>password</td>
				<td><input type="password" name="password" value="<?php echo $user->password;?>"></td>
			</tr>
			<tr>
				<td><input type="hidden" name="user_id" value=<?php echo $user->user_id;?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>

            
            
		</table>
	</form>
</body>
</html>