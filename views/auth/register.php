<div class="card" style="max-width: 420px; margin: 0 auto;">
    <h1>Register</h1>
    <form method="POST" action="<?php echo BASE_URL; ?>/register">
        <input type="text" name="name" placeholder="Full name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Create Account</button>
    </form>
</div>
