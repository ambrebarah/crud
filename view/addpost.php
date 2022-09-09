<?php

session_start();
//include database connection
    require_once('../model/db.php');

    $db = Db();
if(!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}
if(isset($_POST['submit'])) {
 
    $title = $_POST['title'];
    $body = $_POST['body'];
    $category = $_POST['category'];
    $query = $db->prepare("INSERT INTO posts(user_id, title, body, category_id, posted) VALUES (:user_id, :title, :body, :category, :date)");
    $query->bindParam(':user_id', $user_id);
    $query->bindParam(':title', $title);
    $query->bindParam(':body', $body);
    $query->bindParam(':category', $category);
    $query->bindParam(':date', $date);
    $user_id = $_SESSION['user_id'];
    date_default_timezone_set('Europe/Paris');
    $date = date("Y-m-d H:i:s");
    $body = htmlentities($body);
    $query->execute();
    if($title && $body && $category) {
        if($query) {
            echo "Post added";
        } else {
            echo "Error";
        }
    } else {
        echo "Missing information";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
</head>
<body>
    <div id="container">
        <div id="menu">
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="addpost.php">Create New Post</a></li>
            <li><a href="profil.php">profils</a></li>
            <li><a href="list.php">fil d'actualité</a></li>
            <li><a href="../controller/logout.php">Log Out</a></li>
        </ul>
        </div>
    </div>
    <div id="wrapper">
        <div id="content">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
                <label>Title:</label><input type="text" name="title" />
                <label for="body">Body:</label>
                <textarea name="body" cols=50 rows=10 maxlength="200"></textarea>
                <label>Category:</label>
                <select name="category">
                    <?php
                        $query = $db->query("SELECT * FROM categories");
                        while($row = $query->fetchObject()) {
                            echo "<option value='".$row->category_id."'>".$row->category."</option>";
                        }
                    ?>
                </select>
                <br>
                <br>
                <input type="submit" name='submit' value="Submit" />
            </form>
        </div>
    </div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
</body>
</html>