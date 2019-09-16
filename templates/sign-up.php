<form class="form container <?= count($errors) ? ' form--invalid' : ''; ?>" action="sign-up.php" method="post"
      autocomplete="off"> <!-- form
    --invalid -->
    <h2>Регистрация нового аккаунта</h2>

    <div class="form__item <?= isset($errors['user_email']) ? 'form__item--invalid' : '' ?>">
        <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="user_email" placeholder="Введите e-mail"
               value="<?= getPostVal('user_email'); ?>">
        <span class="form__error"><?= $errors['user_email'] ?></span>
    </div>

    <div class="form__item <?= isset($errors['user_password']) ? 'form__item--invalid' : '' ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="user_password" placeholder="Введите пароль">
        <span class="form__error"><?= $errors['user_password'] ?></span>
    </div>

    <div class="form__item <?= isset($errors['user_name']) ? 'form__item--invalid' : '' ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="user_name" placeholder="Введите имя" value="<?= getPostVal('user_name'); ?>">
        <span class="form__error"><?= $errors['user_name'] ?></span>
    </div>

    <div class="form__item <?= isset($errors['user_contacts']) ? 'form__item--invalid' : '' ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="user_contacts"
                  placeholder="Напишите как с вами связаться"><?= trim(getPostVal('user_contacts')); ?></textarea>
        <span class="form__error"><?= $errors['user_contacts'] ?></span>
    </div>

    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>
