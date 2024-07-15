<?
function product_info($id)
{
    $product = wc_get_product($id);

    if (!$product) {
        return 'товар не найден';
    } else {
        $variations = $product->get_available_variations();

        $nt_color = array();
        $nt_size = array();
        $nt_image = array();
        $nt_price = array();
        $nt_id = array();
        $nt_stock = array();

        foreach ($variations as $variation) {
            if (isset($variation['attributes']['attribute_pa_color']) && !empty($variation['attributes']['attribute_pa_color']) && isset($variation['attributes']['attribute_pa_size']) && !empty($variation['attributes']['attribute_pa_size'])) {
                $color = $variation['attributes']['attribute_pa_color'];
                $size = $variation['attributes']['attribute_pa_size'];

                if (!in_array($color, $nt_color)) {
                    $nt_color[] = $color;
                }
                $nt_size[$color][] = $size;

                foreach ($variation["variation_gallery_images"] as $variation_image) {
                    $image = $variation_image['image_id'];
                    if (!isset($nt_image[$color]) || !in_array($image, $nt_image[$color])) {
                        $nt_image[$color][] = $variation_image['image_id'];
                    }
                }

                $nt_price[$color][$size]['regular_price'] = $variation['display_regular_price'];
                $nt_price[$color][$size]['price'] = $variation['display_price'];

                $nt_id[$color][$size] = $variation['variation_id'];

                $variation_obj = new WC_Product_Variation( $variation['variation_id'] );
                $nt_stock[$color][$size] = $variation_obj->get_stock_status();
            }
        }

        $product_info['nt_color'] = $nt_color;
        $product_info['nt_size'] = $nt_size;
        $product_info['nt_image'] = $nt_image;
        $product_info['nt_price'] = $nt_price;
        $product_info['nt_id'] = $nt_id;
        $product_info['nt_stock'] = $nt_stock;

        return $product_info;
    }
}

// Вывод галереи

function view_product_image($nt_image, $key)
{
    $gallery = '';
    $gallery .= '<div class="gallery-slider swiper"><div class="gallery-slider__wrapper swiper-wrapper">';

    foreach ($nt_image[$key] as $nt_val) {
        $gallery .= '<div class="gallery-slider__item swiper-slide" data-product-color="' . $key . '"><a class="glightbox" href="' . wp_get_attachment_image_url($nt_val, 'full') . '">' . wp_get_attachment_image($nt_val, 'full') . '</a></div>';
    }
    $gallery .= '</div><div class="swiper-pagination"></div></div>';

    return $gallery;
}

// Вывод плитки

function view_product_tile($nt_image, $key)
{
    $gallery = '';
    $gallery .= '<div class="gallery-tile-wrapper"><div class="gallery-tile">';

    foreach ($nt_image[$key] as $nt_val) {
        $gallery .= 
        '<div class="gallery-tile__img-wrapper" data-product-color="' . $key . '">'
             . wp_get_attachment_image($nt_val, 'full') . 
        '</div>';
    }
    $gallery .= '</div></div>';

    return $gallery;
}

// Вывод цены

function view_product_price($nt_price, $key, $size)
{
    $price_return = '';
    $regular_price = $nt_price[$key][$size]['regular_price'];
    $price = $nt_price[$key][$size]['price'];
    if ($price < $regular_price) {
        $sale = 100 - ($price * 100 / $regular_price);
        $sale = round($sale, 0);
        $price_return .= '<div class="product__price-current">' . $price . ' byn</div>
    <div class="product__price-discount">-' . $sale . '%</div>
    <div class="product__price-old">' . $regular_price . ' byn</div>';
    } else {
        $price_return .= '<div class="product__price-current">' . $price . ' byn</div>';
    }

    return $price_return;
}



// Функция получения названия магазина по его айдишнику из майсклада
function getShopName( $stockArray, $shopID ){
    $shopName = '';
    foreach( array_values($stockArray)[0] as $shop ){
        if( $shop['store_uuid'] == $shopID ){
            $shopName = $shop['store_name'];
            if( $shopName == 'Склад интернет-магазина и производство' ){
                $shopName = 'Склад интернет-магазина';
            }
            break;
        }
    }

    return $shopName;
}

// Функция получения количества вариации по его айдишнику и айдишнику магазина
function getProductInShopQuantity( $stockArray, $shopID, $variationID ){
    $variationQuantity = '';

    foreach( $stockArray[$variationID] as $shop ){
        if( $shop['store_uuid'] == $shopID ){
            $variationQuantity = $shop['quantity'];
            break;
        }
    }

    return $variationQuantity;
}

// Таблица наличия в магазинах

function view_product_stock_table( $product_id, $color )
{
    $stock_table = 'Ой, не получилось загрузить таблицу :(';

    if (class_exists('\Wdc\Addition\Stores\AdditionController')){
        
        // получаем массив наличия товара в магазинах
        $settings = get_option('wms_settings_stock');
        $AdditionController = new Wdc\Addition\Stores\AdditionController($settings);
        $stockArray = $AdditionController->getStocksToStoresWithVariations($product_id);
        
        // формируем массив айдишников магазинов
        $shopIDs = [];
        foreach( array_values($stockArray)[0] as $key => $value ){
            array_push($shopIDs, $value['store_uuid']);
        }

        // формируем массив размеров
        $produstSizes = [];
        $product = wc_get_product($product_id);
        $productVariations = $product->get_available_variations();
        foreach( $productVariations as $productVariation ){
            if( $productVariation['attributes']['attribute_pa_color'] == $color ){
                array_push( $produstSizes, [
                    0 => $productVariation['variation_id'], 
                    1 => $productVariation['attributes']['attribute_pa_size'], 
                ] );
            }            
        }

        // Город и номер телефона по айдишнику магазина
        $shopsInfo = [
            '6198bc39-8d21-11ee-0a80-0b2d007aee5d' => [
                'city' => 'Минск',
                'address' => 'TЦ Galleria 5 этаж (пространство Trend park)',
                'phone' => '+375 (33) 917-41-61',
            ],
            '6fa6aa66-8d21-11ee-0a80-04b4007d980c' => [
                'city' => 'Гродно',
                'address' => 'ул. Советская 31, 3 этаж',
                'phone' => '+375 (33) 914-41-61',
            ],
            '7b3c020f-8d21-11ee-0a80-07f9007d7ebe' => [
                'city' => 'Минск',
                'address' => 'ТЦ Dana mall 1 этаж (пространство We are)',
                'phone' => '+375 (33) 992-41-61',
            ],
            'cb2ffc11-8d08-11ee-0a80-09970074e796' => [
                'city' => 'Гродно',
                'address' => 'ТЦ Triniti 2 этаж (пространство We are)',
                'phone' => '+375 (33) 918-41-61',
            ],
        ];

        // формируем таблицу наличия в магазинах
        $stock_table = '';
        $stock_table .= '<table>';
            $stock_table .= '<thead>';
                $stock_table .= '<tr>';
                    $stock_table .= '<td>';
                    $stock_table .= '</td>';
                    
                    // рисуем размеры
                    foreach( $produstSizes as $produstSize ){
                    $stock_table .= '<td>';
                        $stock_table .= $produstSize[1];
                    $stock_table .= '</td>';
                    }

                $stock_table .= '</tr>';
            $stock_table .= '</thead>';
            $stock_table .= '<tbody>';
                
                // рисуем строки с количеством
                foreach( $shopIDs as $shopID ){
                    $stock_table .= '<tr>';
                        $stock_table .= '<td>';
                            $stock_table .= '<span class="stock-table__city">' . $shopsInfo[$shopID]['city'] . '</span>';
                            // $stock_table .= $shopID;
                            // $stock_table .= getShopName( $stockArray, $shopID );
                            $stock_table .= $shopsInfo[$shopID]['address'];
                            $stock_table .= '<a href="tel:"' . $shopsInfo[$shopID]['phone'] . ' class="stock-table__phone">' . $shopsInfo[$shopID]['phone'] . '</a>';
                        $stock_table .= '</td>';
                        foreach( $produstSizes as $produstSize ){
                        $stock_table .= '<td>';
                            $stock_table .= getProductInShopQuantity( $stockArray, $shopID, $produstSize[0]);
                        $stock_table .= '</td>';
                        }
                    $stock_table .= '</tr>';
                }

            $stock_table .= '</tbody>';
        $stock_table .= '</table>';

        // $stock_table = $stockArray;
        // $stock_table = $shopIDs;
        // $stock_table = $produstSizes;
        // $stock_table = $productVariations;
    }

    return $stock_table;
}

function my_ajax_view_product_stock_table()
{
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
    $color = isset($_POST['key']) ? $_POST['key'] : '';

    $table = view_product_stock_table( $product_id, $color );
    echo json_encode($table);
    wp_die();
}

add_action('wp_ajax_my_ajax_view_product_stock_table', 'my_ajax_view_product_stock_table');
add_action('wp_ajax_nopriv_my_ajax_view_product_stock_table', 'my_ajax_view_product_stock_table');



// Вывод цветов

function view_product_colors($nt_image, $key)
{
    $color_return = '';

    $attribute = get_term_by('slug', $key, 'pa_color');
    $attribute_name = $attribute->name;

    $color_return .= '<div class="product__color-label">Цвет<div class="product__color-value">' . $attribute_name . '</div></div>';
    $color_return .= '<div class="product__color-list">';

    foreach ($nt_image as $nt_key => $nt_var) {
        $nt_attribute = get_term_by('slug', $nt_key, 'pa_color');
        $nt_attribute_name = $nt_attribute->name;
        if ($key == $nt_key) {
            $color_return .= '<button class="product__color-item product__color-item--selected btn-reset" data-color="' . $nt_attribute_name . '" data-product-color="' . $nt_key . '">';
        } else {
            $color_return .= '<button title="' . $nt_attribute_name . '" class="product__color-item btn-reset" data-color="' . $nt_attribute_name . '" data-product-color="' . $nt_key . '">';
        }
        $color_return .= wp_get_attachment_image($nt_var[0],);
        $color_return .= '</button>';
    }

    $color_return .= '</div>';

    return $color_return;
}



add_action('wp_ajax_add_to_cart', 'add_variation_to_cart');
add_action('wp_ajax_nopriv_add_to_cart', 'add_variation_to_cart');

function add_variation_to_cart()
{
    $variation_id = intval($_POST['variation_id']);
    $quantity = intval($_POST['quantity']);

    if ($variation_id > 0) {
        WC()->cart->add_to_cart($variation_id, $quantity);
        echo 'Товар добавлен в корзину';
    } else {
        echo 'Произошла ошибка';
    }
    wp_die();
}





function my_ajax_view_product_image()
{
    $id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
    $key = isset($_POST['key']) ? $_POST['key'] : '';
    $product_info = product_info($id);

    $nt_image = $product_info['nt_image'];
    $gallery = view_product_image($nt_image, $key);
    echo json_encode($gallery);
    wp_die();
}

add_action('wp_ajax_my_ajax_view_product_image', 'my_ajax_view_product_image');
add_action('wp_ajax_nopriv_my_ajax_view_product_image', 'my_ajax_view_product_image');


function my_ajax_view_product_tile()
{
    $id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
    $key = isset($_POST['key']) ? $_POST['key'] : '';
    $product_info = product_info($id);

    $nt_image = $product_info['nt_image'];
    $tile = view_product_tile($nt_image, $key);
    echo json_encode($tile);
    wp_die();
}

add_action('wp_ajax_my_ajax_view_product_tile', 'my_ajax_view_product_tile');
add_action('wp_ajax_nopriv_my_ajax_view_product_tile', 'my_ajax_view_product_tile');



// function view_product_price_listing($product_price, $meta)
function view_product_price_listing($product_price)
{
    $i = 0;
    // echo '<pre>';
    // print_r($product_price);
    // echo '</pre>';

    // variable for variation color
    $meta = '';

    // if we have color argument inside
    if( isset($product_price['meta']) && !empty($product_price['meta']) ){
        $meta = $product_price['meta'];
    }

    // if we have product price inside of array
    if( isset($product_price['product_price']) && !empty($product_price['product_price']) ){
        $product_price = $product_price['product_price'];
    }

    // $price = $product_price[$price][0]['price'];
    if( isset($meta) && !empty($meta) ){
        $variationPrice = array_values( $product_price[$meta] )[0]['price'];
    }
    
    // echo '<pre>';
    // print_r($meta);
    // print_r($variationPrice);
    // print_r($product_price);
    // echo '</pre>';

    if (isset($_POST['product_color']) && isset($_POST['product_id'])) {
        $product_info = product_info($_POST['product_id']);
        $product_price = $product_info['nt_price'];
        // var_dump($product_price[$_POST['product_color']]);
        foreach ($product_price[$_POST['product_color']] as $size) {
            if ($i == 0) {
                $regular_price = $size['regular_price'];
                $price = $size['price'];
                $i++;
            }
        }
    } else {
        foreach ($product_price as $color) {
            foreach ($color as $size) {
                if ($i == 0) {
                    $regular_price = $size['regular_price'];
                    $price = $size['price'];
                    $i++;
                }
            }
        }
    }

    $price_return = '';
    if( isset($variationPrice) && !empty($variationPrice) ){
        $price = $variationPrice;
    }
    if (!empty($price) && $price < $regular_price) {
        $sale = 100 - ($price * 100 / $regular_price);
        $sale = round($sale, 0);

        $price_return .= '<div class="product-card__price">' . $price . ' byn</div>';
        $price_return .= '<div class="product-card__discount">-' . $sale . '%</div>';
        $price_return .= '<div class="product-card__old">' . $regular_price . ' byn</div>';
    } elseif (!empty($price)) {
        $price_return .= '<div class="product-card__current">' . $price . ' byn</div>';
    }

    echo $price_return;
}
add_action('wp_ajax_view_product_price_listing', 'view_product_price_listing');
add_action('wp_ajax_nopriv_view_product_price_listing', 'view_product_price_listing');



function select_size_product()
{
    $id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
    $color_var = isset($_POST['color_var']) ? $_POST['color_var'] : '';
    $product_info = product_info($id);
    $nt_size = $product_info['nt_size'][$color_var];
    $nt_id = $product_info['nt_id'];
    $nt_stock = $product_info['nt_stock'];

    foreach ($nt_size as $size) {
        $id = $nt_id[$color_var][$size];
        $stock = $nt_stock[$color_var][$size];
        echo '<button class="size-btn btn-reset" data-variation-product-id="' . $id . '" data-variation-product-stock="' . $stock . '">' . $size . '</button>';
    }
    wp_die();
}

add_action('wp_ajax_select_size_product', 'select_size_product');
add_action('wp_ajax_nopriv_select_size_product', 'select_size_product');


function remove_from_cart()
{
    $product_id = intval($_POST['product_id']);
    $variation_id = intval($_POST['variation_id']);

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        if ($cart_item['product_id'] == $product_id && $cart_item['variation_id'] == $variation_id) {
            WC()->cart->remove_cart_item($cart_item_key);
            break; // После удаления можно завершить цикл
        }
    }
}

add_action('wp_ajax_remove_from_cart', 'remove_from_cart');
add_action('wp_ajax_nopriv_remove_from_cart', 'remove_from_cart');



function clear_cart()
{
    WC()->cart->empty_cart();
    echo json_encode(array('success' => true, 'cart' => WC()->cart->get_cart()));
    wp_die();
}

add_action('wp_ajax_clear_cart', 'clear_cart');
add_action('wp_ajax_nopriv_clear_cart', 'clear_cart');



function update_cart_item_quantity()
{
    $product_id = intval($_POST['product_id']);
    $variation_id = intval($_POST['variation_id']);
    $new_quantity = intval($_POST['quantity']);

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        if ($cart_item['product_id'] == $product_id && $cart_item['variation_id'] == $variation_id) {
            WC()->cart->set_quantity($cart_item_key, $new_quantity);
            break;
        }
    }
}


add_action('wp_ajax_update_cart_item_quantity', 'update_cart_item_quantity');
add_action('wp_ajax_nopriv_update_cart_item_quantity', 'update_cart_item_quantity');


function update_cart()
{
    require  get_template_directory() . '/woocommerce/cart-dropdown.php';
}


add_action('wp_ajax_update_cart', 'update_cart');
add_action('wp_ajax_nopriv_update_cart', 'update_cart');


function update_cart_page()
{
    require  get_template_directory() . '/woocommerce/cart/basket-body.php';
}


add_action('wp_ajax_update_cart_page', 'update_cart_page');
add_action('wp_ajax_nopriv_update_cart_page', 'update_cart_page');


function update_checkout()
{
    echo '<div class="checkout_preloader-page disabled">
    <svg viewBox="25 25 50 50">
        <circle r="20" cy="50" cx="50"></circle>
    </svg>
</div>';
    echo do_shortcode('[woocommerce_checkout]');
}


add_action('wp_ajax_update_checkout', 'update_checkout');
add_action('wp_ajax_nopriv_update_checkout', 'update_checkout');


function update_checkout_total_price()
{
    wc_cart_totals_order_total_html();
}


add_action('wp_ajax_update_checkout_total_price', 'update_checkout_total_price');
add_action('wp_ajax_nopriv_update_checkout_total_price', 'update_checkout_total_price');


function get_min_max_product_price()
{
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_price',
                'value' => '',
                'compare' => '>',
                'type' => 'NUMERIC'
            )
        ),
        'fields' => 'ids'
    );

    $query = new WP_Query($args);

    $min_price = 0;
    $max_price = 0;

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product = wc_get_product(get_the_ID());
            $price = $product->get_price();

            if ($min_price === 0 || $price < $min_price) {
                $min_price = $price;
            }
            if ($price > $max_price) {
                $max_price = $price;
            }
        }
        wp_reset_postdata();
    }

    return array(
        'min_price' => $min_price,
        'max_price' => $max_price
    );
}


add_action('wp_ajax_get_filtered_product_count', 'get_filtered_product_count');
add_action('wp_ajax_nopriv_get_filtered_product_count', 'get_filtered_product_count');

function get_filtered_product_count()
{
    $category = explode(',', sanitize_text_field($_POST['category']));
    $filter_sort = sanitize_text_field($_POST['sort']);
    $filter_price = explode(',', sanitize_text_field($_POST['price']));

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'orderby' => 'popularity',
        'posts_per_page' => -1,
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
    $count = $query->found_posts;

    wp_send_json(array('count' => $count));
    wp_die();
}


function product_search_ajax()
{
    $search_query = sanitize_text_field($_POST['search_query']);

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        's' => $search_query,
        'posts_per_page' => 6,
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            require  get_template_directory() . '/woocommerce/search-product-listing.php';
        }
    } else {
        echo 'Ничего не найдено.';
    }

    wp_die();
}

add_action('wp_ajax_product_search_ajax', 'product_search_ajax');
add_action('wp_ajax_nopriv_product_search_ajax', 'product_search_ajax');


function save_recently_viewed_products()
{
    $product_id = get_the_ID();
    $recently_viewed = isset($_COOKIE['recently_viewed']) ? json_decode(stripslashes($_COOKIE['recently_viewed']), true) : array();

    if (($key = array_search($product_id, $recently_viewed)) !== false) {
        unset($recently_viewed[$key]);
        array_unshift($recently_viewed, $product_id);
    }

    if (!in_array($product_id, $recently_viewed)) {
        array_unshift($recently_viewed, $product_id);
    } else {
    }
    if (count($recently_viewed) > 10) {
        array_pop($recently_viewed);
    }
    setcookie('recently_viewed', json_encode($recently_viewed), time() + 3600 * 24 * 7, COOKIEPATH, COOKIE_DOMAIN);
}

add_action('template_redirect', 'save_recently_viewed_products');


function add_promocode()
{
    $code = $_POST['code'];
    if (WC()->cart->has_discount($code)) {
        echo 'Этот промокод уже применен к вашей корзине.';
    } else {
        $coupon = new WC_Coupon($code);
        if ($coupon->is_valid()) {
            WC()->cart->apply_coupon($code);
            echo 'Промокод успешно добавлен в корзину.';
        } else {
            echo 'NULL';
        }
    }

    wp_die();
}

add_action('wp_ajax_add_promocode', 'add_promocode');
add_action('wp_ajax_nopriv_add_promocode', 'add_promocode');

function reset_promocode()
{
    $code = $_POST['code'];
    
    if (WC()->cart->has_discount($code)) {
        WC()->cart->remove_coupon($code);
        WC()->cart->calculate_totals();

        echo 'Промокод успешно удален из корзины.';
    } else {
        echo 'Этого промокода нет в вашей корзине.';
    }
    wp_die();
}

add_action('wp_ajax_reset_promocode', 'reset_promocode');
add_action('wp_ajax_nopriv_reset_promocode', 'reset_promocode');



function onbackorder_product_info()
{
    $variation_id = $_POST['variation_id'];
    $variation = wc_get_product($variation_id);

    if ($variation) {
        $image = $variation->get_image();
        $title = $variation->get_name();
        $price = $variation->get_price();
        $regular_price = $variation->get_regular_price();

        $colorAttribute = $variation->get_attribute('pa_color');
        $sizeAttribute = $variation->get_attribute('pa_size');

        if ($price < $regular_price) {
            $sale = 100 - ($price * 100 / $regular_price);
            $sale = round($sale, 0);
            $price_return = '<div class="cart-item__price">' . $price . ' BYN</div>
            <div class="cart-item__discount">-' . $sale . '%</div>
            <div class="cart-item__old">' . $regular_price . ' BYN</div>';
        } else {
            $price_return = '<div class="cart-item__price">' . $price . ' byn</div>';
        }


        echo '<div class="cart-item__wrapper">
                <div class="cart-item__picture">'. $image .'</div>
                <div class="cart-item__body">
                    <div class="cart-item__title">' . $title . '</div>
                    <div class="cart-item__info">
                        Размер
                        <span class="cart-item__size">' . $sizeAttribute . '</span>
                    </div>
                    <div class="cart-item__info">
                        Цвет
                        <span class="cart-item__color">' . $colorAttribute . '</span>
                    </div>
                    <div class="cart-item__wrap">'.$price_return.'</div>
                </div>
            </div>';
            exit;
    }

}

add_action('wp_ajax_onbackorder_product_info', 'onbackorder_product_info');
add_action('wp_ajax_nopriv_onbackorder_product_info', 'onbackorder_product_info');


function onBackorderForm() {
    $form_type = $_POST['form-type'];
    $to = 'shop@krikate.by';
    $headers = 'From: wordpress@krikate.by';

    if($form_type == 'pre_order'){
        $variation_id = $_POST['variation_id'];
        $variation = wc_get_product($variation_id);
        if ($variation) {
            $title = $variation->get_name();
            $colorAttribute = $variation->get_attribute('pa_color');
            $sizeAttribute = $variation->get_attribute('pa_size');

            $name = $_POST['name'];
            $phone = $_POST['phone'];
            
            $subject = 'Предзаказ товара';
            $message = 'Товар: ' .$title . ' ('.$colorAttribute.', '.$sizeAttribute.')' . "\r\n" . 'Имя: ' . $name . "\r\n" . 'Телефон: ' . $phone;    
        } else {
            echo false;
        }
    }

    if ($form_type == 'single_one_click'){
        $variation_id = $_POST['single_variation_id'];
        $variation = wc_get_product($variation_id);
        if ($variation) {
            $title = $variation->get_name();
            $colorAttribute = $variation->get_attribute('pa_color');
            $sizeAttribute = $variation->get_attribute('pa_size');

            $name = $_POST['name'];
            $phone = $_POST['phone'];
            
            $subject = 'Заказ товара в 1 клик';
            $message = 'Товар: ' .$title . ' ('.$colorAttribute.', '.$sizeAttribute.')' . "\r\n" . 'Имя: ' . $name . "\r\n" . 'Телефон: ' . $phone;    
        } else {
            echo false;
        }
    }

    if ($form_type == 'cart_one_click'){
        $subject = 'Заказ товаров из корзины в 1 клик';

        $name = $_POST['name'];
        $phone = $_POST['phone'];

        $message = 'Имя: ' . $name . "\r\n" . 'Телефон: ' . $phone . "\r\n" . 'Товары: ' ."\r\n";

        $cart = WC()->cart;
        $variation_data = array();
        $ind = 1;
        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            $product = $cart_item['data'];
    
            if ($product->is_type('variation')) {
                $variation_title = $product->get_title();
                $color_attribute = $product->get_attribute('pa_color');
                $size_attribute = $product->get_attribute('pa_size');
                $quantity = $cart_item['quantity'];
    
                $message .= $ind .'. ' . $variation_title . '(' . $color_attribute . ', ' . $size_attribute . ') x ' . $quantity . "\r\n";
                $ind ++;
            }
            
        }
    }

    if (wp_mail($to, $subject, $message, $headers)) {
        echo true;
    } else {
        echo false;
    }
    
    wp_die();
}
add_action('wp_ajax_onBackorderForm', 'onBackorderForm');
add_action('wp_ajax_nopriv_onBackorderForm', 'onBackorderForm');



function subscriptionForm() {
    $to = 'shop@krikate.by';
    $headers = 'From: wordpress@krikate.by';

    if ($_POST['email']) {
        $email = $_POST['email'];
        $subject = 'Подписка на рассылку';
        $message = 'Email: ' . $email;    
        
    } else {
        echo false;
    }

    if (wp_mail($to, $subject, $message, $headers)) {
        echo true;
    } else {
        echo false;
    }
    
    wp_die();
}
add_action('wp_ajax_subscriptionForm', 'subscriptionForm');
add_action('wp_ajax_nopriv_subscriptionForm', 'subscriptionForm');