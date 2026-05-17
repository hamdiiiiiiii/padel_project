<?php
declare(strict_types=1);

/**
 * AuthGuard — Centralized authentication & authorization middleware.
 *
 * Implements the Single-Responsibility Principle: auth enforcement lives in
 * exactly one place. All controllers call these static helpers instead of
 * duplicating session checks.
 *
 * Design pattern: Guard / Middleware (variation of the Chain-of-Responsibility).
 */
class AuthGuard
{
    /**
     * Ensure the current visitor is logged in.
     * Redirects to /login and halts execution if not authenticated.
     */
    public static function requireLogin(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . (defined('BASE_URL') ? BASE_URL : '') . '/login');
            exit;
        }
    }

    /**
     * Ensure the current visitor is an authenticated admin.
     * Redirects to /login if not logged in, or /home if logged in but not admin.
     */
    public static function requireAdmin(): void
    {
        self::requireLogin();

        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            header('Location: ' . (defined('BASE_URL') ? BASE_URL : '') . '/dashboard');
            exit;
        }
    }

}
