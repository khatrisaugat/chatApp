<?php
require_once("config/config.php");
require_once("config/db.php");


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $user_select = $obj->Query("SELECT * FROM user WHERE email='$email' and password='$password'");

    if ($user_select) {
        $user_select = $user_select[0];
        session_start();
        $_SESSION['users_data'] = $user_select;
        $_SESSION['id'] = $user_select->id;
        $_SESSION['status'] = "Success";
        $_SESSION['login'] = 'yes';
        header('Location:' . base_url());
    } else {
        session_start();
        $_SESSION['error'] = "Email or Password Incorrect. Please Check..";
    }
}


// $pagePath=root('pages/'.$url);
require_once root('layouts/header.php');
?>
<div class="container-fluid" id="login-bg">
    <div class="col-sm-12  login-bg">
        <!-- <div class="col-sm-4"> -->
        <div class="card text-center  col-sm-4 login-card ">
            <div class="card-header log-in">
                <h2>Log In</h2>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['error'])) { ?>
                    <h2 class="card-title alert alert-primary"><?= $_SESSION['error']; ?></h2>
                <?php
                } ?>

                <form action="" method="post">
                    <label for="email">
                        <h5>Email</h5>
                    </label>
                    <input type="text" class="form-control" name="email" id="email" required>
                    <label for="password">
                        <h5>Password</h5>
                    </label>
                    <input type="password" class="form-control" name="password" id="password" required>
                    <button type="submit" class="btn btn-warning mt-3" name="login">Log In</button>
                </form>
                <br>
                <h3>Don't have an account? <a href="./signup.php">Sign Up</a></h3>
            </div>
        </div>
        <!-- </div> -->
    </div>
</div>
<?php
require_once root('layouts/footer.php');
?>