<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное
        снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($category as $index): ?>
            <!--заполните этот список из массива категорий-->
            <li class="promo__item promo__item--<?= esc($index['category_value']) ?>">
                <a class="promo__link"
                   href="category.php?category_id=<?= (int)$index['category_id'] ?>"><?= esc($index['category_name']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach ($items_structure as $val): ?>
            <!--заполните этот список из массива с товарами-->
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= esc($val['lot_picture']) ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= esc($val['category']) ?></span>
                    <h3 class="lot__title"><a class="text-link"
                                              href="/lot.php?lot_id=<?= (int)$val['lot_id'] ?>"><?= esc($val['lot_name']) ?></a>
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= esc(change_number($val['lot_start_price'])) ?> &#8381;</span>
                        </div>

                        <?php $finishing_status = time_class(esc($val['lot_end_date'])); ?>
                        <?php if ($finishing_status === 0): ?>
                            <div class="lot__timer timer timer--finishing">
                                Лот завершен!
                            </div>
                        <?php elseif ($finishing_status === 1): ?>
                            <div class="lot__timer timer timer--finishing">
                                <?= time_to_end(esc($val['lot_end_date'])); ?>
                            </div>
                        <?php else: ?>
                            <div class="lot__timer timer">
                                <?= time_to_end(esc($val['lot_end_date'])); ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<ul class="pagination-list">
    <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
    <?php foreach ($pages as $page): ?>
        <li class="pagination-item <?php if ($page === $cur_page): ?>pagination__item--active<?php endif; ?>"><a
                href="/?pagination=<?= $page; ?>"><?= $page; ?></a></li>
    <?php endforeach; ?>
    <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
</ul>
