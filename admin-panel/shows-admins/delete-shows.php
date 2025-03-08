<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?> 
<?php 
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $image = $conn->query("SELECT * FROM shows WHERE id='$id'");
        $image->execute();

        $getImage = $image->fetch(PDO::FETCH_OBJ);

        unlink("images/" . $getImage->image);
        unlink(filename: "images/" . $getImage->image_portrait);

        $deleteShow = $conn->query("DELETE from shows WHERE id='$id'");
        $deleteShow->execute();

        header("location: show-shows.php");

    }

?>

<?php require "../layouts/header.php"; ?>