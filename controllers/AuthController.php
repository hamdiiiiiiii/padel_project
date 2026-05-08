<<<<<<< Updated upstream
<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller
{
    public function login(): void
    {
        if (!defined('REGISTER_HANDLED_BY_CONTROLLER')) {
            define('REGISTER_HANDLED_BY_CONTROLLER', true);
        }

        $this->render('auth/login', [
            'activePage' => '',
            'pageStyles' => ['css/login_signup.css'],
        ]);
    }

    public function doLogin(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $this->redirect('/login');
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        $storedHash = $user['password_hash'] ?? ($user['password'] ?? '');

        if ($user && $storedHash !== '' && password_verify($password, $storedHash)) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'] ?? 'user',
            ];
            
            if (($_SESSION['user']['role'] ?? '') === 'admin') {
                $this->redirect('/views/admin/admin.php');
            } else {
                $this->redirect('/home');
            }
        }

        $this->redirect('/login');
    }

    public function register(): void
    {
        if (!defined('REGISTER_HANDLED_BY_CONTROLLER')) {
            define('REGISTER_HANDLED_BY_CONTROLLER', true);
        }

        $this->render('auth/register', [
            'activePage' => '',
            'pageStyles' => ['css/login_signup.css'],
        ]);
    }

    public function doRegister(): void
    {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $name = trim($firstName . ' ' . $lastName);

        if (!defined('REGISTER_HANDLED_BY_CONTROLLER')) {
            define('REGISTER_HANDLED_BY_CONTROLLER', true);
        }

        if ($name === '' || $email === '' || $password === '') {
            $this->render('auth/register', [
                'activePage' => '',
                'pageStyles' => ['css/login_signup.css'],
                'error' => 'Name, email, and password are required.',
            ]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render('auth/register', [
                'activePage' => '',
                'pageStyles' => ['css/login_signup.css'],
                'error' => 'Please enter a valid email address.',
            ]);
            return;
        }

        if (strlen($password) < 6) {
            $this->render('auth/register', [
                'activePage' => '',
                'pageStyles' => ['css/login_signup.css'],
                'error' => 'Password must be at least 6 characters.',
            ]);
            return;
        }

        if ($password !== $confirmPassword) {
            $this->render('auth/register', [
                'activePage' => '',
                'pageStyles' => ['css/login_signup.css'],
                'error' => 'Password and confirm password do not match.',
            ]);
            return;
        }

        $userModel = new User();
        $existing = $userModel->findByEmail($email);

        if ($existing) {
            $this->render('auth/register', [
                'activePage' => '',
                'pageStyles' => ['css/login_signup.css'],
                'error' => 'This email is already registered.',
            ]);
            return;
        }

        $created = $userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => 'user',
        ]);

        if (!$created) {
            $this->render('auth/register', [
                'activePage' => '',
                'pageStyles' => ['css/login_signup.css'],
                'error' => 'Failed to create account. Please try again.',
            ]);
            return;
        }

        $_SESSION['auth_success'] = 'Registration successful. Please login.';
        $this->redirect('/login');
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/login');
    }
}
=======
<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller
{
    public function login(): void
    {
        if (!defined('REGISTER_HANDLED_BY_CONTROLLER')) {
            define('REGISTER_HANDLED_BY_CONTROLLER', true);
        }

        $this->render('auth/login', [
            'activePage' => '',
            'pageStyles' => ['css/login_signup.css'],
        ]);
    }

    public function doLogin(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $this->redirect('/login');
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        $storedHash = $user['password_hash'] ?? ($user['password'] ?? '');

        if ($user && $storedHash !== '' && password_verify($password, $storedHash)) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'] ?? 'user',
            ];
            
            if (($_SESSION['user']['role'] ?? '') === 'admin') {
                $this->redirect('/views/admin/admin.php');
            } else {
                $this->redirect('/home');
            }
        }

        $this->redirect('/login');
    }

    public function register(): void
    {
        if (!defined('REGISTER_HANDLED_BY_CONTROLLER')) {
            define('REGISTER_HANDLED_BY_CONTROLLER', true);
        }

        $this->render('auth/register', [
            'activePage' => '',
            'pageStyles' => ['css/login_signup.css'],
        ]);
    }

    public function doRegister(): void
    {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $name = trim($firstName . ' ' . $lastName);

        if (!defined('REGISTER_HANDLED_BY_CONTROLLER')) {
            define('REGISTER_HANDLED_BY_CONTROLLER', true);
        }

        if ($name === '' || $email === '' || $password === '') {
            $this->render('auth/register', [
                'activePage' => '',
                'pageStyles' => ['css/login_signup.css'],
                'error' => 'Name, email, and password are required.',
            ]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render('auth/register', [
                'activePage' => '',
                'pageStyles' => ['css/login_signup.css'],
                'error' => 'Please enter a valid email address.',
            ]);
            return;
        }

        if (strlen($password) < 6) {
            $this->render('auth/register', [
                'activePage' => '',
                'pageStyles' => ['css/login_signup.css'],
                'error' => 'Password must be at least 6 characters.',
            ]);
            return;
        }

        if ($password !== $confirmPassword) {
            $this->render('auth/register', [
                'activePage' => '',
                'pageStyles' => ['css/login_signup.css'],
                'error' => 'Password and confirm password do not match.',
            ]);
            return;
        }

        $userModel = new User();
        $existing = $userModel->findByEmail($email);

        if ($existing) {
            $this->render('auth/register', [
                'activePage' => '',
                'pageStyles' => ['css/login_signup.css'],
                'error' => 'This email is already registered.',
            ]);
            return;
        }

        $created = $userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => 'user',
        ]);

        if (!$created) {
            $this->render('auth/register', [
                'activePage' => '',
                'pageStyles' => ['css/login_signup.css'],
                'error' => 'Failed to create account. Please try again.',
            ]);
            return;
        }

        $_SESSION['auth_success'] = 'Registration successful. Please login.';
        $this->redirect('/login');
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/login');
    }
}
>>>>>>> Stashed changes
