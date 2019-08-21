<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($category as $index): ?>
            <!--заполните этот список из массива категорий-->
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?=esc($index); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach ($items_structure as  $val): ?>
            <!--заполните этот список из массива с товарами-->
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$val['url_img'] ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=esc($val['category'])?></span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?=$val['name'] ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?=esc(change_number($val['price'])) ?> &#8381;</span>
                        </div>

                        <div class="lot__timer timer <?if (time_class($val['date_to_end'])) { print("timer--finishing"); }?>">
                            <?= time_to_end($val['date_to_end']); ?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
