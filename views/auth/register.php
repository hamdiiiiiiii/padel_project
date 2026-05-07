<section class="auth-section py-5" style="margin-top:120px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card">
                    <div class="auth-card-header text-center">
                        <h2>Create Account</h2>
                        <p>Join PadelPro today</p>
                    </div>
                    <div class="auth-card-body">
                        <form method="POST" action="<?php echo BASE_URL; ?>/register">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </form>
                        <div class="text-center mt-3">
                            Already have an account?
                            <a href="<?php echo BASE_URL; ?>/login">Login here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>