<div class="container">
    <section class="lots">
        <h2>Результаты поиска по запросу «<span><?= strip_tags($_GET['search']) ?></span>»</h2>
        <ul class="lots__list">
            <?php if (count($search_result)): ?>
                <?php foreach ($search_result as $item): ?>
                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="<?= esc($item['lot_picture']) ?>" width="350" height="260" alt="Сноуборд">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category"><?= esc($item['category_name']) ?></span>
                            <h3 class="lot__title"><a class="text-link"
                                                      href="lot.php?lot_id=<?= (int)$item['lot_id'] ?>"><?= esc($item['lot_name']) ?></a>
                            </h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount">Стартовая цена</span>
                                    <span
                                        class="lot__cost"><?= change_number(esc($item['lot_start_price'])) . ' &#8381;' ?></span>
                                </div>
                                <div class="lot__timer timer">
                                    <?= time_to_end(esc($item['lot_end_date'])); ?>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p><b><?= $errors; ?></b></p>
            <?php endif; ?>

        </ul>
    </section>

    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a href="#">Назад</a></li>
        <?php foreach ($pages as $page): ?>
            <li class="pagination-item  <?php if ($page === $cur_page): ?> pagination-item-active <?php endif;
            ?>"><a href="/search.php?search=<?= $q_search; ?>&find=Найти&page=<?= $page; ?>"><?= $page; ?></a></li>
        <?php endforeach; ?>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
    </ul>
</div>

