<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?> 

<?php

if (isset($_SESSION['admin_name'])) {
    header("location: ".ADMINURL.""); // Redirect to homepage
}

    if(isset($_POST['submit'])) {
        if(empty($_POST['email']) || empty($_POST['password'])) {
            echo "<script>alert('One or more inputs are empty');</script>";
        } else {
            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);

            // Prepare and execute query properly
            $login = $conn->prepare("SELECT * FROM admins WHERE email = :email");
            $login->bindParam(':email', $email, PDO::PARAM_STR);
            $login->execute();

            $fetch = $login->fetch(PDO::FETCH_ASSOC);

            if($login->rowCount() > 0) { // If user exists
                if(password_verify($password, $fetch['password'])) {
                    $_SESSION['admin_name'] = $fetch['admin_name'];
                    $_SESSION['email'] = $fetch['email'];
                    $_SESSION['admin_id'] = $fetch['id'];
                    echo "<script>location.href='".ADMINURL."'</script>";
                    exit();
                    //echo "<script>alert('LOGGED IN SUCCESSFULLY!');</script>";
                } else {
                    echo "<script>alert('Email or password is incorrect');</script>";
                }
            } else {
                echo "<script>alert('Email or password is incorrect');</script>";
            }
        }
    }
?>

      <div class="row">
        <div class="col">
          <div class="card" style="width: 870px;">
            <div class="card-body">
              <h5 class="card-title mt-5">Login</h5>
              <form method="POST" class="p-auto" action="login-admins.php">
                  <!-- Email input -->
                  <div class="form-outline mb-4">
                    <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />
                   
                  </div>

                  
                  <!-- Password input -->
                  <div class="form-outline mb-4">
                    <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />
                    
                  </div>



                  <!-- Submit button -->
                  <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Login</button>

                 
                </form>

            </div>
       </div>
     </div>
<?php require "../layouts/footer.php"; ?>