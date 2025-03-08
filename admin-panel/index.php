<?php require "layouts/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
  if (!isset($_SESSION['admin_name'])) {
    header("location: ".ADMINURL."/admins/login-admins.php"); // Redirect to homepage
  }
  $shows = $conn->query("SELECT COUNT(*) as shows_count from shows");
  $shows->execute();

  $allShows = $shows->fetch(PDO::FETCH_OBJ);

  $episodes = $conn->query("SELECT COUNT(*) as episodes_count from episodes");
  $episodes->execute();

  $allEpisodes = $episodes->fetch(PDO::FETCH_OBJ);

  $genres = $conn->query("SELECT COUNT(*) as genres_count from genres");
  $genres->execute();

  $allGenres = $genres->fetch(PDO::FETCH_OBJ);

  $admins = $conn->query("SELECT COUNT(*) as admins_count from admins");
  $admins->execute();

  $allAdmins = $admins->fetch(PDO::FETCH_OBJ);

?>

      <div class="row">
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Shows</h5>
              <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
              <p class="card-text">number of shows: <?php echo $allShows->shows_count; ?></p>
             
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Episodes</h5>
              
              <p class="card-text">number of episodes: <?php echo $allEpisodes->episodes_count; ?></p>
              
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Genres</h5>
              
              <p class="card-text">number of genres: <?php echo $allGenres->genres_count; ?></p>
              
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Admins</h5>
              
              <p class="card-text">number of admins: <?php echo $allAdmins->admins_count; ?></p>
              
            </div>
          </div>
        </div>
      </div>
   
            
<?php require "layouts/footer.php"; ?>
