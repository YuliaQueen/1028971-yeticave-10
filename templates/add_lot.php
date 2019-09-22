<form class="form form--add-lot container <?= count($errors) ? ' form--invalid' : ''; ?> >" action="add.php"
      enctype="multipart/form-data" method="post" name="add_lot"> <!-- form--invalid -->
    <h2>Добавление лота</h2>

    <div class="form__container-two">
        <div class="form__item <?= isset($errors['lot_name']) ? 'form__item--invalid' : '' ?>">
            <!-- form__item--invalid -->
            <label for="lot-name">Наименование <sup>*</sup></label>
            <input id="lot-name" type="text" name="lot_name" placeholder="Введите наименование лота"
                   value="<?= getPostVal('lot_name'); ?>">
            <span class="form__error"><?= $errors['lot_name'] ?? '' ?></span>
        </div>

        <div class="form__item <?= isset($errors['lot_category']) ? ' form__item--invalid' : '' ?>">
            <label for="category">Категория <sup>*</sup></label>
            <select id="category" name="lot_category">
                <option value="default">Выберите категорию</option>
                <?php foreach ($category as $value): ?>
                    <option value="<?= $value['category_id'] ?>"><?= esc($value['category_name']); ?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error"><?= $errors['lot_category'] ?? ''; ?></span>
        </div>
    </div>

    <div class="form__item <?= isset($errors['lot_description']) ? 'form__item--invalid' : '' ?> form__item--wide">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="lot_description"
                  placeholder="Напишите описание лота"><?= trim(getPostVal('lot_description')); ?></textarea>
        <span class="form__error"><?= $errors['lot_description'] ?? ''; ?></span>
    </div>

    <div class="form__item form__item--file <?= isset($errors['lot_picture']) ? 'form__item--invalid' : '' ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="lot-img" name="lot_picture" value="">
            <label for="lot-img">
                Добавить
            </label>
            <span class=" form__error"><?= $errors['lot_picture'] ?? ''; ?></span>
        </div>
    </div>

    <div class="form__container-three">
        <div class="form__item form__item--small <?= isset($errors['lot_start_price']) ? 'form__item--invalid' : '' ?>">
            <label for="lot-rate">Начальная цена <sup>*</sup></label>
            <input id="lot-rate" type="text" name="lot_start_price" placeholder="0"
                   value="<?= getPostVal('lot_start_price'); ?>">
            <span class="form__error"><?= $errors['lot_start_price'] ?? ''; ?></span>
        </div>

        <div class="form__item form__item--small <?= isset($errors['lot_bet_step']) ? 'form__item--invalid' : '' ?>">
            <label for="lot-step">Шаг ставки <sup>*</sup></label>
            <input id="lot-step" type="text" name="lot_bet_step" placeholder="0"
                   value="<?= getPostVal('lot_bet_step'); ?>">
            <span class="form__error"><?= $errors['lot_bet_step'] ?? ''; ?></span>
        </div>

        <div class="form__item <?= isset($errors['lot_end_date']) ? ' form__item--invalid' : '' ?>">
            <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
            <input value="<?= getPostVal('lot_end_date'); ?>" class="form__input-date" id="lot-date"
                   name="lot_end_date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" type="date">
            <span class="form__error"><?= $errors['lot_end_date'] ?? ''; ?></span>
        </div>

    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>

