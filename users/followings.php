<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
    $user_id = $_SESSION['user_id'];
    $followings = $conn->query("SELECT shows.id AS id, shows.image_portrait as image, shows.num_available as available, shows.num_total as total, shows.title as title, shows.type as type, shows.genre as genre, shows.status as status, followings.show_id, followings.user_id as user_id FROM shows JOIN followings ON shows.id = followings.show_id WHERE followings.user_id = '$user_id'");
    $followings->execute();

    $allFollowings = $followings->fetchAll(PDO::FETCH_OBJ);

?>
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="<?php echo APPURL; ?>"><i class="fa fa-home"></i> Home</a>
                        <a href="<?php echo APPURL; ?>/users/followings.php">Following</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Section Begin -->
    <section class="product-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="product__page__content">
                        <div class="product__page__title">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-6">
                                    <div class="section-title">
                                        <h4>Shows that you follow</h4>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                        <div class="row">
                            <?php if(count($allFollowings) > 0) : ?>
                            <?php foreach($allFollowings as $following) : ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="../img/dummyss/<?php echo $following->image; ?>">
                                        <div class="ep"><?php echo $following->available; ?> / <?php echo $following->total; ?></div>
                                        <!-- <div class="view"><i class="fa fa-eye"></i></div> -->
                                    </div>
                                    <div class="product__item__text">
                                        <ul>
                                            <li><?php echo $following->type; ?></li>
                                            <li><?php echo $following->status; ?></li>
                                        </ul>
                                        <h5><a href="<?php echo APPURL; ?>/anime-details.php?id=<?php echo $following->id; ?>"><?php echo $following->title; ?></a></h5>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else : ?>
                                <p class="text-white">Shows that you follow will be shown here!</p>
                            <?php endif; ?>
                        </div>
                    </div>
                   
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">
                        <div class="product__sidebar__view">
                        </div>
                    <!-- </div>
                </div>         -->
    </div>
</div>
</div>
</div>
</div>
</section>
<!-- Product Section End -->
<?php require "../includes/footer.php"; ?>