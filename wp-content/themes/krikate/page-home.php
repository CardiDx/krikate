<?php
/* Template Name: Home Template */

get_header(); ?>

<?php
$template_uri = esc_url(get_template_directory_uri());

$slider = get_field('slider');
$advantage = get_field('advantage');
$products = get_field('products');
$products2 = get_field('products2');
$category_products = get_field('category_products');
?>

<main>
    <? if (isset($slider) && !empty($slider)) : ?>
        <section class="hero section-offset">
            <div class="hero__slider swiper">
                <div class="hero__slider-wrapper swiper-wrapper">
                    <? foreach ($slider as $slide) : ?>
                        <div class="hero__slider-item hero-slide swiper-slide">
                            <a href="<?= $slide['link'] ?>" class="hero-slide__wrapper" style="background-image: url('<?= $slide['image'] ?>');">
                                <div class="hero-slide__content">
                                    <div class="hero-slide__title"><?= $slide['headline'] ?></div>
                                    <div class="hero-slide__btn primary-button">В каталог</div>
                                </div>
                            </a>
                        </div>
                    <? endforeach; ?>
                    <? foreach ($slider as $slide) : ?>
                        <div class="hero__slider-item hero-slide swiper-slide">
                            <a href="<?= $slide['link'] ?>" class="hero-slide__wrapper" style="background-image: url('<?= $slide['image'] ?>');">
                                <div class="hero-slide__content">
                                    <div class="hero-slide__title"><?= $slide['headline'] ?></div>
                                    <div class="hero-slide__btn primary-button">В каталог</div>
                                </div>
                            </a>
                        </div>
                        
                    <? endforeach; ?>
                </div>
                <div class="hero__slider-pagination swiper-pagination"></div>
                <div class="hero__slider-nav-btn hero__slider-nav-btn--prev slider-nav-btn slider-nav-btn--prev">
                    <svg width="20" height="8" viewBox="0 0 20 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.08395 3.64645C0.888685 3.84171 0.888685 4.15829 1.08395 4.35355L4.26593 7.53553C4.46119 7.73079 4.77777 7.73079 4.97303 7.53553C5.1683 7.34027 5.1683 7.02369 4.97303 6.82843L2.14461 4L4.97303 1.17157C5.1683 0.976309 5.1683 0.659727 4.97303 0.464465C4.77777 0.269203 4.46119 0.269203 4.26593 0.464465L1.08395 3.64645ZM19.4375 3.5L1.4375 3.5L1.4375 4.5L19.4375 4.5L19.4375 3.5Z" fill="#1D1D1B" />
                    </svg>
                </div>
                <div class="hero__slider-nav-btn hero__slider-nav-btn--next slider-nav-btn slider-nav-btn--next">
                    <svg width="20" height="8" viewBox="0 0 20 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.9161 4.35355C19.1113 4.15829 19.1113 3.84171 18.9161 3.64645L15.7341 0.464466C15.5388 0.269204 15.2222 0.269204 15.027 0.464466C14.8317 0.659728 14.8317 0.976311 15.027 1.17157L17.8554 4L15.027 6.82843C14.8317 7.02369 14.8317 7.34027 15.027 7.53553C15.2222 7.7308 15.5388 7.7308 15.7341 7.53553L18.9161 4.35355ZM0.5625 4.5H18.5625V3.5H0.5625V4.5Z" fill="#1D1D1B" />
                    </svg>
                </div>
            </div>
            <a href="/shop/" class="hero__btn hero__btn--mobile primary-button">В каталог</a>
        </section>
    <? endif; ?>

    <? if (isset($advantage) && !empty($advantage)) : ?>
        <section class="advantages section-offset">
            <div class="advantages__container container">
                <ul class="advantages__list list-reset">
                    <? foreach ($advantage as $adv) : ?>
                        <li class="advantages__list-item advantages-item">
                            <div class="advantages-item__icon">
                                <?= wp_get_attachment_image($adv['icon']) ?>
                            </div>
                            <div class="advantages-item__desc"><?= $adv['headline'] ?></div>
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>
        </section>
    <? endif; ?>

    <? if (isset($products) && !empty($products)) : ?>
        <section class="collection section-offset">
            <div class="collection__container container">
                <h1 class="collection__title"><?= $products['headline'] ?></h1>
                <?
                if (!empty($products['list'])) {
                    $args = array(
                        'post_type' => 'product',
                        // 'posts_per_page' => 4,
                        'post__in' => $products['list'],
                        'orderby' => 'menu_order',
                    );
                    $products_list = new WP_Query($args);
                    if ($products_list->have_posts()) {
                        echo '<ul class="collection__list list-reset">';

                        // счетчик выведенных товаров
                        $productsCounter = 0;

                        while ($products_list->have_posts()) {
                            $products_list->the_post();

                            // прерываем вывод постов если было выведено уже 4
                            if( $productsCounter >= 4 ) {
                                break;
                            }

                            $product_id = get_the_ID();
                            $product = wc_get_product($product_id);
                            $usedColors = array();

                            // перебираем все вариации товара
                            foreach ( $product->get_available_variations() as $key => $variation ) {
                                // echo '<pre>';
                                // print_r($variation);
                                // echo '</pre>';

                                $variationColor = $variation['attributes']['attribute_pa_color'];
                                
                                if (in_array($variationColor, $usedColors)) {
                                    // мы уже записали в массив этот цвет
                                    continue;
                                } else {
                                    // этого цвета в массиве не было
                                    if( $variation['is_in_stock'] || $variation['max_qty'] || $variation['backorders_allowed'] ) {
                                        // вывод карточки ОДНОЙ вариации
                                        // woocommerce_get_template( 'content-product.php', array('variationID' => $variation['variation_id']) );
                                        // добавляем цвет в массив, если он есть в наличии или предзаказе
                                        array_push($usedColors, $variationColor);
                                    }
                                }
                                
                            }

                            if( !empty($usedColors) ){
                                // вывод картоки с точками
                                wc_get_template_part('content', 'product');   
                                // инкрементим счетчик выведенных товаров
                                $productsCounter++;
                            }


                        }
                        echo '</ul>';
                    }
                    wp_reset_postdata();
                }
                ?>
            </div>
        </section>
    <? endif; ?>

    <? if (isset($products2) && !empty($products2)) : ?>
        <section class="collection section-offset">
            <div class="collection__container container">
                <h1 class="collection__title"><?= $products2['headline'] ?></h1>
                <?
                if (!empty($products2['list'])) {
                    $args = array(
                        'post_type' => 'product',
                        // 'posts_per_page' => 4,
                        'post__in' => $products2['list'],
                        'orderby' => 'menu_order',
                    );
                    $products2_list = new WP_Query($args);
                    if ($products2_list->have_posts()) {
                        echo '<ul class="collection__list list-reset">';

                        // счетчик выведенных товаров
                        $productsCounter2 = 0;

                        while ($products2_list->have_posts()) {
                            $products2_list->the_post();

                            // прерываем вывод постов если было выведено уже 4
                            if( $products2Counter >= 4 ) {
                                break;
                            }

                            $product2_id = get_the_ID();
                            $product2 = wc_get_product($product2_id);
                            $usedColors2 = array();

                            // перебираем все вариации товара
                            foreach ( $product2->get_available_variations() as $key => $variation ) {
                                // echo '<pre>';
                                // print_r($variation);
                                // echo '</pre>';

                                $variationColor = $variation['attributes']['attribute_pa_color'];
                                
                                if (in_array($variationColor, $usedColors2)) {
                                    // мы уже записали в массив этот цвет
                                    continue;
                                } else {
                                    // этого цвета в массиве не было
                                    if( $variation['is_in_stock'] || $variation['max_qty'] || $variation['backorders_allowed'] ) {
                                        // вывод карточки ОДНОЙ вариации
                                        // woocommerce_get_template( 'content-product.php', array('variationID' => $variation['variation_id']) );
                                        // добавляем цвет в массив, если он есть в наличии или предзаказе
                                        array_push($usedColors2, $variationColor);
                                    }
                                }
                                
                            }

                            if( !empty($usedColors2) ){
                                // вывод картоки с точками
                                wc_get_template_part('content', 'product');   
                                // инкрементим счетчик выведенных товаров
                                $productsCounter2++;
                            }


                        }
                        echo '</ul>';
                    }
                    wp_reset_postdata();
                }
                ?>
            </div>
        </section>
    <? endif; ?>

    <? get_template_part('elements/element-instagram'); ?>

    <? if (isset($category_products) && !empty($category_products)) : ?>
        <section class="categories section-offset">
            <div class="categories__container container">
                <ul class="categories__list list-reset">

                    <?php
                    foreach ($category_products as $category_id) {
                        $category = get_term($category_id, 'product_cat');

                        if ($category && !is_wp_error($category)) {
                            $category_name = $category->name;
                            $category_link = get_term_link($category); // Получаем ссылку на категорию
                            $category_image = get_term_meta($category->term_id, 'thumbnail_id', true); // Получаем ID изображения (если есть)

                            echo '<li class="categories__list-item category-item">';
                            echo '<a href="' . esc_url($category_link) . '" class="category-item__link">';

                            if ($category_image) {
                                echo '<div class="category-item__cover">';
                                echo wp_get_attachment_image($category_image, 'full', false, array('alt' => esc_attr($category_name)));
                                echo '</div>';
                            }

                            echo '<h2 class="category-item__title">' . esc_html($category_name) . '</h2>';
                            echo '</a>';
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </section>
    <? endif; ?>

    <? get_template_part('elements/element-subscription'); ?>
</main>

<?php get_footer(); ?>