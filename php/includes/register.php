<section class="register">
    <h3>Register</h3>

    <form action="/register" method="POST">

        <label for="name">Name</label>
        <?php if (!empty($name_error)): ?>
            <div class="error">
                <?= htmlspecialchars($name_error) ?>
            </div>
        <?php endif ?>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="email">Email</label>
        <?php if (!empty($email_error)): ?>
            <div class="error">
                <?= htmlspecialchars($email_error) ?>
            </div>
        <?php endif ?>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="password-1">Password</label>
        <?php if (!empty($password_error)): ?>
            <div class="error">
                <?= htmlspecialchars($password_error) ?>
            </div>
        <?php endif ?>
        <input type="password" name="password-1" id="password-1" required>

        <label for="password-2">Confirm Password</label>
        <input type="password" name="password-2" id="password-2" required>

        <input type="submit" value="Register">

        <a href="/login" class="sub-text">Already have an account</a>
    </form>
</section>