<?php

$signupError = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['signup'])) {

        $name = htmlspecialchars($_POST['signupName']);
        $email = htmlspecialchars($_POST['signupEmail']);

        $password = $_POST['signupPassword'];

        $confirmPassword = $_POST['signupConfirmPassword'];

        if ($password !== $confirmPassword) {

            $signupError = "Passwords do not match.";

        } else {

            $successMessage = "Account created successfully!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>PadelPro - Register</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="../../css/login_signup.css">

</head>

<body>

<section class="auth-section py-5">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-6 col-lg-5">

                <div class="auth-card">

                    <div class="auth-card-header text-center">

                        <h2>Create Account</h2>

                        <p>Join PadelPro today</p>

                    </div>

                    <div class="auth-card-body">

                        <?php if (!empty($successMessage)) : ?>

                            <div class="alert alert-success">
                                <?php echo $successMessage; ?>
                            </div>

                        <?php endif; ?>

                        <?php if (!empty($signupError)) : ?>

                            <div class="alert alert-danger">
                                <?php echo $signupError; ?>
                            </div>

                        <?php endif; ?>

                        <form method="POST">

                            <div class="form-group">

                                <label>Full Name</label>

                                <input type="text"
                                       class="form-control"
                                       name="signupName"
                                       required>

                            </div>

                            <div class="form-group">

                                <label>Email Address</label>

                                <input type="email"
                                       class="form-control"
                                       name="signupEmail"
                                       required>

                            </div>

                            <div class="form-group">

                                <label>Password</label>

                                <input type="password"
                                       class="form-control"
                                       name="signupPassword"
                                       required>

                            </div>

                            <div class="form-group">

                                <label>Confirm Password</label>

                                <input type="password"
                                       class="form-control"
                                       name="signupConfirmPassword"
                                       required>

                            </div>

                            <button type="submit"
                                    name="signup"
                                    class="btn btn-primary btn-block">

                                Register

                            </button>

                        </form>

                        <div class="text-center mt-3">

                            Already have an account?

                            <a href="login.php">
                                Login here
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

</body>
</html>