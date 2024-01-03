<?
$product_title = get_the_title();
$product_info = product_info(get_the_ID());

$product_price = $product_info['nt_price'];
?>

<a href="<?= esc_url(get_permalink()); ?>" class="search__results-item search-result">
    <div class="search-result__wrapper">
        <div class="search-result__picture">
            <?= get_the_post_thumbnail(get_the_ID(), 'medium')?>
        </div>
        <div class="search-result__body">
            <div class="search-result__title"><?= $product_title ?></div>
            <div class="search-result__wrap">
                <? view_product_price_listing($product_price); ?>
            </div>
        </div>
    </div>
</a>

