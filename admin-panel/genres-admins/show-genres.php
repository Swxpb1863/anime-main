<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php 
    if (!isset($_SESSION['admin_name'])) {
      header("location: ".ADMINURL.""); // Redirect to homepage
    }
    
  $genres = $conn->query("SELECT * from genres");
  $genres->execute();

  $allGenres = $genres->fetchAll(PDO::FETCH_OBJ);


?>

          <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Genres</h5>
              <a  href="create-genres.php" class="btn btn-primary mb-4 text-center float-right">Create Genres</a>

              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    
                    <th scope="col">delete</th>
                  </tr>
                </thead>
                <?php foreach ($allGenres as $genre) : ?> 
                <tbody>
                  <tr>
                     <th scope="row"><?php echo $genre->id; ?></th>
                     <td><?php echo $genre->name; ?></td>
                    
                     <td><a href="delete-genres.php?id=<?php echo $genre->id; ?>" class="btn btn-danger  text-center ">delete</a></td>
                  </tr>
                </tbody>
                <?php endforeach; ?>
              </table> 
            </div>
          </div>
        </div>
      </div>


<?php require "../layouts/footer.php"; ?>