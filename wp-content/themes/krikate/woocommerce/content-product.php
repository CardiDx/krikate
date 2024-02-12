<?php

/**
 * The template for displaying product content in the loop.
 *
 * @package WooCommerce
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

defined('ABSPATH') || exit;

global $product;

$product = wc_get_product(get_the_ID());
$variationID = null;
if ( isset($args['variationID']) && !empty($args['variationID']) ) {
    $variationID = $args['variationID'];
}

?>


<?
$product_title = get_the_title();
if ($product->is_type('variable')) {
    $product_info = product_info(get_the_ID());
    $variations = $product->get_available_variations();

    $product_image = $product_info['nt_image'];
    $product_color = $product_info['nt_color'];
    $product_price = $product_info['nt_price'];

    $variation_color = null;
    // если в контент передана конкретная вариация и надо выводить именно ее
    if(isset($variationID) && !empty($variationID)) {
        $variation = wc_get_product($variationID);
        $variation_color = $variation->attributes['pa_color'];
        // echo $variation_color;

        // $product_image = $product_image[$variation_color];

        // remove excessive colors from images array
        foreach($product_image as $product_image_color => $product_image_ids) {
            if($product_image_color == $variation_color) {
                continue;
            }
            else {
                unset($product_image[$product_image_color]);
            }
        }

        // echo '<pre>';
        // print_r($variation);
        // print_r($variation);
        // print_r($variation_attributes['pa_color']);
        // print_r($colorName);
        // echo '</pre>';

        // echo '<pre>';
        // echo '$product_image = ';
        // print_r($product_image);
        // echo '</pre>';
    }

    // если в контент не была передана конкретная вариация и нам надо почистить пустые вариации
    if(!$variationID) {
        $usedColors = array();
        foreach( $variations as $key => $variation ){
            $variationColor = $variation['attributes']['attribute_pa_color'];
            // echo '<pre>';
            // print_r($variation);
            // print_r($variation['attributes']['attribute_pa_color']);
            // echo '</pre>';   
            // echo $key;
            // echo ' ?? ';
            // echo('is_in_stock = ' . $variation['is_in_stock']);
            // echo ' ?? ';
            // echo('max_qty = ' . $variation['max_qty']);
            // echo ' ?? ';
            // echo('backorders_allowed = ' . $variation['backorders_allowed']);
            // echo ' ?? ';
            if( $variation['is_in_stock'] || $variation['max_qty'] || $variation['backorders_allowed'] ) {
                // записываем цвет как используемый
                if (!in_array($variationColor, $usedColors)) {
                    array_push($usedColors, $variationColor);
                }
                continue;
            }
            else {
                // удаляем пустые вариации
                unset($variations[$key]);
            }
        }

        // echo '<pre>';
        // echo '$usedColors = ';
        // print_r($usedColors);
        // echo '$product_image = ';
        // print_r($product_image);
        // echo '$product_color = ';
        // print_r($product_color);
        // echo '</pre>';


        // убираем пикчи цветов, которых нет в наличии
        foreach( $product_image as $key => $product_image_color ){
            if( !in_array($key, $usedColors) ){ 
                unset($product_image[$key]);               
            }
        }

        // заменяем используемые цвета на вычисленные выше
        $product_color = $usedColors;

        // echo '  ????  ';

        // echo '<pre>';
        // echo '$usedColors = ';
        // print_r($usedColors);
        // echo '$product_image = ';
        // print_r($product_image);
        // echo '$product_color = ';
        // print_r($product_color);
        // echo '</pre>';
    }


    // получаем цвет
    $taxonomy = 'pa_color';
    $meta = get_post_meta($variationID, 'attribute_'.$taxonomy, true);
    $colorName = get_term_by('slug', $meta, $taxonomy);
    if(isset($colorName->name) && !empty($colorName->name)) {
        $colorName = $colorName->name;
    }

?>

    <li class="catalog__list-item product-card" data-product-id="<?= get_the_ID() ?>">
        <div class="product-card__picture">
            <?
            $marker = get_field('marker');
            if ($product->is_on_sale() || $marker !== NULL) {
                echo '<div class="product-card__sale">';
                if ($product->is_on_sale()) {
                    echo '<div class="product-card__sale-item">SALE</div>';
                }
                if ($marker !== NULL) {
                    foreach ($marker as $el) {
                        echo '<div class="product-card__sale-item">' . $el . '</div>';
                    }
                }
                echo '</div>';
            }

            // if(isset($variationID) && !empty($variationID)) {
            //     // if we have to print only 1 picture by variation id
            //     $variation = wc_get_product($variationID);

            //     // $product_info = product_info($variationID);            
            //     // $product_image = $product_info['nt_image'];
            //     echo '<pre>';
            //     print_r($product_image);
            //     echo '</pre>';
            //     // echo '<a href="' . esc_url(get_permalink()) . '" class="">';
            //     // echo wp_get_attachment_image($variation->image_id, 'full');
            //     // echo '</a>';
            // }
            
            $variations_index = 0;
            if (count($product_image) !== 0) {
                foreach ($product_image as $color => $images) {
                    if ($variations_index == 0) {
                        echo '<a href="' . esc_url(get_permalink()) . '" class="product-card__picture-group product-card__picture-group--selected" data-color="' . $color . '">';
                    } else {
                        echo '<a href="' . esc_url(get_permalink()) . '" class="product-card__picture-group" data-color="' . $color . '">';
                    }
                    $image_index = 0;
                    if (isset($images[0]) && !empty($images[0])) {
                        echo wp_get_attachment_image($images[0], 'full');
                        if (isset($images[1]) && !empty($images[1])) {
                            echo wp_get_attachment_image($images[1], 'full');
                        } else {
                            echo wp_get_attachment_image($images[0], 'full');
                        }
                    } else {
                    }

                    // foreach ($images as $image_id) {
                    //     if ($image_index < 2) {
                    //         echo wp_get_attachment_image($image_id, 'full');
                    //     }
                    //     $image_index++;
                    // }
                    echo '</a>';
                    $variations_index++;
                }
            } else {
                $placeholder_img = wc_placeholder_img_src();
                $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail');
                echo '<a href="' . esc_url(get_permalink()) . '" class="product-card__picture-group product-card__picture-group--selected">';
                if ($product_image) {
                    echo '<img src="' . esc_url($product_image[0]) . '" alt="' . esc_attr(get_the_title()) . '" />';
                    echo '<img src="' . esc_url($product_image[0]) . '" alt="' . esc_attr(get_the_title()) . '" />';
                } else {
                    echo '<img src="' . esc_url($placeholder_img) . '" alt="' . esc_attr(get_the_title()) . '" />';
                    echo '<img src="' . esc_url($placeholder_img) . '" alt="' . esc_attr(get_the_title()) . '" />';
                }
                echo '</a>';
            }
            ?>
            <? if (count($product_price) !== 0) : ?>
                <button class="product-card__add btn-reset" data-product-id="<?= get_the_ID() ?>">
                    <svg width="14" height="19" viewBox="0 0 14 19">
                        <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#cart"></use>
                    </svg>
                </button>
            <? endif; ?>
        </div>

        <?php //if(!isset($variationID) || empty($variationID)) { ?>
        <?php if($variation_color) { ?>
        <div class="product-card__colors" style="display: none;">
            <?
            foreach ($product_color as $color) {
                $term = get_term_by('slug', $color, 'pa_color');
                echo $variation_color;
                echo $color;
                if ($term && !is_wp_error($term)) {
                    $color_code = get_term_meta($term->term_id, 'color_code', true);
                    $color_name = $term->name;
                    if (empty($color_code)) {
                        $color_code = '#1D1D1B';
                    }
                }
                if ($variation_color == $color) {
                    echo '<button id="' . $color . '" style="color: ' . $color_code . ';" class="product-card__colors-item product-card__colors-item--selected btn-reset" data-color-name="' . $color_name . '"></button>';
                } 
            }
            if($product->slug == 'podarochnaja-karta'){
                echo '<button id="belyj" style="color: #ffffff;" class="product-card__colors-item product-card__colors-item--selected btn-reset" data-color-name="Белый"></button>';
            }
            ?>

        </div>
        <?php }
        else { ?>
        <div class="product-card__colors">
            <?
            $color_index = 0;

            foreach ($product_color as $color) {
                $term = get_term_by('slug', $color, 'pa_color');
                if ($term && !is_wp_error($term)) {
                    $color_code = get_term_meta($term->term_id, 'color_code', true);
                    $color_name = $term->name;
                    if (empty($color_code)) {
                        $color_code = '#1D1D1B';
                    }
                }
                if ($color_index == 0) {
                    echo '<button id="' . $color . '" style="color: ' . $color_code . ';" class="product-card__colors-item product-card__colors-item--selected btn-reset" data-color-name="' . $color_name . '"></button>';
                } else {
                    echo '<button id="' . $color . '" style="color: ' . $color_code . ';" class="product-card__colors-item btn-reset" data-color-name="' . $color_name . '"></button>';
                }
                $color_index++;
            }
            if($product->slug == 'podarochnaja-karta'){
                echo '<button id="belyj" style="color: #ffffff;" class="product-card__colors-item product-card__colors-item--selected btn-reset" data-color-name="Белый"></button>';
            }
            ?>

        </div>
        <?php } ?>

        <div class="product-card__desc">
            <a href="<?= esc_url(get_permalink()); ?>" class="product-card__title"><?= $product_title ?><?php if(isset($colorName) && !empty($colorName)){ echo ' - ' . $colorName; } ?></a>
            <div class="product-card__wrap">
                <?
                view_product_price_listing($product_price);
                ?>
            </div>
        </div>
    </li>

<?
}
?>