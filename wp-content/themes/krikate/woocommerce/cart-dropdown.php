<div class="cart_preloader disabled">
    <svg viewBox="25 25 50 50">
        <circle r="20" cy="50" cx="50"></circle>
    </svg>
</div>

<div class="cart__top">
    <button class="cart__back btn-reset">
        <svg width="12" height="13" viewBox="0 0 12 13">
            <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#backarrow"></use>
        </svg>
        Товары в корзине <span>(<span class="all-cart-count"><?= WC()->cart->get_cart_contents_count(); ?></span>)</span>
    </button>
    <button class="cart__reset btn-reset">Очистить</button>
</div>
<div class="cart__body cart__product-list">
    <?php
    $total = 0;
    $sale_total = 0;
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
        $_product = wc_get_product($product_id);

        $variation_id = $cart_item['variation_id'];
        $variation = wc_get_product($variation_id);
        $image = wp_get_attachment_image($variation->get_image_id());

        $price = $variation->get_price();
        $regular_price = $variation->get_regular_price();
        $quantity = $cart_item['quantity'];

        $color = $variation->get_attribute('pa_color');
        $size = $variation->get_attribute('pa_size');

    ?>
        <div class="cart__body-item cart-item" data-cart-product="<?= $product_id ?>" data-cart-variation="<?= $variation_id ?>">
            <div class="cart-item__wrapper">
                <a href="<?= $_product->get_permalink() ?>" class="cart-item__picture">
                    <?= $image ?>
                </a>
                <div class="cart-item__body">
                    <a href="<?= $_product->get_permalink() ?>" class="cart-item__title"><?= $_product->get_name() ?></a>
                    <div class="cart-item__info">
                        Размер
                        <span><?= $size ?></span>
                    </div>
                    <div class="cart-item__info">
                        Цвет
                        <span><?= $color ?></span>
                    </div>
                    <div class="cart-item__wrap">
                        <?
                        if ($price < $regular_price) {
                            $sale = 100 - ($price * 100 / $regular_price);
                            $sale = round($sale, 0);
                            $total = $total + ($regular_price * $quantity);
                            $sale_total = $sale_total + ($price * $quantity);
                            echo '<div class="cart-item__price">' . $price . ' BYN</div>';
                            echo '<div class="cart-item__discount">-' . $sale . '%</div>';
                            echo '<div class="cart-item__old">' . $regular_price . ' BYN</div>';
                        } else {
                            $total = $total + ($price * $quantity);
                            $sale_total = $sale_total + ($price * $quantity);
                            echo '<div class="cart-item__price">' . $price . ' BYN</div>';
                        }
                        ?>
                    </div>
                    <div class="cart-item__bottom">
                        <div class="cart-item__counter">
                            <div class="counter">
                                <div class="counter__wrapper">
                                    <button class="counter__btn counter__btn--minus btn-reset">
                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="32" height="32" fill="#FAFAFA"></rect>
                                            <path d="M8 16H26" stroke="#1D1D1B"></path>
                                        </svg>
                                    </button>
                                    <div class="counter__value"><?= $quantity ?></div>
                                    <button class="counter__btn counter__btn--plus btn-reset">
                                        <svg width="32" height="32" viewBox="0 0 32 32">
                                            <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#plus"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button class="cart-item__remove btn-reset">
                            <svg width="20" height="20" viewBox="0 0 20 20">
                                <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#trash"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?

    }
    ?>

</div>
<div class="cart__bottom">
    <div class="cart__total">
        <div class="cart__total-item">
            <span>Сумма заказа</span>
            <span class="cart__total-item_full-price"><?= $total; ?> BYN</span>
        </div>
        <div class="cart__total-item">
            <span>Скидка</span>
            <span class="cart__total-item_sale-price">— <?= $total - $sale_total + WC()->cart->discount_cart ?> BYN</span>
        </div>
        <div class="cart__total-item">
            <span>Итого</span>
            <span><?= $sale_total - WC()->cart->discount_cart; ?> BYN</span>
        </div>
    </div>
    <div class="cart__nav">
        <a href="<?= wc_get_checkout_url(); ?>" class="cart__apply primary-button">Перейти к оформлению</a>
    </div>
</div>