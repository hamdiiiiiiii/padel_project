<<<<<<< Updated upstream
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/../../core/Database.php';

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if(empty($email) || empty($password)) {
        $error = 'Please enter email and password';
    } else {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            
            if($user['role'] === 'admin') {
                header('Location: /padel_project/padel_project/admin.php');
            } else {
                header('Location: /padel_project/padel_project/home.php');
            }
            exit();
        } else {
            $error = 'Invalid email or password';
        }
    }
}

$activePage = 'login';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login - PadelPro</title>
    
    <link rel="stylesheet" href="/padel_project/padel_project/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>

<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card">
                    <div class="auth-card-header text-center">
                        <div class="logo-wrapper">
                            <span class="logo-icon">🎾</span>
                            <span class="logo-text">PadelPro</span>
                        </div>
                        <h2>Welcome Back!</h2>
                        <p>Sign in to continue your journey</p>
                    </div>
                    <div class="auth-card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope"></i> Email Address
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-control" 
                                       placeholder="admin@example.com"
                                       value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">
                                    <i class="fas fa-lock"></i> Password
                                </label>
                                <div class="password-input-wrapper">
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="form-control" 
                                           placeholder="Enter your password"
                                           required>
                                    <button type="button" class="toggle-password-btn" data-target="password">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="form-options">
                                <label class="remember-me">
                                    <input type="checkbox" name="remember_me"> 
                                    <span>Remember me</span>
                                </label>
                                <a href="#" id="forgotPasswordBtn" class="forgot-link">Forgot Password?</a>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-login">
                                Sign In <i class="fas fa-arrow-right"></i>
                            </button>
                            
                            <div class="register-link">
                                Don't have an account? 
                                <a href="/padel_project/padel_project/views/auth/register.php">Create Account</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Forgot Password Modal -->
<div id="forgotPasswordModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <h3><i class="fas fa-key"></i> Reset Password</h3>
            <button class="modal-close" onclick="closeForgotPasswordModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Enter your email address and we'll send you a link to reset your password.</p>
            <form id="forgotPasswordForm" method="POST" action="/padel_project/padel_project/forgot-password.php">
                <div class="form-group">
                    <label for="reset_email">Email Address</label>
                    <input type="email" 
                           id="reset_email" 
                           name="email" 
                           class="form-control" 
                           placeholder="example@domain.com"
                           required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    Send Reset Link
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-password-btn').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
});

function openForgotPasswordModal() {
    const modal = document.getElementById('forgotPasswordModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    setTimeout(() => {
        document.getElementById('reset_email').focus();
    }, 100);
}

function closeForgotPasswordModal() {
    const modal = document.getElementById('forgotPasswordModal');
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

window.addEventListener('click', function(e) {
    const modal = document.getElementById('forgotPasswordModal');
    if (e.target === modal) {
        closeForgotPasswordModal();
    }
});

document.getElementById('forgotPasswordBtn')?.addEventListener('click', function(e) {
    e.preventDefault();
    openForgotPasswordModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeForgotPasswordModal();
    }
});
</script>

</body>
=======
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//session_start();
require_once __DIR__ . '/../../core/Database.php';

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if(empty($email) || empty($password)) {
        $error = 'Please enter email and password';
    } else {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            
            if($user['role'] === 'admin') {
                header('Location: /padel_project/padel_project/admin.php');
            } else {
                header('Location: /padel_project/padel_project/home.php');
            }
            exit();
        } else {
            $error = 'Invalid email or password';
        }
    }
}

$activePage = 'login';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login - PadelPro</title>
    
    <link rel="stylesheet" href="/padel_project/padel_project/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>

<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card">
                    <div class="auth-card-header text-center">
                        <div class="logo-wrapper">
                            <span class="logo-icon">🎾</span>
                            <span class="logo-text">PadelPro</span>
                        </div>
                        <h2>Welcome Back!</h2>
                        <p>Sign in to continue your journey</p>
                    </div>
                    <div class="auth-card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope"></i> Email Address
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-control" 
                                       placeholder="admin@example.com"
                                       value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">
                                    <i class="fas fa-lock"></i> Password
                                </label>
                                <div class="password-input-wrapper">
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="form-control" 
                                           placeholder="Enter your password"
                                           required>
                                    <button type="button" class="toggle-password-btn" data-target="password">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="form-options">
                                <label class="remember-me">
                                    <input type="checkbox" name="remember_me"> 
                                    <span>Remember me</span>
                                </label>
                                <a href="#" id="forgotPasswordBtn" class="forgot-link">Forgot Password?</a>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-login">
                                Sign In <i class="fas fa-arrow-right"></i>
                            </button>
                            
                            <div class="register-link">
                                Don't have an account? 
                                <a href="/padel_project/padel_project/views/auth/register.php">Create Account</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Forgot Password Modal -->
<div id="forgotPasswordModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <h3><i class="fas fa-key"></i> Reset Password</h3>
            <button class="modal-close" onclick="closeForgotPasswordModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Enter your email address and we'll send you a link to reset your password.</p>
            <form id="forgotPasswordForm" method="POST" action="/padel_project/padel_project/forgot-password.php">
                <div class="form-group">
                    <label for="reset_email">Email Address</label>
                    <input type="email" 
                           id="reset_email" 
                           name="email" 
                           class="form-control" 
                           placeholder="example@domain.com"
                           required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    Send Reset Link
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-password-btn').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
});

function openForgotPasswordModal() {
    const modal = document.getElementById('forgotPasswordModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    setTimeout(() => {
        document.getElementById('reset_email').focus();
    }, 100);
}

function closeForgotPasswordModal() {
    const modal = document.getElementById('forgotPasswordModal');
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

window.addEventListener('click', function(e) {
    const modal = document.getElementById('forgotPasswordModal');
    if (e.target === modal) {
        closeForgotPasswordModal();
    }
});

document.getElementById('forgotPasswordBtn')?.addEventListener('click', function(e) {
    e.preventDefault();
    openForgotPasswordModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeForgotPasswordModal();
    }
});
</script>

</body>
>>>>>>> Stashed changes
</html>