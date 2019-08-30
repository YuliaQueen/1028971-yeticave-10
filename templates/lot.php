<nav class="nav">
    <ul class="nav__list container">
        <li class="nav__item">
            <a href="all-lots.html">Доски и лыжи</a>
        </li>
        <li class="nav__item">
            <a href="all-lots.html">Крепления</a>
        </li>
        <li class="nav__item">
            <a href="all-lots.html">Ботинки</a>
        </li>
        <li class="nav__item">
            <a href="all-lots.html">Одежда</a>
        </li>
        <li class="nav__item">
            <a href="all-lots.html">Инструменты</a>
        </li>
        <li class="nav__item">
            <a href="all-lots.html">Разное</a>
        </li>
    </ul>
</nav>

<section class="lot-item container">

    <h2><?=$lot_info['lot_name']; ?></h2>

    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?=$lot_info['lot_picture'];?>" width="730" height="548" alt="Сноуборд">

            </div>
            <p class="lot-item__category">Категория: <span><?=$lot_info['category'];?></span></p>
            <p class="lot-item__description"><?=$lot_info['lot_description'] ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">

                <?php $finishing_status = time_class($lot_info['lot_end_date']); ?>
                <?php if($finishing_status == 0): ?>
                    <div class="lot-item__timer timer timer--finishing">
                        <b>Закрыт</b>
                    </div>
                <?php elseif ($finishing_status == 1): ?>
                    <div class="lot-item__timer timer timer--finishing">
                        <?= time_to_end($lot_info['lot_end_date']); ?>
                    </div>
                <?php else: ?>
                    <div class="lot-item__timer timer">
                        <?= time_to_end($lot_info['lot_end_date']); ?>
                    </div>
                <?php endif; ?>

                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= change_number(get_last_bid($lot_info['lot_id'], $lot_info['lot_start_price'])).' &#8381;';?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?=change_number($lot_info['lot_bet_step']).' &#8381;' ?></span>
                    </div>
                </div>
                <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post" autocomplete="off">
                    <p class="lot-item__form-item form__item form__item--invalid">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="<?=change_number($lot_info['lot_bet_step']).' &#8381;' ?>">
                        <?php if($finishing_status==0): ?>
                            <span class="form__error">Нельзя сделать ставку</span>
                        <?php else: ?>
                            <span class="form__error">Введите ставку</span>
                        <?php endif; ?>

                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <div class="history">
                <h3>История ставок (<span>10</span>)</h3>
                <table class="history__list">
                    <tr class="history__item">
                        <td class="history__name">Иван</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">5 минут назад</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Константин</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">20 минут назад</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Евгений</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">Час назад</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Игорь</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 08:21</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Енакентий</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 13:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Семён</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 12:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Илья</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 10:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Енакентий</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 13:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Семён</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 12:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Илья</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 10:20</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>