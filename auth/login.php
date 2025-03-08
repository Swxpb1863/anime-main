<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

if (isset($_SESSION['username'])) {
    echo "<script>location.href='".APPURL."'</script>"; // Redirect to homepage
}
    if(isset($_POST['submit'])) {
        if(empty($_POST['email']) || empty($_POST['password'])) {
            echo "<script>alert('One or more inputs are empty');</script>";
        } else {
            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);

            // Prepare and execute query properly
            $login = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $login->bindParam(':email', $email, PDO::PARAM_STR);
            $login->execute();

            $fetch = $login->fetch(PDO::FETCH_ASSOC);

            if($fetch) { // If user exists
                if(password_verify($password, $fetch['password'])) {
                    $_SESSION['username'] = $fetch['username'];
                    $_SESSION['email'] = $fetch['email'];
                    $_SESSION['user_id'] = $fetch['id'];
                    echo "<script>location.href='".APPURL."'</script>";
                    exit();
                } else {
                    echo "<script>alert('Email or password is incorrect');</script>";
                }
            } else {
                echo "<script>alert('Email or password is incorrect');</script>";
            }
        }
    }
?>

    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="<?php echo APPURL; ?>/img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Login</h2>
                        <p>Welcome to the official Anime blog.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Login Section Begin -->
    <section class="login spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>Login</h3>
                        <form action="login.php" method="POST">
                            <div class="input__item">
                                <input name="email" type="text" placeholder="Email address">
                                <span class="icon_mail"></span>
                            </div>
                            <div class="input__item">
                                <input name="password" type="password" placeholder="Password">
                                <span class="icon_lock"></span>
                            </div>
                            <button name="submit" type="submit" class="site-btn">Login Now</button>
                        </form>
                        <!-- <a href="#" class="forget_pass">Forgot Your Password?</a> -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__register">
                        <h3>Dont’t Have An Account?</h3>
                        <a href="signup.php" class="primary-btn">Register Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Section End -->
<?php require "../includes/footer.php"; ?>