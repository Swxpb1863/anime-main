<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php

      if(isset($_POST["submit"])){
        if(empty($_POST['title']) OR empty($_POST['description']) OR empty($_POST['studios']) OR empty($_POST['type']) OR empty($_POST['status']) OR empty($_POST['date_aired']) OR empty($_POST['genre']) OR empty($_POST['num_available']) OR empty($_POST['num_total']) OR empty($_POST['duration'])){
            echo "<script>alert('one or more inputs are empty')</script>";
        }else{
            $title = $_POST["title"];
            $description = $_POST["description"];
            $studios = $_POST["studios"];
            $type = $_POST["type"];
            $status = $_POST["status"];
            $date_aired = $_POST["date_aired"];
            $genre = $_POST["genre"];
            $num_available = $_POST["num_available"];
            $num_total = $_POST["num_total"];
            $duration = $_POST["duration"];
            $image = $_FILES['image']['name'];
            $image_portrait = $_FILES['image_portrait']['name'];

            $dir1 = "images/" . basename($image);
            $dir2 = "images/" . basename($image_portrait);

            $insert = $conn->prepare("INSERT INTO shows(title, description, studios, type, status, date_aired, genre, num_available, num_total, duration, image, image_portrait)
            VALUE(:title, :description, :studios, :type, :status, :date_aired, :genre, :num_available, :num_total, :duration, :image, :image_portrait)");
            $insert->execute([
                ":title" => $title,
                ":description" => $description,
                ":studios" => $studios,
                ":type" => $type,
                ":status" => $status,
                ":date_aired" => $date_aired,
                ":genre" => $genre,
                ":num_available" => $num_available,
                ":num_total" => $num_total,
                ":duration" => $duration,
                ":image_portrait" => $image_portrait,
                ":image" => $image            
            ]);

            if(move_uploaded_file($_FILES['image']['tmp_name'], $dir1)){
              header("location: show-shows.php");
            }
            if(move_uploaded_file($_FILES['image_portrait']['tmp_name'], $dir2)){
              header("location: show-shows.php");
            }
        }
    }

?>

       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Shows</h5>
          <form method="POST" action="create-shows.php" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="title" id="form2Example1" class="form-control" placeholder="title" />
                 
                </div>
                <div class="form-outline mb-4 mt-4">
                    <input type="file" name="image" id="form2Example1" class="form-control">Choose Landscape Image</input>
                   
                </div>
                <div class="form-outline mb-4 mt-4">
                    <input type="file" name="image_portrait" id="form2Example1" class="form-control">Choose Portrait Image</input>
                   
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Description</label>
                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="form-outline mb-4 mt-4">

                    <select name="type" class="form-select  form-control" aria-label="Default select example">
                      <option selected>Choose Type</option>
                      <option value="Tv Series">Tv Series</option>
                      <option value="Movie">Movie</option>
                      
                    </select>
                </div>
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="studios" id="form2Example1" class="form-control" placeholder="studios" />
                 
                </div>
                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="date_aired" id="form2Example1" class="form-control" placeholder="date_aired" />
                   
                </div>
                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="status" id="form2Example1" class="form-control" placeholder="status" />
                   
                </div>
                <div class="form-outline mb-4 mt-4">

                    <select name="genre" class="form-select  form-control" aria-label="Default select example">
                      <option selected>Choose Genre</option>
                      <option value="Thriller">Thriller</option>
                      <option value="Action">Action</option>
                      <option value="Adventure">Adventure</option>
                      <option value="Fantasy">Fantasy</option>
                    </select>
                </div>
                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="duration" id="form2Example1" class="form-control" placeholder="duration" />
                   
                </div>
                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="num_available" id="form2Example1" class="form-control" placeholder="num_available" />
                   
                </div>
                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="num_total" id="form2Example1" class="form-control" placeholder="num_total" />
                   
                </div>
              

                <br>
              

      
                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>
        </div>
        <?php require "../layouts/footer.php"; ?>