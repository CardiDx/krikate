<div class="cart_preloader-page disabled">
    <svg viewBox="25 25 50 50">
        <circle r="20" cy="50" cx="50"></circle>
    </svg>
</div>
<div class="basket__table">
    <div class="basket__table-head">
        <div class="basket__table-col">Товар</div>
        <div class="basket__table-col cart-product__price-label">Цена</div>
        <div class="basket__table-col">Количество</div>
        <div class="basket__table-col">Стоимость</div>
        <div class="basket__table-col">
            <button class="basket__clear btn-reset">Очистить корзину</button>
        </div>
    </div>
    <div class="basket__table-body">

        <?
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
            <div class="basket__table-row cart-product" data-cart-product="<?= $product_id ?>" data-cart-variation="<?= $variation_id ?>">
                <div class="cart-product__item">
                    <div class="cart-product__item-wrapper">
                        <a href="<?= $_product->get_permalink() ?>" class="cart-product__item-picture">
                            <?= $image ?>
                        </a>
                        <div class="cart-product__item-body">
                            <a href="<?= $_product->get_permalink() ?>" class="cart-product__item-title"><?= $_product->get_name() ?></a>
                            <div class="cart-product__item-info">
                                Цвет
                                <span><?= $color ?></span>
                            </div>
                            <div class="cart-product__item-info">
                                Размер
                                <span><?= $size ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-product__price">
                    <?
                    if ($price < $regular_price) {
                        echo '<div class="cart-product__price-current">' . $price . ' BYN</div>';
                        echo '<div class="cart-product__price-old">' . $regular_price . ' BYN</div>';
                    } else {

                        echo '<div class="cart-product__price-current">' . $price . ' BYN</div>';
                    }
                    ?>

                </div>
                
                <div class="cart-product__amount">
                    <div class="counter">
                        <div class="counter__wrapper">
                            <button class="counter__btn counter__btn--minus btn-reset">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="32" height="32" fill="#FAFAFA" />
                                    <path d="M8 16H26" stroke="#1D1D1B" />
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

                <div class="cart-product__price cart-product__all-price">
                    <?
                        if ($price < $regular_price) {
                            echo '<div class="cart-product__price-current">' . $price * $quantity . ' BYN</div>';
                            echo '<div class="cart-product__price-old">' . $regular_price * $quantity . ' BYN</div>';
                        } else {
                            echo '<div class="cart-product__price-current">' . $price * $quantity . ' BYN</div>';
                        }
                    ?>
                </div>

                <div class="cart-product__remove">
                    <button class="cart-product__remove-btn btn-reset">
                        <svg width="20" height="20" viewBox="0 0 20 20">
                            <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#trash"></use>
                        </svg>
                    </button>
                </div>
            </div>

        <? }; ?>

    </div>
<!--     <div class="basket__table-footer">
        <div class="basket__table-total basket-total">
            <div class="basket-total__btn">
                <button id="openOneClickPopup" class="secondary-button btn-reset">Купить в 1
                    клик</button>
            </div>
        </div>
    </div> -->
</div>