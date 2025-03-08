<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>

<?php 
 // Ensure session starts here
 if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to continue.'); window.location='" . APPURL . "';</script>";
 }
$id = $_GET['show_id'];

// Fetch anime details
$show = $conn->prepare("SELECT shows.id AS id, shows.image_portrait as image, shows.title as title, 
                      shows.genre as genre, shows.studios as studios, shows.type as type, 
                      shows.date_aired as date_aired, shows.duration as duration, 
                      shows.description as description, shows.status as status, 
                      count(views.show_id) AS count_views 
                      FROM shows 
                      JOIN views ON shows.id = views.show_id 
                      WHERE shows.id = '$id' 
                      GROUP BY shows.id");
$show->execute();

$singleShow = $show->fetch(PDO::FETCH_OBJ);

// Fetch recommended shows
$forYouShows = $conn->query("SELECT shows.id AS id, shows.image as image, shows.num_available as available, 
                             shows.num_total as total, shows.title as title, 
                             count(views.show_id) AS count_views 
                             FROM shows 
                             LEFT JOIN views ON shows.id = views.show_id 
                             GROUP BY shows.id 
                             ORDER BY views.show_id ASC");
$forYouShows->execute();
$allForyou = $forYouShows->fetchAll(PDO::FETCH_OBJ);

// Fetch comments
$comments = $conn->query("SELECT * FROM comments WHERE show_id='$id'");
$comments->execute();
$allComments = $comments->fetchAll(PDO::FETCH_OBJ);

// Check if user is logged in
if (isset($_SESSION['user_id'])) {

    // Follow Feature
    if (isset($_POST['submit'])) {
        $show_id = $_POST['show_id'];
        $user_id = $_SESSION['user_id'];

        $follow = $conn->prepare("INSERT INTO followings(show_id, user_id) VALUES(:show_id, :user_id)");
        $follow->execute([
            ":show_id" => $show_id,
            ":user_id" => $user_id
        ]);
        echo "<script>alert('You are following this show.')</script>";
    }

    // Check if user follows the show
    $showFollow = $conn->query("SELECT * FROM followings WHERE show_id='$id' AND user_id='{$_SESSION['user_id']}'");
    $showFollow->execute();

    // Insert Comments
    if (isset($_POST["inserting_comments"])) {
        if (empty($_POST['comment'])) {
            echo "<script>alert('Comment is empty.')</script>";
        } else {
            $comment = $_POST['comment'];
            $show_id = $id;
            $user_id = $_SESSION['user_id'];
            $username = $_SESSION['username'];

            $insert = $conn->prepare("INSERT INTO comments(comment, show_id, user_id, username)
                                      VALUES(:comment, :show_id, :user_id, :username)");
            $insert->execute([
                ":comment" => $comment,
                ":show_id" => $show_id,
                ":user_id" => $user_id,
                ":username" => $username
            ]);
            header("Location: " . APPURL . "/anime-details.php?id=" . $id);
            exit;
        }
    }


    // Insert Views (Only if logged in)
    $checkViews = $conn->query("SELECT * FROM views WHERE show_id='$id' AND user_id='{$_SESSION['user_id']}'");
    $checkViews->execute();

    if ($checkViews->rowCount() == 0) {
        $insertView = $conn->prepare("INSERT INTO views(show_id, user_id) VALUES(:show_id, :user_id)");
        $insertView->execute([
            ":show_id" => $id,
            ":user_id" => $_SESSION['user_id']
        ]);
    }
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
                        <span><?php echo $singleShow->genre; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="anime-details spad">
        <div class="container">
            <div class="anime__details__content">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="anime__details__pic set-bg" data-setbg="<?php echo IMGURL; ?>/<?php echo $singleShow->image; ?>">
                            <div class="view"><i class="fa fa-eye"></i> <?php echo $singleShow->count_views; ?></div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3><?php echo $singleShow->title; ?></h3>
                            </div>
                           
                            <p><?php echo $singleShow->description; ?></p>
                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Type:</span> <?php echo $singleShow->type; ?></li>
                                            <li><span>Studios:</span> <?php echo $singleShow->studios; ?></li>
                                            <li><span>Date aired:</span> <?php echo $singleShow->date_aired; ?></li>
                                            <li><span>Status:</span> <?php echo $singleShow->status; ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Genre:</span> <?php echo $singleShow->genre; ?></li>

                                            <li><span>Duration:</span> <?php echo $singleShow->duration; ?></li>
                                            <li><span>Views:</span> <?php echo $singleShow->count_views; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="anime__details__btn">
                                <form method="POST" action="anime-details.php?id=<?php echo $id; ?>">
                                    <input type="hidden" value="<?php echo $id; ?>" name="show_id">
                                    <input type="hidden" value="<?php echo $_SESSION['user_id']; ?>" name="user_id">
                                    <?php if($showFollow->rowCount() > 0) : ?>
                                        <button style="background-color:grey;" name="submit" type="submit" class="follow-btn" disabled><i class="fa fa-heart-o"></i> Followed</button>
                                    <?php else : ?>
                                        <button name="submit" type="submit" class="follow-btn"><i class="fa fa-heart-o"></i> Follow</button>
                                    <?php endif; ?>
                                    <a href="<?php echo APPURL; ?>/anime-watching.php?id=<?php echo $id; ?>&ep=1" class="watch-btn"><span>Watch Now</span> <i
                                    class="fa fa-angle-right"></i></a>    
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <div class="anime__details__review">
                            <div class="section-title">
                                <h5>Comments</h5>
                            </div>
                            <?php foreach($allComments as $comment) : ?>
                            <div class="anime__review__item">
                                <!--<div class="anime__review__item__pic">
                                    <img src="img/anime/review-1.jpg" alt="">
                                </div> -->
                                <div class="anime__review__item__text">
                                    <h6><?php echo $comment->username; ?><span> <?php echo $comment->created_at; ?></span></h6>
                                    <p><?php echo $comment->comment; ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="anime__details__form">
                            <div class="section-title">
                                <h5>Your Comment</h5>
                            </div>
                            <form method="POST" action="<?php echo APPURL; ?>/anime-details.php?id=<?php echo $id; ?>">
                                <textarea name="comment" placeholder="Your Comment"></textarea>
                                <button name="inserting_comments" type="submit"><i class="fa fa-location-arrow"></i> Comment</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="anime__details__sidebar">
                            <div class="section-title">
                                <h5>you might like...</h5>
                            </div>
                            <?php foreach($allForyou as $foryou) : ?>
                            <div class="product__sidebar__view__item set-bg" data-setbg="<?php echo IMGURL; ?>/<?php echo $foryou->image; ?>">
                                <div class="ep"><?php echo $foryou->available; ?> / <?php echo $foryou->total; ?></div>
                                <div class="view"><i class="fa fa-eye"></i> <?php echo $foryou->count_views; ?></div>
                                <h5 style="background-color:rgba(0,0,0, 0.5); width:fit-content;"><a href="<?php echo APPURL; ?>/anime-details.php?id=<?php echo $foryou->id; ?>"><?php echo $foryou->title; ?></a></h5>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Anime Section End -->
<?php require "includes/footer.php"; ?>
