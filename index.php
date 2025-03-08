<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php
    $shows = $conn->query("SELECT * FROM shows LIMIT 4");
    $shows->execute();

    $allShows = $shows->fetchAll(PDO::FETCH_OBJ);

    $trendingShows = $conn->query("SELECT shows.id AS id, shows.image_portrait as image, shows.num_available as available, shows.num_total as total, shows.title as title, shows.genre as genre, shows.status as status, count(views.show_id) AS count_views FROM shows JOIN views ON shows.id = views.show_id GROUP BY(shows.id) ORDER BY count_views DESC");
    $trendingShows->execute();

    $allTrending = $trendingShows->fetchAll(PDO::FETCH_OBJ);

    $adventureShows = $conn->query("SELECT shows.id AS id, shows.image_portrait as image, shows.num_available as available, shows.num_total as total, shows.title as title, shows.genre as genre, shows.status as status, count(views.show_id) AS count_views FROM shows JOIN views ON shows.id = views.show_id where genre = 'Adventure' GROUP BY(shows.id) ORDER BY views.show_id ASC");
    $adventureShows->execute();

    $allAdventure = $adventureShows->fetchAll(PDO::FETCH_OBJ);

    $recentlyAddedShows = $conn->query("SELECT shows.created_at AS created_at, shows.id AS id, shows.image_portrait as image, shows.num_available as available, shows.num_total as total, shows.title as title, shows.genre as genre, shows.status as status, count(views.show_id) AS count_views FROM shows JOIN views ON shows.id = views.show_id GROUP BY(shows.id) ORDER BY shows.created_at DESC");
    $recentlyAddedShows->execute();

    $allRecent = $recentlyAddedShows->fetchAll(PDO::FETCH_OBJ);

    $liveActionShows = $conn->query("SELECT shows.id AS id, shows.image_portrait as image, shows.num_available as available, shows.num_total as total, shows.title as title, shows.genre as genre, shows.status as status, count(views.show_id) AS count_views FROM shows JOIN views ON shows.id = views.show_id where genre = 'Action' GROUP BY(shows.id) ORDER BY views.show_id ASC");
    $liveActionShows->execute();

    $allAction = $liveActionShows->fetchAll(PDO::FETCH_OBJ);

    $forYouShows = $conn->query("SELECT shows.id AS id, shows.image_portrait as image, shows.num_available as available, shows.num_total as total, shows.title as title, shows.genre as genre, shows.status as status, shows.type as type, count(views.show_id) AS count_views FROM shows JOIN views ON shows.id = views.show_id GROUP BY(shows.id) ORDER BY views.show_id ASC");
    $forYouShows->execute();

    $allForyou = $forYouShows->fetchAll(PDO::FETCH_OBJ);


?>
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="hero__slider owl-carousel">
                <?php foreach ($allShows as $show): ?>
                <div class="hero__items set-bg" data-setbg="<?php echo IMGURL; ?>/<?php echo $show->image; ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <div class="label"><?php echo $show->genre; ?></div>
                                <h2 style="margin-top: 2px; -webkit-text-stroke: 1px #2B1B17;"><?php echo $show->title; ?></h2>
                                <p style="background-color:rgba(0,0,0, 0.5); 1; padding: 5px;"><?php echo $show->description; ?></p>
                                <a href="<?php echo APPURL; ?>/anime-watching.php?id=<?php echo $show->id; ?>&ep=1"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="trending__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Trending Now</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <!--<div class="btn__all">
                                    <a href="#" class="primary-btn">View All <span class="arrow_right"></span></a>
                                </div>-->
                            </div>
                        </div>
                        <div class="row">
                            <?php foreach($allTrending as $trending) : ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="<?php echo IMGURL; ?>/<?php echo $trending->image; ?>">
                                        <div class="ep"><?php echo $trending->available; ?> / <?php echo $trending->total; ?></div>
                                        
                                        <div class="view"><i class="fa fa-eye"></i> <?php echo $trending->count_views; ?></div>
                                    </div>
                                    <div class="product__item__text">
                                        <ul>
                                            <li><?php echo $trending->genre; ?></li>
                                            <li><?php echo $trending->status; ?></li>
                                        </ul>
                                        <h5><a href="<?php echo APPURL; ?>/anime-details.php?id=<?php echo $trending->id; ?>"><?php echo $trending->title; ?></a></h5>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="popular__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Adventure Shows</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="<?php echo APPURL; ?>/categories.php?name=Adventure" class="primary-btn">View All <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php foreach($allAdventure as $adventure) : ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="<?php echo IMGURL; ?>/<?php echo $adventure->image; ?>">
                                        <div class="ep"><?php echo $adventure->available; ?> / <?php echo $adventure->total; ?></div>
                                        <div class="view"><i class="fa fa-eye"></i> <?php echo $adventure->count_views; ?></div>
                                    </div>
                                    <div class="product__item__text">
                                        <ul>
                                            <li><?php echo $adventure->genre; ?></li>
                                            <li><?php echo $adventure->status; ?></li>
                                        </ul>
                                        <h5><a href="<?php echo APPURL; ?>/anime-details.php?id=<?php echo $adventure->id; ?>"><?php echo $adventure->title; ?></a></h5>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="recent__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Recently Added Shows</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <!--<div class="btn__all">
                                    <a href="<?php echo APPURL; ?>/categories.php?name=<?php ?>" class="primary-btn">View All <span class="arrow_right"></span></a>
                                </div>-->
                            </div>
                        </div>
                        <div class="row">
                            <?php foreach($allRecent as $recent) : ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="<?php echo IMGURL; ?>/<?php echo $recent->image; ?>">
                                        <div class="ep"><?php echo $recent->available; ?> / <?php echo $recent->total; ?></div>
                                        <div class="view"><i class="fa fa-eye"></i> <?php echo $recent->count_views; ?></div>
                                    </div>
                                    <div class="product__item__text">
                                        <ul>
                                            <li><?php echo $recent->genre; ?></li>
                                            <li><?php echo $recent->status; ?></li>
                                        </ul>
                                        <h5><a href="<?php echo APPURL; ?>/anime-details.php?id=<?php echo $recent->id; ?>"><?php echo $recent->title; ?></a></h5>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="live__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Live Action</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="<?php echo APPURL; ?>/categories.php?name=Action" class="primary-btn">View All <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php foreach($allAction as $action) : ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="<?php echo IMGURL; ?>/<?php echo $action->image; ?>">
                                        <div class="ep"><?php echo $action->available; ?> / <?php echo $action->total; ?></div>
                                        <div class="view"><i class="fa fa-eye"></i> <?php echo $action->count_views; ?></div>
                                    </div>
                                    <div class="product__item__text">
                                        <ul>
                                            <li><?php echo $action->genre; ?></li>
                                            <li><?php echo $action->status; ?></li>
                                        </ul>
                                        <h5><a href="<?php echo APPURL; ?>/anime-details.php?id=<?php echo $action->id; ?>"><?php echo $action->title; ?></a></h5>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">
                        <div class="product__sidebar__view">
        </div>
    </div>
    <div class="product__sidebar__comment">
        <div class="section-title">
            <h5>For You</h5>
        </div>
        <?php foreach($allForyou as $foryou) : ?>
        <div class="product__sidebar__comment__item">
            <div class="product__sidebar__comment__item__pic">
                <img style="width:150px; height:200px;" src="<?php echo IMGURL; ?>/<?php echo $foryou->image; ?>" alt="">
            </div>
            <div class="product__sidebar__comment__item__text">
                <ul>
                    <li><?php echo $foryou->genre; ?></li>
                    <li><?php echo $foryou->type; ?></li>
                </ul>
                <h5><a href="<?php echo APPURL; ?>/anime-details.php?id=<?php echo $foryou->id; ?>"><?php echo $foryou->title; ?></a></h5>
                <span><i class="fa fa-eye"></i> <?php echo $foryou->count_views; ?> Views</span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</div>
</div>
</div>
</section>
<!-- Product Section End -->
<?php require "includes/footer.php"; ?>