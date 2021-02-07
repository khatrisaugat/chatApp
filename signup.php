<?php
require_once("config/config.php");
require_once("config/db.php");
$countries = $obj->select("country");
if (isset($_POST['signup'])) {
    unset($_POST['signup']);
    $_POST['password'] = md5($_POST['password']);
    $obj->Insert("user", $_POST);
}


// $pagePath=root('pages/'.$url);
require_once root('layouts/header.php');
?>
<div class="container-fluid" id="login-bg">
    <div class="col-sm-12  login-bg">
        <!-- <div class="col-sm-4"> -->
        <div class="card text-center  col-sm-4 login-card ">
            <div class="card-header log-in">
                <h2>Sign Up</h2>
            </div>
            <div class="card-body">
                <!-- <h2 class="card-title">Log In</h2> -->
                <form action="" method="post">

                    <label for="username">
                        <h5>Username</h5>
                    </label>
                    <input type="text" class="form-control" name="username" id="username" required>
                    <label for="email">
                        <h5>Email</h5>
                    </label>
                    <input type="text" class="form-control" name="email" id="email" required>
                    <label for="password">
                        <h5>Password</h5>
                    </label>
                    <input type="password" class="form-control" name="password" id="password" required>
                    <label for="confirm">
                        <h5>Confirm Password</h5>
                    </label>
                    <input type="password" id="confirm" class="form-control">
                    <label for="country">
                        <h5>Country</h5>
                    </label>
                    <select name="country" id="country" class="form-control">
                        <option value="" selected disabled>Select Country</option>
                        <?php foreach ($countries as $country) :  ?>
                            <option value="<?= $country['countrycode'] ?>"><?= $country['countryname'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="gender">
                        <h5>Gender</h5>
                    </label><br>
                    <input type="radio" value="male" name="gender"> <label for="male">Male</label>
                    <input type="radio" value="female" name="gender"> <label for="female">Female</label>
                    <input type="radio" value="other" name="gender"> <label for="other">Other</label>
                    <br>
                    <button type="submit" class="btn btn-warning mt-3" name="signup">Sign Up</button>
                </form>
                <br>
                <h3>Already have an account? <a href="./login.php">Log In</a></h3>
            </div>
        </div>
        <!-- </div> -->
    </div>
</div>
<?php
require_once root('layouts/footer.php');
?>