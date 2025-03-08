<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?> 
<?php 
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $deleteGenre = $conn->query("DELETE from genres WHERE id='$id'");
        $deleteGenre->execute();

        header("Location: show-genres.php");

    }

?>