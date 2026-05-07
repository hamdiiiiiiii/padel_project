<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller
{
    public function login(): void
    {
        $this->render('auth/login');
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

        if (
            $user &&
            (password_verify($password, $user['password']) || $password === $user['password'])
        ) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
            ];
            $this->redirect('/dashboard');
        }

        $this->redirect('/login');
    }

    public function register(): void
    {
        $this->render('auth/register');
    }

    public function doRegister(): void
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '' || $email === '' || $password === '') {
            $this->redirect('/register');
        }

        $userModel = new User();
        $existing = $userModel->findByEmail($email);

        if ($existing) {
            $this->redirect('/login');
        }

        $userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $this->redirect('/login');
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/login');
    }
}
