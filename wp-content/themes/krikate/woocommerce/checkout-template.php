<?
/* Template Name: Checkout Template */
$current_url = esc_url($_SERVER['REQUEST_URI']);


// Проверяем, не пуста ли корзина
if (!is_checkout() && !WC()->cart->is_empty()) {
    // Получаем URL страницы оформления заказа
    $checkout_url = wc_get_checkout_url();

    // Выполняем редирект на страницу оформления заказа
    wp_safe_redirect($checkout_url);
    exit;
}

get_header();
?>

<?php

if (isset($_GET['key']) && !empty($_GET['key']) && strpos($current_url, '/order-received/') !== false) : ?>
    <main>
        <div class="middle">
            <div class="middle__container container">
                <div class="middle__content">
                    <?
                    $order_id = wc_get_order_id_by_order_key($_GET['key']);
                    $order = wc_get_order($order_id);

                    if ($order) : ?>

                        <h1 class="middle__title">Спасибо за ваш заказ</h1>
                        <?
                        echo '<div class="middle__desc">';
                        echo '<p>Номер заказа: ' . $order->get_order_number() . '</p>';
                        echo '<p>Сумма заказа: ' . wc_price($order->get_total()) . '</p>';
                        echo '<p>Дата заказа: ' . wc_format_datetime($order->get_date_created()) . '</p>';
                        echo '</div>';
                        ?>
                        <!--<div class="middle__desc">После оформления заказа наш менеджер свяжется с вами для уточнения деталей</div>-->
                         <div class="middle__desc">
                            <p>Дорогая, рады твоим покупкам на нашем сайте</p>
                            <p>Если вдруг у тебя возникли вопросы, пожалуйста, свяжись с нашим отделом заботы по номеру телефона: +375 (33) 914-41-61.</p>
                            <p>Спасибо за твоё доверие!</p>
                        </div>
                    <? else : ?>
                        <h1 class="middle__title">Заказ не найден</h1>
                    <? endif; ?>
                    <div class="middle__btns">
                        <a href="/shop/" class="primary-button btn-reset">Перейти в каталог</a>
                        <a href="/" class="secondary-button btn-reset">На главную</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
<? else : ?>


    <main>
        <section class="breadcrumbs">
            <div class="breadcrumbs__container container">
                <ul class="breadcrumbs__list list-reset">
                    <?php yoast_breadcrumb(); ?>
                </ul>
        </section>

        <section class="basket section-offset">
            <div class="basket__container container">
                <div class="basket__top page-title">
                    <h1 class="basket__title">Корзина</h1>
                    <button class="basket__clear-basket btn-reset">Очистить корзину</button>
                </div>

                <div class="basket__wrapper">
                    <? if (!WC()->cart->is_empty()) : ?>
                        <div class="basket__body">
                            <? include 'cart/basket-body.php'; ?>
                        </div>

                        <div class="basket__checkout">
                            <div class="checkout_preloader-page disabled">
                                <svg viewBox="25 25 50 50">
                                    <circle r="20" cy="50" cx="50"></circle>
                                </svg>
                            </div>
                            <?= do_shortcode('[woocommerce_checkout]'); ?>
                            <div class="button secondary-button button__reload-basket">Обновить корзину</div>
                        </div>

                    <? else : ?>
                        <div class="cart-product__removed">
                            На данный момент в корзине нет товаров.
                        </div>
                    <? endif; ?>
                </div>
            </div>
        </section>
    </main>



    <div class="popup popup--small" id="oneClickPopup">
        <div class="popup__container">
            <button class="popup__close btn-reset">
                <svg width="14" height="14" viewBox="0 0 14 14">
                    <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#close"></use>
                </svg>
            </button>
            <div class="popup__title">Купить в 1 клик</div>
            <div class="popup__body">
                <form class="popup__form popup-form">
                    <input type="hidden" name="form-type" value="cart_one_click">
                    <div class="popup-form__inp input-base">
                        <input id="name" name="name" type="text" placeholder="Имя *" class="inp-reset input-base__inp">
                        <span class="input-base__valid"></span>
                    </div>
                    <div class="popup-form__inp input-base">
                        <input id="phone" name="phone" type="tel" placeholder="Телефон *" class="inp-reset input-base__inp">
                        <span class="input-base__valid"></span>
                    </div>
                    <div class="popup-form__policy"> <input type="checkbox" name="accept-policy" checked> <label for="accept-policy"> Отправляя данные, вы принимаете наши <a href="<?= get_field('policy', 'option'); ?>">Политику
                            конфиденциальности</a> и <a href="<?= get_field('oferta', 'option'); ?>">Договор оферты.</a></label></div>
                    <button disabled type="submit" class="popup-form__btn btn-reset primary-button">Отправить</button>
                </form>
                <div class="error cart-item__wrap" style="display: none;">Произошла ошибка, обратитесь к администрации сайта</div>
            </div>
        </div>
    </div>
    <div class="popup popup--small" id="thanksPopup">
        <div class="popup__container">
            <button class="popup__close btn-reset">
                <svg width="14" height="14" viewBox="0 0 14 14">
                    <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#close"></use>
                </svg>
            </button>
            <div class="popup__title">Спасибо за ваш заказ</div>
            <div class="popup__desc">Наш менеджер свяжется с вами для уточнения деталей</div>
            <a href="#" class="popup__btn btn-reset primary-button popup__close-static">Продолжить покупки</a>
        </div>
    </div>

<? endif; ?>
<?php get_footer(); ?>