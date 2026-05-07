<?php

$loginError = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['login'])) {

        $email = htmlspecialchars($_POST['loginEmail']);
        $password = htmlspecialchars($_POST['loginPassword']);

        if ($email === "admin@example.com" && $password === "Admin123!") {

            $successMessage = "Login successful!";

        } else {

            $loginError = "Invalid email or password.";
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

    <title>PadelPro - Login</title>

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

                        <h2>Welcome Back!</h2>

                        <p>Sign in to your account</p>

                    </div>

                    <div class="auth-card-body">

                        <?php if (!empty($successMessage)) : ?>

                            <div class="alert alert-success">
                                <?php echo $successMessage; ?>
                            </div>

                        <?php endif; ?>

                        <?php if (!empty($loginError)) : ?>

                            <div class="alert alert-danger">
                                <?php echo $loginError; ?>
                            </div>

                        <?php endif; ?>

                        <form method="POST">

                            <div class="form-group">

                                <label>Email Address</label>

                                <input type="email"
                                       class="form-control"
                                       name="loginEmail"
                                       required>

                            </div>

                            <div class="form-group">

                                <label>Password</label>

                                <input type="password"
                                       class="form-control"
                                       name="loginPassword"
                                       required>

                            </div>

                            <button type="submit"
                                    name="login"
                                    class="btn btn-primary btn-block">

                                Login

                            </button>

                        </form>

                        <div class="text-center mt-3">

                            Don't have an account?

                            <a href="register.php">
                                Register here
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