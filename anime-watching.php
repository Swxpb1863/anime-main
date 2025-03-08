<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>

<?php
    if(isset($_GET['id']) AND isset($_GET['ep'])){
        $id = $_GET['id'];
        $ep = $_GET['ep'];

        $episodes = $conn->query("SELECT * FROM episodes WHERE show_id='$id'");
        $episodes->execute();

        $allEpisodes = $episodes->fetchAll(PDO::FETCH_OBJ);

        $episode = $conn->query("SELECT * FROM episodes WHERE show_id='$id' and episode_name='$ep'");
        $episode->execute();

        $singleEpisode = $episode->fetch(PDO::FETCH_OBJ);

        $show = $conn->query("SELECT * FROM shows WHERE id='$id'");
        $show->execute();

        $singleShow = $show->fetch(PDO::FETCH_OBJ);

        $comments = $conn->query("SELECT * FROM comments WHERE show_id='$id'");
        $comments->execute();

        $allComments = $comments->fetchAll(PDO::FETCH_OBJ);


        if(isset($_POST["inserting_comments"])){
            if(empty($_POST['comment'])){
                echo "<script>alert('comment is empty.')</script>";
            }else{
                $comment = $_POST['comment'];
                $show_id = $id;
                $user_id = $_SESSION['user_id'];
                $username = $_SESSION['username'];
                $insert = $conn->prepare("INSERT INTO comments(comment, show_id, user_id, username)
                VALUE(:comment, :show_id, :user_id, :username)");
                $insert->execute([
                    ":comment" => $comment,
                    ":show_id" => $show_id,
                    ":user_id" => $user_id,
                    ":username" => $username          
                ]);
                header("Location: ".APPURL."/anime-watching.php?id=".$id."&ep=".$ep."");
                //echo "<script>alert('comment added')</script>";
            }
            

        }
    }
    else{
        echo "<script>location.href='".APPURL."/404.php'</script>";
        exit;
    }



?>
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="<?php echo APPURL; ?>"><i class="fa fa-home"></i> Home</a>
                        <a href="<?php echo APPURL; ?>/categories.php?name=<?php echo $singleShow->genre; ?>">Categories</a>
                        <a href="#"><?php echo $singleShow->genre; ?></a>
                        <span><?php echo $singleShow->title; ?></span>
                        <span>Ep <?php echo $singleEpisode->episode_name; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="anime-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div style="width:70rem; height:40rem;" class="anime__video__player">
                        <video id="player" playsinline controls data-poster="<?php echo IMGURL; ?>/<?php echo $singleEpisode->thumbnail; ?>">
                            <source src="<?php echo VIDURL; ?>/<?php echo $singleEpisode->video; ?>" type="video/mp4" />
                            <!-- Captions are optional -->
                            <track kind="captions" label="English captions" src="#" srclang="en" default />
                        </video>
                    </div>
                    <div class="anime__details__episodes">
                        <div class="section-title">
                            <h5>List Name</h5>
                        </div>
                        <?php foreach($allEpisodes as $episode) : ?>
                        <a href="<?php echo APPURL; ?>/anime-watching.php?id=<?php echo $episode->show_id; ?>&ep=<?php echo $episode->episode_name; ?>"> Ep <?php echo $episode->episode_name; ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="anime__details__review">
                        <div class="section-title">
                            <h5>Comments</h5>
                        </div>
                        <?php foreach($allComments as $comment) : ?>
                        <div class="anime__review__item">
                          <!--  <div class="anime__review__item__pic">
                                <img src="img/anime/review-1.jpg" alt="">
                            </div> -->
                            <div class="anime__review__item__text">
                                <h6><?php echo $comment->username; ?> - <span> <?php echo $comment->created_at; ?></span></h6>
                                <p><?php echo $comment->comment; ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="anime__details__form">
                        <div class="section-title">
                            <h5>Your Comment</h5>
                        </div>
                        <form method="POST" action="<?php echo APPURL; ?>/anime-watching.php?id=<?php echo $id; ?>&ep=<?php echo $ep; ?>">
                                <textarea name="comment" placeholder="Your Comment"></textarea>
                                <input name="show_id" value="<?php echo $id; ?>" type="hidden">
                                <button name="inserting_comments" type="submit"><i class="fa fa-location-arrow"></i> Comment</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Anime Section End -->
<?php require "includes/footer.php"; ?>