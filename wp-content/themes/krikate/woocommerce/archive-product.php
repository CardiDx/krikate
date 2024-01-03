<? get_header(); ?>

<section class="breadcrumbs">
    <div class="breadcrumbs__container container">
        <ul class="breadcrumbs__list list-reset">
            <?php yoast_breadcrumb(); ?>
        </ul>
    </div>
</section>

<section class="catalog section-offset">
    <div class="catalog__container container">
        <h1 class="catalog__title page-title">Каталог</h1>
        <div class="catalog__categories">
            <div class="categories-slider swiper">
                <div class="categories-slider__wrapper swiper-wrapper">
                    <?php
                    // Получить категории первого уровня
                    $args = array(
                        'taxonomy' => 'product_cat', // Укажите таксономию WooCommerce для категорий товаров
                        'hide_empty' => false, // Показывать пустые категории
                        'parent' => 0, // Получить только категории первого уровня
                    );

                    $product_categories = get_terms($args);

                    foreach ($product_categories as $category) {
                        $category_link = get_term_link($category);
                        $category_image = get_term_meta($category->term_id, 'thumbnail_id', true);
                        $category_image_url = wp_get_attachment_url($category_image);
                    ?>

                        <div class="categories-slider__item swiper-slide">
                            <div class="category-item">
                                <a href="<?php echo esc_url($category_link); ?>" class="category-item__link">
                                    <div class="category-item__cover">
                                        <?php if ($category_image_url) : ?>
                                            <img src="<?php echo esc_url($category_image_url); ?>" alt="<?php echo esc_attr($category->name); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <h2 class="category-item__title"><?php echo esc_html($category->name); ?></h2>
                                </a>
                            </div>
                        </div>

                    <?php } ?>
                </div>
                <div class="categories-slider__nav-btn categories-slider__nav-btn--prev slider-nav-btn slider-nav-btn--prev">
                    <svg width="20" height="8" viewBox="0 0 20 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.08395 3.64645C0.888685 3.84171 0.888685 4.15829 1.08395 4.35355L4.26593 7.53553C4.46119 7.73079 4.77777 7.73079 4.97303 7.53553C5.1683 7.34027 5.1683 7.02369 4.97303 6.82843L2.14461 4L4.97303 1.17157C5.1683 0.976309 5.1683 0.659727 4.97303 0.464465C4.77777 0.269203 4.46119 0.269203 4.26593 0.464465L1.08395 3.64645ZM19.4375 3.5L1.4375 3.5L1.4375 4.5L19.4375 4.5L19.4375 3.5Z" fill="#1D1D1B" />
                    </svg>
                </div>
                <div class="categories-slider__nav-btn categories-slider__nav-btn--next slider-nav-btn slider-nav-btn--next">
                    <svg width="20" height="8" viewBox="0 0 20 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.9161 4.35355C19.1113 4.15829 19.1113 3.84171 18.9161 3.64645L15.7341 0.464466C15.5388 0.269204 15.2222 0.269204 15.027 0.464466C14.8317 0.659728 14.8317 0.976311 15.027 1.17157L17.8554 4L15.027 6.82843C14.8317 7.02369 14.8317 7.34027 15.027 7.53553C15.2222 7.7308 15.5388 7.7308 15.7341 7.53553L18.9161 4.35355ZM0.5625 4.5H18.5625V3.5H0.5625V4.5Z" fill="#1D1D1B" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="catalog__filter">
            <button class="catalog__filter-btn btn-reset">Фильтры и сортировка</button>
            <? include 'catalog/catalog-filter.php'; ?>
        </div>

        <div class="catalog__body">
            <?
            include 'product-listing.php';
            get_template_part('product-listing');
            
            if (isset($_GET['sort']) && !empty($_GET['sort'])){
                $filter_sort = $_GET['sort'];
            } else {
                $filter_sort = NULL;
            }

            if (isset($_GET['category']) && !empty($_GET['category'])){
                $filter_category = explode(',', $_GET['category']);
            } else {
                $filter_category[] = 0;
            }

            if (isset($_GET['price']) && !empty($_GET['price'])){
                $filter_price = explode(',', $_GET['price']);
            } else {
                $filter_price = NULL;
            }

            product_listing($filter_category, $filter_sort, $filter_price);
            ?>


        </div>
    </div>
</section>



<? get_footer(); ?>