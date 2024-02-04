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

            $product_id = get_the_ID();
            $product = wc_get_product($product_id);
            
            if ($product->is_type('variable')) {
                $variations = $product->get_available_variations();
                $product_info = product_info(get_the_ID());
                $product_color = $product_info['nt_color'];
                
                // echo '<pre>';
                // print_r($product_color);
                // echo '</pre>';
                
                $color_index = 0;
                
                foreach ($product_color as $color) {
                    $term = get_term_by('slug', $color, 'pa_color');
                    // echo '<pre>';
                    // print_r($term);
                    // echo '</pre>';

                    // if ($term && !is_wp_error($term)) {
                    //     $color_code = get_term_meta($term->term_id, 'color_code', true);
                    //     $color_name = $term->name;
                    //     if (empty($color_code)) {
                    //         $color_code = '#1D1D1B';
                    //     }
                    // }
                    // if ($color_index == 0) {
                    //     echo '<button id="' . $color . '" style="color: ' . $color_code . ';" class="product-card__colors-item product-card__colors-item--selected btn-reset" data-color-name="' . $color_name . '"></button>';
                    // } else {
                    //     echo '<button id="' . $color . '" style="color: ' . $color_code . ';" class="product-card__colors-item btn-reset" data-color-name="' . $color_name . '"></button>';
                    // }
                    $color_index++;
                }
                // if($product->slug == 'podarochnaja-karta'){
                //     echo '<button id="belyj" style="color: #ffffff;" class="product-card__colors-item product-card__colors-item--selected btn-reset" data-color-name="Белый"></button>';
                // }
            }

            // if we need to print default cards with variations
            // woocommerce_get_template( 'content-product.php' );

            // if we need to print every variation as single card

            // storage for printed colors
            $usedColors = array();

            foreach ( $product->get_available_variations() as $key => $variation ) {
                // echo '<pre>';
                // echo 'availability_html = ' . $variation['availability_html'];
                // echo 'max_qty = ' . $variation['max_qty'];
                // echo 'backorders_allowed = ' . $variation['backorders_allowed'];
                // print_r($variation);
                // print_r($variation['variation_id']);
                // print_r($variation['image']['url']);
                // print_r($variation['attributes']['attribute_pa_color']);
                // echo '</pre>';

                $variationColor = $variation['attributes']['attribute_pa_color'];
                
                if (in_array($variationColor, $usedColors)) {
                    // we already printed variation with this color
                    continue;
                } else {
                    // we need to print wariation with this color
                    if( $variation['max_qty'] || $variation['backorders_allowed'] ) {
                        woocommerce_get_template( 'content-product.php', array('variationID' => $variation['variation_id']) );
                    }
                    array_push($usedColors, $variationColor);
                }
                
                // echo '<pre>';
                // print_r($usedColors);
                // echo '</pre>';
            }

            // wc_get_template_part('content', 'product');
        }
        
        // echo '<pre>';
        // print_r($query->posts);
        // echo '</pre>';


        // foreach ( $query->posts as $post ) {
        //     // echo '<pre>';
        //     // print_r($post);
        //     // echo '</pre>';
            
        //     $product = wc_get_product($post->ID);
        //     $current_products = $product->get_children();
        //     // echo '<pre>';
        //     // print_r($current_products);
        //     // echo '</pre>';
            
        //     foreach ( $current_products as $key => $variation ) {
                
        //         $product = wc_get_product($variation);
        //         echo '<pre>';
        //         print_r($product);
        //         echo '</pre>';

        //     }

        //     // foreach ( $product->get_available_variations() as $key => $variation ) {
        //     //     // Loop through the product attributes for this variation
        //     //     foreach ($variation['attributes'] as $attribute => $term_slug ) {
        //     //         // Get the taxonomy slug
        //     //         $taxonmomy = str_replace( 'attribute_', '', $attribute );

        //     //         // Get the attribute label name
        //     //         $attr_label_name = wc_attribute_label( $taxonmomy );

        //     //         // Display attribute labe name
        //     //         // $term_name = get_term_by( 'slug', $term_slug, $taxonmomy )->name;

        //     //         // Testing output
        //     //         // echo '<p>' . $attr_label_name . ': ' . $term_name . '</p>';
        //     //     }
        //     // }
        // }

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
