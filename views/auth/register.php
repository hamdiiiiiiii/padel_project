<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../../core/Database.php';

if (!defined('BASE_URL')) {
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    define('BASE_URL', rtrim($scriptDir, '/'));
}

$activePage = 'register';
$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !defined('REGISTER_HANDLED_BY_CONTROLLER')) {
    try {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = (string) ($_POST['password'] ?? '');
        $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

        $name = trim($firstName . ' ' . $lastName);

        if ($name === '' || $email === '' || $password === '') {
            $error = 'Name, email, and password are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif ($password !== $confirmPassword) {
            $error = 'Password and confirm password do not match.';
        } else {
            $db = Database::getInstance()->getConnection();

            $checkStmt = $db->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
            $checkStmt->execute(['email' => $email]);

            if ($checkStmt->fetch()) {
                $error = 'This email is already registered.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $insertStmt = $db->prepare(
                    'INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password_hash, :role)'
                );

                $ok = $insertStmt->execute([
                    'name' => $name,
                    'email' => $email,
                    'password_hash' => $hashedPassword,
                    'role' => 'user',
                ]);

                if ($ok) {
                    $success = 'Registration successful. Redirecting to login...';
                    header('Refresh: 2; url=' . BASE_URL . '/login');
                } else {
                    $error = 'Failed to create account. Please try again.';
                }
            }
        }
    } catch (Throwable $e) {
        $error = 'Registration error: ' . $e->getMessage();
    }
}
?>

<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="auth-card">
                    <div class="auth-card-header">
                        <h2>Create Your Account</h2>
                        <p>Join the best padel court booking platform</p>
                    </div>
                    <div class="auth-card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-custom" style="background-color: #fee; color: #dc3545; border: 1px solid #fcc;">
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($success)): ?>
                            <div class="alert alert-custom" style="background-color: #e8f5e9; color: #28a745; border: 1px solid #c8e6c9;">
                                <?php echo htmlspecialchars($success); ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo BASE_URL; ?>/register" id="registerForm" novalidate>
                            <!-- First Name & Last Name Row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" 
                                               id="first_name" 
                                               name="first_name" 
                                               class="form-control" 
                                               placeholder="Enter your first name"
                                               value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>"
                                               required>
                                        <div class="error-message" id="first_name_error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" 
                                               id="last_name" 
                                               name="last_name" 
                                               class="form-control" 
                                               placeholder="Enter your last name"
                                               value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>"
                                               required>
                                        <div class="error-message" id="last_name_error"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-control" 
                                       placeholder="example@domain.com"
                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                       required>
                                <small class="text-muted" style="font-size: 12px;">Must contain @, domain (e.g., .com), and no spaces</small>
                                <div class="error-message" id="email_error"></div>
                            </div>

                            <!-- Password Field -->
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="position-relative">
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="form-control" 
                                           placeholder="Create a strong password"
                                           required>
                                    <button type="button" class="toggle-password" data-target="password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #666;">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                                <small class="text-muted" style="font-size: 12px;">Create a strong password</small>
                                
                                <!-- Password Requirements -->
                                <div class="password-requirements">
                                    <div class="requirement" data-req="uppercase">
                                        <i class="far fa-circle"></i>
                                        <span>At least 1 uppercase letter (A-Z)</span>
                                    </div>
                                    <div class="requirement" data-req="lowercase">
                                        <i class="far fa-circle"></i>
                                        <span>At least 1 lowercase letter (a-z)</span>
                                    </div>
                                    <div class="requirement" data-req="number">
                                        <i class="far fa-circle"></i>
                                        <span>At least 1 number (0-9)</span>
                                    </div>
                                    <div class="requirement" data-req="special">
                                        <i class="far fa-circle"></i>
                                        <span>At least 1 special character (!@#$%^&*)</span>
                                    </div>
                                    <div class="requirement" data-req="length">
                                        <i class="far fa-circle"></i>
                                        <span>Minimum 8 characters</span>
                                    </div>
                                </div>
                                <div class="error-message" id="password_error"></div>
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <div class="position-relative">
                                    <input type="password" 
                                           id="confirm_password" 
                                           name="confirm_password" 
                                           class="form-control" 
                                           placeholder="Confirm your password"
                                           required>
                                    <button type="button" class="toggle-password" data-target="confirm_password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #666;">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                                <div class="error-message" id="confirm_password_error"></div>
                            </div>

                            <!-- Gender Field -->
                            <div class="form-group">
                                <label>Gender</label>
                                <div style="display: flex; gap: 24px; margin-top: 8px;">
                                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                        <input type="radio" name="gender" value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'male') ? 'checked' : ''; ?> required> 
                                        <span>Male</span>
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                        <input type="radio" name="gender" value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'female') ? 'checked' : ''; ?> required> 
                                        <span>Female</span>
                                    </label>
                                </div>
                                <div class="error-message" id="gender_error"></div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-block" style="width: 100%;">
                                + Create Account
                            </button>

                            <div class="auth-links">
                                <div class="auth-link">
                                    Already have an account? 
                                    <a href="<?php echo BASE_URL; ?>/login">Sign in here</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
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
    
    // Password validation function
    function validatePassword(password) {
        const requirements = {
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*]/.test(password),
            length: password.length >= 8
        };
        return requirements;
    }
    
    // Update password requirements UI
    function updatePasswordRequirements() {
        const password = passwordInput.value;
        const requirements = validatePassword(password);
        
        document.querySelectorAll('.requirement').forEach(item => {
            const reqType = item.getAttribute('data-req');
            const icon = item.querySelector('i');
            
            if (requirements[reqType]) {
                icon.classList.remove('fa-circle');
                icon.classList.add('fa-check-circle');
                item.classList.add('valid');
                item.classList.remove('invalid');
            } else {
                icon.classList.remove('fa-check-circle');
                icon.classList.add('fa-circle');
                item.classList.remove('valid');
                if (password.length > 0) {
                    item.classList.add('invalid');
                } else {
                    item.classList.remove('invalid');
                }
            }
        });
    }
    
    // Real-time password validation
    passwordInput.addEventListener('input', function() {
        updatePasswordRequirements();
        
        // Clear error when user starts typing
        document.getElementById('password_error').textContent = '';
        
        // Also check confirm password match
        if (confirmPasswordInput.value) {
            checkPasswordMatch();
        }
    });
    
    // Confirm password validation
    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirm = confirmPasswordInput.value;
        const errorElement = document.getElementById('confirm_password_error');
        
        if (confirm.length > 0 && password !== confirm) {
            errorElement.textContent = 'Passwords do not match';
            return false;
        } else {
            errorElement.textContent = '';
            return true;
        }
    }
    
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    
    // Email validation
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validate First Name
        const firstName = document.getElementById('first_name');
        if (!firstName.value.trim()) {
            document.getElementById('first_name_error').textContent = 'First name is required';
            isValid = false;
        } else if (firstName.value.trim().length < 2) {
            document.getElementById('first_name_error').textContent = 'First name must be at least 2 characters';
            isValid = false;
        } else {
            document.getElementById('first_name_error').textContent = '';
        }
        
        // Validate Last Name
        const lastName = document.getElementById('last_name');
        if (!lastName.value.trim()) {
            document.getElementById('last_name_error').textContent = 'Last name is required';
            isValid = false;
        } else if (lastName.value.trim().length < 2) {
            document.getElementById('last_name_error').textContent = 'Last name must be at least 2 characters';
            isValid = false;
        } else {
            document.getElementById('last_name_error').textContent = '';
        }
        
        // Validate Email
        const email = document.getElementById('email');
        if (!email.value.trim()) {
            document.getElementById('email_error').textContent = 'Email is required';
            isValid = false;
        } else if (!validateEmail(email.value)) {
            document.getElementById('email_error').textContent = 'Please enter a valid email address (e.g., name@domain.com)';
            isValid = false;
        } else if (email.value.includes(' ')) {
            document.getElementById('email_error').textContent = 'Email cannot contain spaces';
            isValid = false;
        } else {
            document.getElementById('email_error').textContent = '';
        }
        
        // Validate Password
        const password = passwordInput.value;
        const passwordRequirements = validatePassword(password);
        if (!password) {
            document.getElementById('password_error').textContent = 'Password is required';
            isValid = false;
        } else if (!passwordRequirements.uppercase || !passwordRequirements.lowercase || 
                   !passwordRequirements.number || !passwordRequirements.special || 
                   !passwordRequirements.length) {
            document.getElementById('password_error').textContent = 'Please meet all password requirements';
            isValid = false;
        } else {
            document.getElementById('password_error').textContent = '';
        }
        
        // Validate Confirm Password
        if (!checkPasswordMatch()) {
            isValid = false;
        }
        
        // Validate Gender
        const genderSelected = document.querySelector('input[name="gender"]:checked');
        if (!genderSelected) {
            document.getElementById('gender_error').textContent = 'Please select your gender';
            isValid = false;
        } else {
            document.getElementById('gender_error').textContent = '';
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
    
    // Trigger initial validation state
    updatePasswordRequirements();
});
</script>

<style>
/* Additional styles specific to register page */
.position-relative {
    position: relative;
}

.toggle-password:focus {
    outline: none;
}

.btn-block {
    width: 100%;
    display: block;
}

.text-muted {
    color: #6c757d;
}

/* Requirement styling */
.requirement.valid i {
    color: #28a745;
}

.requirement.invalid i {
    color: #dc3545;
}

.requirement i {
    transition: all 0.2s ease;
}
</style>