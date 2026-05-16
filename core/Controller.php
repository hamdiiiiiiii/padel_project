<?php

require_once __DIR__ . '/AuthGuard.php';

class Controller
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);

        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/' . $view . '.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }

    protected function redirect(string $url): void
    {
        if (defined('BASE_URL') && str_starts_with($url, '/')) {
            $url = BASE_URL . $url;
        }

        header("Location: {$url}");
        exit;
    }

    protected function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Halt with redirect to /login if the visitor is not authenticated.
     * Delegates to AuthGuard — single source of truth for auth logic.
     */
    protected function requireLogin(): void
    {
        AuthGuard::requireLogin();
    }

    /**
     * Halt with redirect if the visitor is not an authenticated admin.
     * Delegates to AuthGuard — single source of truth for auth logic.
     */
    protected function requireAdmin(): void
    {
        AuthGuard::requireAdmin();
    }
}
