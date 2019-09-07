<form class="form container" action="login.php" method="post" <?= count($errors) ? ' form--invalid': ''; ?>> <!-- form--invalid -->
    <h2>Вход</h2>
    <div class="form__item <?= isset($errors['user_email']) ? ' form__item--invalid': '' ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="user_email" placeholder="Введите e-mail" value="<?=getPostVal('user_name'); ?>">
        <span class="form__error"><?=$errors['user_email'];?></span>
    </div>
    <div class="form__item form__item--last <?= isset($errors['user_password']) ? 'form__item--invalid': '' ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="user_password" placeholder="Введите пароль">
        <span class="form__error"><?=$errors['user_password'];?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>
