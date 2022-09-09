<?php

if(!isset($_GET['id'])) {
    header('Location: list.php');
    exit();
} else {
    $id = $_GET['id'];
}
//include database connection
   require_once('../model/db.php');

   $db = Db();



$query = $db->prepare("SELECT title, body FROM posts WHERE post_id=:post_id");
$query->bindParam(':post_id', $id);
$query->execute();
$results = $query->fetch();
if(count($results) == 0) {
    header('Location: ./index.php');
    exit();
}
// define variables and set to empty values
$commentErr = "";
 $comment = "";

    if (empty($_POST["comment"])) {
        $comment = "";
        $commentErr = "Comment is required";
    } else {
        $comment = test_input($_POST["comment"]);
    }


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($addComment = $db->prepare("INSERT INTO comments(post_id, comment) VALUES (:post_id,  :comment)")) {
    $addComment->bindParam(':post_id', $id);
    $addComment->bindParam(':comment', $comment);
    $addComment->execute();
    if($addComment) {
    echo "<script type='text/javascript'>alert('Thank you! Your comment was added.')</script>";
    }
    $addComment->closeCursor();   
} else {
    echo "<script type='text/javascript'>alert('Failed!')</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />

</head>
    <body>
        <div id="menu">
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="addpost.php">Create New Post</a></li>
            <li><a href="profil.php">profils</a></li>
            <li><a href="list.php">fil d'actualité</a></li>
            <li><a href="../controller/logout.php">Log Out</a></li>
        </ul>
        </div>
        <div id="container">
            <div id="post">
                <?php
                    echo "<h2>".$results['title']."</h2>";
                    echo "<p>".$results['body']."</p>";
                ?>
            </div>
            <hr>
            <div id="addComments">
                <p><span class="error">* required field.</span></p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=$id"?>" method="POST">
                    Comment: <textarea name="comment" rows="5" cols="40"></textarea>
                    <span class="error">* <?php echo $commentErr;?></span>
                    <br><br>
                    <input type="hidden" name="post_id" value="<?php echo $id?>" />
                    <input type="submit" name="submit" value="Submit" />
                </form>    
            </div>
            <hr>    
            <div id="Comments">
                <?php
                    $query = $db->query("SELECT * FROM comments WHERE post_id='$id' ORDER BY comment_id DESC");
                    while($row = $query->fetchObject()):
                ?>
                <div>
                    <blockquote><?php echo $row->comment?></blockquote>
                </div>
                <?php
                    endwhile;        
                ?>
            </div>
        </div>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    </body>
</html>