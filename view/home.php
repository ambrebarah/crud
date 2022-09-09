<?php

session_start();


if(empty($_SESSION['user_id']))
{
    header("Location: ./index.php");
}


require '../model/db.php';
$db = DB();

$post_count = $db->query("SELECT * FROM posts");

$comment_count = $db->query("SELECT * FROM comments");

if(isset($_POST['submit'])) {
    $newCategory = $_POST['newCategory'];
    if(!empty($newCategory)) {
            $query = $db->prepare("INSERT INTO categories (category) VALUES (?)");
            $query->bindParam(1, $newCategory);
            $query->execute();
            $newCategory = filter_input(INPUT_POST, 'newCategory', FILTER_SANITIZE_URL);
        if($query) {
            echo "New Category Added";
        } else {
            echo "Error";
        }
    } else {
        echo "Missing New Category";
    }
}


require '../model/user.php';
$app = new User();

$user = $app->UserDetails($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>home</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
<p>Welcome  <?php echo $user->prenom ?></p>
<ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="addpost.php">Create New Post</a></li>
            <li><a href="profil.php">profils</a></li>
            <li><a href="list.php">fil d'actualité</a></li>
            <li><a href="../controller/logout.php">Log Out</a></li>
        </ul>
</div>

<div id="mainContent">
            <table>
                <tr>
                    <td>Posts </td>
                    <td><?php echo $post_count->rowCount(); ?></td>
                </tr>
                <br>
                <tr>
                    <td>Total Comments</td>
                    <td><?php echo $comment_count->rowCount(); ?></td>
                </tr>
            </table>
            <br>
            <div id="categoryForm">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
                    <label for="category">Add New Category: </label><input type="text" name="newCategory" /> 
                    <input type="submit" name="submit" value="submit" />
                </form>
            </div>
        </div>
    </div>
</form>
</body>
</html>