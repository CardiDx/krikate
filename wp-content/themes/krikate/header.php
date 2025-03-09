<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php krikate_schema_type(); ?>>

<?
$template_uri = esc_url(get_template_directory_uri());
if (get_field('sale_name', 'option') && !empty(get_field('sale_name', 'option'))){
	$sale_name = get_field('sale_name', 'option');
} else {
	$sale_name = 'SALE';
}

?>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    <?php wp_head(); ?>
    <!--  START ALL CSS  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Arsenal&display=swap">
    <link rel="stylesheet" href="<? echo $template_uri; ?>/assets/fonts/fonts.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.5/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/25.2.1/build/css/intlTelInput.min.css" integrity="sha512-X3pJz9m4oT4uHCYS6UjxVdWk1yxSJJIJOJMIkf7TjPpb1BzugjiFyHu7WsXQvMMMZTnGUA9Q/GyxxCWNDZpdHA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.0/css/glightbox.css" integrity="sha512-iQ3H4A+iyBTP8M4ypX5PrTt2S+G1zmRjf0k0uOASKlFHysV8TL9ZoQyVwPss0D12IBTMoDEHA8+bg8a1viS9Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" /><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.6/css/perfect-scrollbar.css" integrity="sha512-2xznCEl5y5T5huJ2hCmwhvVtIGVF1j/aNUEJwi/BzpWPKEzsZPGpwnP1JrIMmjPpQaVicWOYVu8QvAIg9hwv9w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="<? echo $template_uri; ?>/assets/styles/intl-tel-input.18.2.1.css">
    <link rel="stylesheet" href="<? echo $template_uri; ?>/assets/styles/styles.css?ver.1.0.1">
    <link rel="stylesheet" href="<? echo esc_url(get_template_directory_uri()); ?>/assets/styles/animation.css">
	
	
	
</head>


<body <?php if (!is_search()) {
            body_class();
        } ?>>
    <?php wp_body_open(); ?>
    <header class="header">
        <div class="header__container container">
            <button class="btn-reset header__burger">
                <svg width="19" height="11" viewBox="0 0 19 11">
                    <use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#burger"></use>
                </svg>
            </button>
            <a href="/" class="header__logo">
                <?= wp_get_attachment_image(get_field('logo', 'option')); ?>
            </a>
            <nav class="header__nav h-menu">
                <ul class="h-menu__wrapper list-reset">
                    <li class="h-menu__item">
                        <button class="h-menu__btn btn-reset" id="openCatalogMenu">
                            <svg width="15" height="6" viewBox="0 0 15 6">
                                <use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#smallburger"></use>
                            </svg>
                            Каталог
                        </button>
                    </li>
                    <!--<li class="h-menu__item">-->
                    <!--    <a href="/category/night-party-sale/" class="h-menu__link">NIGHT PARTY SALE</a>-->
                    <!--</li>-->
                     <li class="h-menu__item">
                        <a href="/category/sale/" class="h-menu__link"><?= $sale_name ?></a>
                    </li>
<!--                     <li class="h-menu__item">
                        <a href="/category/gajdy/" class="h-menu__link">Гайды</a>
                    </li> -->
                    <li class="h-menu__item">
                        <a href="/shops/" class="h-menu__link">Магазины</a>
                    </li>
                    <li class="h-menu__item">
                        <a href="/lookbook/" class="h-menu__link">Lookbook</a>
                    </li>
                    <li class="h-menu__item">
                        <button class="h-menu__btn btn-reset" id="openBuyersMenu">
                            Покупателям
                        </button>
                    </li>
                    <li class="h-menu__item">
                        <a href="/partnership/" class="h-menu__link">Сотрудничество</a>
                    </li>
                    <li class="h-menu__item">
                        <a href="/category/sertifikat/" class="h-menu__link">Сертификаты</a>
                    </li>
                </ul>
            </nav>
            <button class="header__search btn-reset">
                <svg width="17" height="17" viewBox="0 0 17 17">
                    <use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#search"></use>
                </svg>
            </button>
            <button class="btn-reset header__cart h-cart">
                <svg class="h-cart__icon" width="14" height="19" viewBox="0 0 14 19">
                    <use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#cart"></use>
                </svg>
                <span class="h-cart__count"><?= WC()->cart->get_cart_contents_count(); ?></span>
            </button>
        </div>
        <div class="header__cart-dropdown cart">
            <div class="cart__wrapper">
                <? include('woocommerce/cart-dropdown.php'); ?>
            </div>

        </div>

        <? include('include/search-dropdown.php'); ?>

        <div class="header__dropdown h-dropdown" id="catalogMenu">
            <div class="h-dropdown__container container">
                <div class="h-dropdown__wrapper">
                    <button class="btn-reset h-dropdown__close">
                        <svg width="14" height="14" viewBox="0 0 14 14">
                            <use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#close"></use>
                        </svg>
                    </button>

                    <div class="h-dropdown__col">
                        <div class="h-dropdown__section">
                            <a href="https://krikate.by/shop/" class="h-dropdown__section-title">ВСЕ ТОВАРЫ</a>
                        </div>
                        <!--<div class="h-dropdown__section">-->
                        <!--    <a href="/category/night-party-sale/" class="h-dropdown__section-title">NIGHT PARTY SALE</a>-->
                        <!--</div>-->
                          <div class="h-dropdown__section">
                            <a href="/category/sale/" class="h-dropdown__section-title">SALE</a>
                        </div>
                        <?
                        $catalog_menu = get_field('catalog_menu', 'option');
                        foreach ($catalog_menu as $block) {
                            echo '<div class="h-dropdown__section">';
                            $block_link = '';
                            $block_name = '';
                            if (isset($block['category']) && !empty($block['category'])) {
                                $term = get_term($block['category'], 'product_cat');
                                if ($term && !is_wp_error($term)) {
                                    $block_link = get_term_link($term);
                                    $block_name = $term->name;
                                }
                            }
                            if (isset($block['name']) && !empty($block['name'])) {
                                $block_name = $block['name'];
                            }
                            echo '<a href="' . $block_link . '" class="h-dropdown__section-title">' . $block_name . '</a>';
                            if ($block['child']){
                                foreach ($block['child'] as $el) {
                                    $el_link = '';
                                    $el_name = '';
                                    if (isset($el['category']) && !empty($el['category'])) {
                                        $term = get_term($el['category'], 'product_cat');
                                        if ($term && !is_wp_error($term)) {
                                            $el_link = get_term_link($term);
                                            $el_name = $term->name;
                                        }
                                    }
                                    if (isset($el['name']) && !empty($el['name'])) {
                                        $el_name = $block['name'];
                                    }
    
                                    echo '<a href="' . $el_link . '" class="h-dropdown__section-link">' . $el_name . '</a>';
                                }
                            }
                            
                            echo '</div>';

                            if ($block['br'] == true) {
                                echo '</div><div class="h-dropdown__section">';
                            }
                        }
                        ?>
                    </div>


                    <div class="h-dropdown__col">
						<?= wp_get_attachment_image(get_field('menu_image', 'option'), 'full'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__dropdown h-dropdown" id="buyersMenu">
            <div class="h-dropdown__container container">
                <div class="h-dropdown__wrapper">
                    <button class="btn-reset h-dropdown__close">
                        <svg width="14" height="14" viewBox="0 0 14 14">
                            <use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#close"></use>
                        </svg>
                    </button>
                    <div class="h-dropdown__col">
                        <div class="h-dropdown__section">
                            <a href="/oformlenie-zakaza/" class="h-dropdown__section-link">Оформление заказа</a>
                            <a href="/oplata-i-dostavka/" class="h-dropdown__section-link">Оплата и доставка</a>
                            <a href="/uhod/" class="h-dropdown__section-link">Памятка по уходу</a>
                            <a href="/vozvrat/" class="h-dropdown__section-link">Возврат</a>
                            <a href="/bonusnaja-sistema-lojalnosti/" class="h-dropdown__section-link">Бонусная система</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__modile-menu h-mobile-menu ps">
            <div class="h-mobile-menu__wrapper">
                <div class="h-mobile-menu__col">
                    <button class="h-mobile-menu__btn h-mobile-menu__link btn-reset" id="openCatalogNestedMenu">Каталог</button>
                    <!--<a href="/category/night-party-sale/" class="h-mobile-menu__link">NIGHT PARTY SALE</a>-->
                     <a href="/category/sale/" class="h-mobile-menu__link"><?= $sale_name ?></a> 
                    <!-- <a href="/category/gajdy/" class="h-mobile-menu__link">Гайды</a> -->
                    <a href="/shops/" class="h-mobile-menu__link">Магазины</a>
                    <a href="/lookbook/" class="h-mobile-menu__link">Lookbook</a>
                    <button class="h-mobile-menu__btn h-mobile-menu__link btn-reset" id="openBuyersNestedMenu">Покупателям</button>
                    <a href="/partnership/" class="h-mobile-menu__link">Сотрудничество</a>
                    <a href="/about/" class="h-mobile-menu__link">О бренде</a>
                    <a href="tel:<?= get_field('phone', 'option'); ?>" class="h-mobile-menu__link h-mobile-menu__phone"><?= get_field('phone', 'option'); ?></a>
                    <a href="<?= get_field('instagram', 'option'); ?>" class="h-mobile-menu__link" target="_blank">Instagram</a>
                    <a href="<?= get_field('telegram', 'option'); ?>" class="h-mobile-menu__link" target="_blank">Telegram</a>
                    <a href="<?= get_field('viber', 'option'); ?>" class="h-mobile-menu__link" target="_blank">Viber</a>
                </div>
                <div class="h-mobile-menu__col">
                    <div class="h-mobile-menu__level" id="catalogNestedMenu">
                        <button class="h-mobile-menu__back btn-reset">
                            <svg width="12" height="13" viewBox="0 0 12 13">
                                <use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#backarrow"></use>
                            </svg>
                        </button>
                        <div class="h-mobile-menu__section">
                            <a href="/shop/" class="h-mobile-menu__section-title">ВСЕ ТОВАРЫ</a>
                        </div>
                        <?
                        foreach ($catalog_menu as $block) {
                            echo '<div class="h-mobile-menu__section">';
                            $block_link = '';
                            $block_name = '';
                            if (isset($block['category']) && !empty($block['category'])) {
                                $term = get_term($block['category'], 'product_cat');
                                if ($term && !is_wp_error($term)) {
                                    $block_link = get_term_link($term);
                                    $block_name = $term->name;
                                }
                            }
                            if (isset($block['name']) && !empty($block['name'])) {
                                $block_name = $block['name'];
                            }
                            echo '<a href="' . $block_link . '" class="h-mobile-menu__section-title">' . $block_name . '</a>';
                            if ($block['child']) {
                                foreach ($block['child'] as $el) {
                                    $el_link = '';
                                    $el_name = '';
                                    if (isset($el['category']) && !empty($el['category'])) {
                                        $term = get_term($el['category'], 'product_cat');
                                        if ($term && !is_wp_error($term)) {
                                            $el_link = get_term_link($term);
                                            $el_name = $term->name;
                                        }
                                    }
                                    if (isset($el['name']) && !empty($el['name'])) {
                                        $el_name = $block['name'];
                                    }
    
                                    echo '<a href="' . $el_link . '" class="h-mobile-menu__section-link">' . $el_name . '</a>';
                                }
                            }
                            echo '</div>';
                        }
                        ?>

                    </div>
                    <div class="h-mobile-menu__level" id="buyersNestedMenu">
                        <button class="h-mobile-menu__back btn-reset">
                            <svg width="12" height="13" viewBox="0 0 12 13">
                                <use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#backarrow"></use>
                            </svg>
                        </button>
                        <div class="h-mobile-menu__section">
                            <a href="/oformlenie-zakaza/" class="h-mobile-menu__section-title">Оформление заказа</a>
                        </div>
                        <div class="h-mobile-menu__section">
                            <a href="/oplata-i-dostavka/" class="h-mobile-menu__section-title">Оплата и доставка</a>
                        </div>
                        <div class="h-mobile-menu__section">
                            <a href="/uhod/" class="h-mobile-menu__section-title">Памятка по уходу</a>
                        </div>
                        <div class="h-mobile-menu__section">
                            <a href="/vozvrat/" class="h-mobile-menu__section-title">Возврат</a>
                        </div>
                        <div class="h-mobile-menu__section">
                            
                            <a href="/bonusnaja-sistema-lojalnosti/" class="h-mobile-menu__section-title">Бонусная система</a>
                        </div>


                    </div>
                </div>
            </div>
            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
            </div>
        </div>
    </header>