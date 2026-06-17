<section class="login">
    <h3>Login</h3>
    <form action="/login" method="POST">
        <?php if (!empty($login_error)): ?>
            <div class="error">
                <?= htmlspecialchars($login_error) ?>
            </div>
        <?php endif ?>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="example@email.com" value="<?= htmlspecialchars($email ?? '') ?>" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Login">
        
        <a href="/register" class="sub-text">Need an account? Register here</a>
    </form>
</section>