<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?> 
<?php 
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $episode = $conn->query("SELECT * FROM episodes WHERE id='$id'");
        $episode->execute();

        $getEpisode = $episode->fetch(PDO::FETCH_OBJ);

        unlink("videos/" . $getEpisode->video);
        unlink(filename: "images/" . $getEpisode->thumbnail);

        $deleteEpisode = $conn->query("DELETE from episodes WHERE id='$id'");
        $deleteEpisode->execute();

        header("location: show-episodes.php");

    }

?>

<?php require "../layouts/header.php"; ?>