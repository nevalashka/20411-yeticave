<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($categories as $val): ?>
        <li class="promo__item promo__item--boards">
            <a class="promo__link" href="pages/all-lots.html">
                <?= $val["category"];?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach ($lots as $key => $val): ?>
        <li class="lots__item lot">
            <div class="lot__image">
                <img src="<?=$val['url_picture']; ?>" width="350" height="260" alt="">
            </div>
            <div class="lot__info">
                <span class="lot__category">
                    <?=$val['category']; ?>
                </span>
                <h3 class="lot__title">
                    <a class="text-link" href="lot.php?=<?=$val['id'];?>">
                        <?=$val["name_lot"]; ?>
                    </a>
                </h3>
                <div class="lot__state">
                    <div class="lot__rate">
                        <span class="lot__amount">Стартовая цена</span>
                        <span class="lot__cost">
                            <?=price_format($val["start_price"]); ?>
                        </span>
                    </div>
                    <div class="lot__timer timer">
                        <?= time_count(); ?>
                    </div>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
</section>
