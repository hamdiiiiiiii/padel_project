<?php

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
}
