<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php 
    if(isset($_POST["submit"])){
        if(empty($_POST['keyword'])){
            echo "<script>location.href='".APPURL."'</script>";
        }else{
            $keyword = $_POST['keyword'];
            $search = $conn->query("SELECT shows.id AS id, shows.image_portrait as image, shows.num_available as available, shows.num_total as total, shows.title as title, shows.type as type, shows.genre as genre, shows.status as status FROM shows WHERE title LIKE '%$keyword%'");
            $search->execute();

            $allSearch = $search->fetchAll(PDO::FETCH_OBJ);
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
                        <a href="<?php echo APPURL; ?>/users/followings.php">Search</a>
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
                                        <h4>Search results</h4>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                        <div class="row">
                            <?php if(count($allSearch) > 0) : ?>
                            <?php foreach($allSearch as $show) : ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="<?php echo IMGURL; ?>/<?php echo $show->image; ?>">
                                        <div class="ep"><?php echo $show->available; ?> / <?php echo $show->total; ?></div>
                                        <!-- <div class="view"><i class="fa fa-eye"></i></div> -->
                                    </div>
                                    <div class="product__item__text">
                                        <ul>
                                            <li><?php echo $show->type; ?></li>
                                            <li><?php echo $show->status; ?></li>
                                        </ul>
                                        <h5><a href="<?php echo APPURL; ?>/anime-details.php?id=<?php echo $show->id; ?>"><?php echo $show->title; ?></a></h5>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else : ?>
                                <p class="text-white">No shows found.</p>
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



<?php require "includes/footer.php"; ?>