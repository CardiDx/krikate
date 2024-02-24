<?php
function product_listing($category, $filter_sort, $filter_price)
{
    // if ($dop_args['page_url'] !== NULL) {
    //     $page_url = $dop_args['page_url'];
    // }

    $paged = get_query_var('paged') ? get_query_var('paged') : 1; // Учитываем пагинацию
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'orderby' => 'popularity',
        'paged' => $paged, // Учитываем пагинацию
        'posts_per_page' => '50',
        'tax_query' => array(
            'relation' => 'OR',
        ),
    );

    if (!empty($category[0])) {
        foreach ($category as $cat_id) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $cat_id,
            );
        }
    }

    if (!empty($filter_sort)) {
        switch ($filter_sort) {
            case 'popularity':
                $args['orderby'] = 'popularity';
                break;
            case 'newest':
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
                break;
            case 'price_desc':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = '_price';
                $args['order'] = 'DESC';
                break;
            case 'price_asc':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = '_price';
                $args['order'] = 'ASC';
                break;
        }
    }

    if (!empty($filter_price) && is_array($filter_price) && count($filter_price) === 2) {
        $min_price = floatval($filter_price[0]);
        $max_price = floatval($filter_price[1]);
    
        $args['meta_query'] = array(
            array(
                'key'     => '_price',
                'value'   => array($min_price, $max_price),
                'type'    => 'NUMERIC',
                'compare' => 'BETWEEN',
            ),
        );
    }

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        echo '<ul class="catalog__list list-reset">';

        while ($query->have_posts()) {
            $query->the_post();
            // wc_get_template_part('content', 'product');

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

            // вывод картоки с точками
            if( !empty($usedColors) ){
                wc_get_template_part('content', 'product');
            }
        }
        echo '</ul>';
        echo '<div class="catalog__pagination">' . get_my_pagination($query) . '</div>';
    } else {
        echo '<div class="post-no-found">Товаров не найдено</div>';
    }
    // the_posts_pagination();
}

function get_my_pagination($query_posts)
{
        $url_elements = parse_url($_SERVER['REQUEST_URI']);
        $pos = strripos($url_elements['path'], '/page/');
        if ($pos !== false) {
            $url_elements['path'] = stristr($url_elements['path'], '/page/', true);
            $url_elements['path'].= '/';
        }    
        $page_url_base = $url_elements['path'] . 'page/%#%/';
        if (!empty($url_elements['query'])){
            $page_url_base .= '?'.$url_elements['query'];
        }

    $args = array(
        'base' => $page_url_base,
        'current' => max(1, get_query_var('paged')),
        'total' => $query_posts->max_num_pages,
        'show_all' => false,
        'end_size' => 1,
        'mid_size' => 2,
        'prev_next' => true,
        'prev_text' => __('Назад'),
        'next_text' => __('Далее'),
        'type' => 'plain',
        'add_args' => false,
        'add_fragment' => ''
    );
    return paginate_links($args);
}
