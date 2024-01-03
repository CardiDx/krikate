<?php

/**
 * The template for displaying product category archives
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Your_Theme_Name
 * @since Your_Theme_Version
 */

get_header(); ?>
<main>
    <section class="breadcrumbs">
        <div class="breadcrumbs__container container">
            <ul class="breadcrumbs__list list-reset">
                <?php yoast_breadcrumb(); ?>
            </ul>
        </div>
    </section>

    <section class="catalog section-offset">
        <div class="catalog__container container">
            <h1 class="catalog__title page-title"><?= get_the_archive_title() ?></h1>
            <div class="catalog__filter">
                <button class="catalog__filter-btn btn-reset">Фильтры и сортировка</button>

                <? include 'catalog/catalog-filter.php'; ?>
            </div>

            <div class="catalog__body">
                <?
                include 'product-listing.php';
                get_template_part('product-listing');

                if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                    $filter_sort = $_GET['sort'];
                } else {
                    $filter_sort = NULL;
                }

                if (isset($_GET['category']) && !empty($_GET['category'])) {
                    $filter_category = explode(',', $_GET['category']);
                } else {
                    $filter_category[] = get_queried_object()->term_id;
                }

                if (isset($_GET['price']) && !empty($_GET['price'])) {
                    $filter_price = explode(',', $_GET['price']);
                } else {
                    $filter_price = NULL;
                }

                product_listing($filter_category, $filter_sort, $filter_price);

//                 $start_date = strtotime('2023-11-24 20:00:00'); // 24 ноября 20:00
// 				$end_date = strtotime('2023-11-26 23:59:59'); // 26 ноября 23:59
// 				$current_time = current_time('timestamp');
// 				$current_category_id = get_queried_object_id();
// 				if ( $current_category_id !== 79 ){
// 					product_listing($filter_category, $filter_sort, $filter_price);
// 				} else {
// 					if ($current_time >= $start_date && $current_time <= $end_date) {
// 						product_listing($filter_category, $filter_sort, $filter_price);
// 					}
// 				}
                ?>


                <div class="catalog__text">
                    <?
                    $term = get_queried_object();
                    echo get_term_field('description', $term);
                    ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?


// if (have_posts()) :
//     while (have_posts()) :
//         the_post();
//         // Выводите здесь содержимое категорий товаров
//         do_action('woocommerce_shop_loop');

//         wc_get_template_part('content', 'product');

//     endwhile;
// endif;

get_footer();
?>