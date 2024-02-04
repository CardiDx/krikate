<?
$product_title = get_the_title();
$product_sku = $product->get_sku();

$variations = $product->get_available_variations();



$uhod = get_field('uhod');

$nt_color = array();
$nt_size = array();
$nt_image = array();
$nt_price = array();
$nt_id = array();
// Выводим вариации в выпадающем списке
foreach ($variations as $variation) {
    $color = $variation['attributes']['attribute_pa_color'];
    $size = $variation['attributes']['attribute_pa_size'];

    // echo 'is_in_stock';
    // echo($variation['is_in_stock']);
    // echo 'backorders_allowed';
    // echo($variation['backorders_allowed']);
    // echo 'max_qty';
    // echo($variation['max_qty']);
    // echo 'availability_html = ';
    // echo($variation['availability_html']);
    // echo '<pre>';
    // echo strip_tags($variation['availability_html']);
    // echo 'backorders_allowed';
    // print_r($variation['backorders_allowed']);
    // print_r($variation);
    // echo '</pre>';

    if( !$variation['is_in_stock'] && !$variation['backorders_allowed'] ) {
        continue;
    }


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


$variation_key = null;
if( isset($nt_color[0]) ){
    $variation_key = $nt_color[0];
}
$variation_size = null;
if( isset($nt_size[$variation_key][0]) ){
    $variation_size = $nt_size[$variation_key][0];
}



?>

<main>
    <section class="product section-offset">
        <div class="product__container container">
            <div class="product__wrapper">

                <div class="product__gallery">
                    <?php if($variation_key) { ?>
                        <?= view_product_image($nt_image, $variation_key); ?>
                    <?php 
                    } 
                    else {
                        echo '<h1 class="product__title">Извините, именно этот товар мы весь распродали</h1>';
                    }
                    ?>
                </div>



                <div class="product__content">
                    <div class="product__breadcrumbs breadcrumbs">
                        <ul class="breadcrumbs__list list-reset">
                            <?php yoast_breadcrumb(); ?>
                        </ul>
                    </div>
                    <h1 class="product__title"><?= $product_title ?></h1>
                    <div class="product__code">
                        Артикул
                        <span><?= $product_sku ?></span>
                    </div>
                    <? if (isset($nt_color[0]) && !empty($nt_color[0]) && isset($nt_size[$nt_color[0]][0]) && !empty($nt_size[$nt_color[0]][0])) : ?>
                        <?
                        foreach ($nt_size as $color => $size_arr) {
                            foreach ($size_arr as $size) {
                                if ($variation_key == $color && $variation_size == $size) {
                                    echo '<div class="product__price selected-variation" data-variation="' . $nt_id[$color][$size] . '">';
                                } else {
                                    echo '<div class="product__price" data-variation="' . $nt_id[$color][$size] . '">';
                                }
                                echo view_product_price($nt_price, $color, $size);
                                echo '</div>';
                            }
                        }
                        ?>
                        <div class="product__color">
                            <?= view_product_colors($nt_image, $variation_key); ?>
                        </div>
                        <div class="product__size">
                            <div class="product__size-label">
                                Размер
                                <button class="product__size-table btn-reset">Таблица размеров</button>
                            </div>

                            <?
                            foreach ($nt_size as $color => $size_arr) {
                                if ($variation_key == $color) {
                                    echo '<div class="product__size-list selected-variation-color" data-product-color="' . $color . '">';
                                } else {
                                    echo '<div class="product__size-list" data-product-color="' . $color . '">';
                                }

                                foreach ($size_arr as $size) {
                                    echo '<button class="size-btn btn-reset" data-variation="' . $nt_id[$color][$size] . '" data-variation-stock="'.$nt_stock[$color][$size].'">' . $size . '</button>';
                                }
                                echo '</div>';
                            }
                            ?>

                        </div>
                        <div class="add-to-cart">
                            <input type="hidden" class="variation-id" value="<?= $nt_id[$variation_key][$variation_size]; ?>">
                            <input type="hidden" id="product-id" value="<?= get_the_ID(); ?>">
                            <button class="product__btn product__add-to-cart primary-button btn-reset">В корзину</button>
<!--                             <button id="openOneClickProductPopup" class="product__btn product__buy secondary-button btn-reset">Купить в 1 клик</button> -->
                        </div>
                        <div class="product_onbackorder_block hidden">
                            <p style="margin-bottom: 10px;">Товар доступен только для предзаказа</p>
                            <button id="openOnBackorderPopup" class="popup__btn primary-button btn-reset product_onbackorder">Оформить предзаказ</button>
                        </div>
                    <? endif; ?>
                    <div class="product__accordion accordion">
                        <div class="accordion__header accordion__header--active">
                            <div class="accordion__title">Уход</div>
                            <svg width="13" height="12" viewBox="0 0 13 12">
                                <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#show"></use>
                            </svg>
                        </div>
                        <div class="accordion__body accordion__body--active">
                            <div class="accordion__text">
                                <ul class="list-reset">
                                    <? if (isset($uhod) && !empty($uhod)){
                                        view_care($uhod);
                                    }
                                    ?>
                                </ul>
                                <p>Читайте подробнее на странице <a href="/uhod/">Уход</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="product__accordion accordion">
                        <div class="accordion__header accordion__header--active">
                            <div class="accordion__title">Состав</div>
                            <svg width="13" height="12" viewBox="0 0 13 12">
                                <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#show"></use>
                            </svg>
                        </div>
                        <div class="accordion__body accordion__body--active">
                            <div class="accordion__text">
                                <? the_excerpt(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="product__accordion accordion">
                        <div class="accordion__header accordion__header--active">
                            <div class="accordion__title">Описание</div>
                            <svg width="13" height="12" viewBox="0 0 13 12">
                                <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#show"></use>
                            </svg>
                        </div>
                        <div class="accordion__body accordion__body--active">
                            <div class="accordion__text">
                                <? the_content(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="collection section-offset">
        <div class="collection__container container">
            <h2 class="collection__title">Дополните образ</h2>
            <?
            $cross_sells = get_post_meta(get_the_ID(), '_crosssell_ids', true);

            if (empty($cross_sells)) {
                // $product_categories = wp_get_post_terms(get_the_ID(), 'product_cat', array('fields' => 'ids'));
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 4,
                    'orderby' => 'rand',
                    'post__not_in' => array(get_the_ID()),
                    // 'tax_query' => array(
                    //     array(
                    //         'taxonomy' => 'product_cat',
                    //         'field' => 'id',
                    //         'terms' => $product_categories,
                    //         'operator' => 'IN'
                    //     )
                    // )
                );
                $cross_sells_query = new WP_Query($args);
                if ($cross_sells_query->have_posts()) {
                    echo '<ul class="collection__list list-reset">';

                    while ($cross_sells_query->have_posts()) {
                        $cross_sells_query->the_post();
                        // wc_get_template_part('content', 'product');
                        
                        $product_id = get_the_ID();
                        $product = wc_get_product($product_id);
                        $usedColors = array();
    
                        foreach ( $product->get_available_variations() as $key => $variation ) {
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
                        }
                    }


                    echo '</ul>';
                }
                wp_reset_postdata();
            } else {
                // echo '<ul class="collection__list list-reset">';
                // foreach ($cross_sells as $cross_sell_id) {
                //     $cross_sell_product = wc_get_product($cross_sell_id);
                //     wc_get_template_part('content', 'product');
                // }
                // echo '</ul>';

                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 4,
                    'orderby' => 'rand',
                    'post__in' => $cross_sells,
                );
                $cross_sells_query = new WP_Query($args);
                if ($cross_sells_query->have_posts()) {
                    echo '<ul class="collection__list list-reset">';

                    while ($cross_sells_query->have_posts()) {
                        $cross_sells_query->the_post();
                        // wc_get_template_part('content', 'product');
                        
                        $product_id = get_the_ID();
                        $product = wc_get_product($product_id);
                        $usedColors = array();
    
                        foreach ( $product->get_available_variations() as $key => $variation ) {
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
                        }
                    }
                    echo '</ul>';
                }
                wp_reset_postdata();
            }

            ?>

        </div>
    </section>

    <? get_template_part('elements/element-instagram'); ?>

    <?
    $recently_viewed = isset($_COOKIE['recently_viewed']) ? json_decode(stripslashes($_COOKIE['recently_viewed']), true) : array();

    if (!empty($recently_viewed)) {
        $args = array(
            'post_type' => 'product',
            // 'posts_per_page' => 4,
            'post__in' => $recently_viewed,
            'orderby' => 'post__in',
        );

        $recently_viewed_query = new WP_Query($args);

        if ($recently_viewed_query->have_posts()) {
            echo '<section class="collection section-offset">
            <div class="collection__container container">
                <h2 class="collection__title">Вы просматривали</h2>';
            echo '<ul class="collection__list list-reset">';

            $counter = 0;
            while ($recently_viewed_query->have_posts()) {
                $recently_viewed_query->the_post();
                // wc_get_template_part('content', 'product');
                
                $product_id = get_the_ID();
                $product = wc_get_product($product_id);
                $variations = $product->get_available_variations();
                $productHasAvailableColor = false;
                // storage for printed colors
                $usedColors = array();
                foreach ( $variations as $key => $variation ) {
                    $variationColor = $variation['attributes']['attribute_pa_color'];
                    
                    if (in_array($variationColor, $usedColors)) {
                        // we already printed variation with this color
                        continue;
                    } else {
                        // we need to print wariation with this color
                        // echo '<pre>';
                        // print_r($variation['is_in_stock']);
                        // echo '</pre>';
                        if( $variation['is_in_stock'] || $variation['max_qty'] || $variation['backorders_allowed'] ) {
                            $productHasAvailableColor = true;
                            break;
                        }
                        array_push($usedColors, $variationColor);
                    }
                }
                if( $productHasAvailableColor && $counter < 4 ) {
                    woocommerce_get_template( 'content-product.php' );
                    $counter++;
                }
            }

            echo '</ul></div></section>';
            wp_reset_postdata();
        }
    }
    ?>


    <? get_template_part('elements/element-subscription'); ?>


</main>



<div class="popup popup--small popup--down" id="oneClickPopup">
    <div class="popup__container">
        <button class="popup__close btn-reset">
            <svg width="14" height="14" viewBox="0 0 14 14">
                <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#close"></use>
            </svg>
        </button>
        <div class="popup__title">Купить в 1 клик</div>
        <div class="popup__body">
            <form class="popup__form popup-form">
                <div class="popup-form__product cart-item">
                    <div class="cart-item__wrapper">
                        <div class="cart-item__picture">
                            <div class="cart-item__count">1</div>
                            <img src="img/cart_preview.jpg" alt="">
                        </div>
                        <div class="cart-item__body">
                            <div class="cart-item__title"><?= $product_title ?></div>
                            <div class="cart-item__info">
                                Размер
                                <span class="cart-item__size">Onesize</span>
                            </div>
                            <div class="cart-item__info">
                                Цвет
                                <span class="cart-item__color">Фуксия на молочном-розовом цвете</span>
                            </div>
                            <div class="cart-item__wrap">
                                <div class="cart-item__price">360 BYN</div>
                                <div class="cart-item__discount">-25%</div>
                                <div class="cart-item__old">480 BYN</div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="single_variation_id">
				<input type="hidden" name="form-type" value="single_one_click">
                <div class="popup-form__inp input-base">
                    <input id="name" name="name" type="text" placeholder="Имя *" class="inp-reset input-base__inp">
                    <span class="input-base__valid"></span>
                </div>
                <div class="popup-form__inp input-base">
                    <input id="phone" name="phone" type="tel" placeholder="Телефон *" class="inp-reset input-base__inp">
                    <span class="input-base__valid"></span>
                </div>
                <div class="popup-form__policy"> <input type="checkbox" name="accept-policy" checked> <label for="accept-policy">Отправляя данные, вы принимаете наши <a href="<?= get_field('policy', 'option'); ?>">Политику
                            конфиденциальности</a> и <a href="<?= get_field('oferta', 'option'); ?>">Договор оферты.</a></label></div>
                <button disabled type="submit" class="popup-form__btn btn-reset primary-button">Отправить</button>
            </form>
            <div class="error cart-item__wrap" style="display: none;">Произошла ошибка, обратитесь к администрации сайта</div>
        </div>
    </div>
</div>
<div class="popup" id="sizesTablePopup">
    <div class="popup__container">
        <button class="popup__close btn-reset">
            <svg width="14" height="14" viewBox="0 0 14 14">
                <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#close"></use>
            </svg>
        </button>
        <div class="popup__head">
            <div class="popup__title">Таблица размеров</div>
            <div class="popup__note">Все измерения указаны в см</div>
        </div>
        <div class="popup__body">
            <!-- <table class="sizes-table" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <td></td>
                        <td>Рост</td>
                        <td>S</td>
                        <td>M</td>
                        <td>L</td>
                        <td>Доп. отклон.</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Длина по боковому шву с учетом резинки</td>
                        <td>
                            <span>160-175</span>
                            <span>170-175</span>
                        </td>
                        <td>
                            <span>103</span>
                            <span>110</span>
                        </td>
                        <td>
                            <span>103</span>
                            <span>110</span>
                        </td>
                        <td>
                            <span>103</span>
                            <span>110</span>
                        </td>
                        <td>
                            <span>1</span>
                            <span>1</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Длина рукава</td>
                        <td>
                            <span>160-175</span>
                            <span>170-175</span>
                        </td>
                        <td>
                            <span>76</span>
                            <span>80</span>
                        </td>
                        <td>
                            <span>76</span>
                            <span>80</span>
                        </td>
                        <td>
                            <span>76</span>
                            <span>80</span>
                        </td>
                        <td>
                            <span>1</span>
                            <span>1</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Ширина по линии бедер (на 20 см от верха изделия)</td>
                        <td>
                            <span>160-175</span>
                            <span>170-175</span>
                        </td>
                        <td>
                            <span>61</span>
                            <span>63</span>
                        </td>
                        <td>
                            <span>61</span>
                            <span>63</span>
                        </td>
                        <td>
                            <span>61</span>
                            <span>63</span>
                        </td>
                        <td>
                            <span>1</span>
                            <span>1</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Полуобхват талии</td>
                        <td>
                            <span>160-175</span>
                            <span>170-175</span>
                        </td>
                        <td>
                            <span>33</span>
                            <span>35</span>
                        </td>
                        <td>
                            <span>33</span>
                            <span>35</span>
                        </td>
                        <td>
                            <span>33</span>
                            <span>35</span>
                        </td>
                        <td>
                            <span>1</span>
                            <span>1</span>
                        </td>
                    </tr>
                </tbody>
            </table> -->
            <table cellpadding="0" cellspacing="0" class="sizes-table">
	<thead>
		<tr>
			<td>Размер производителя</td>
			<td>RU</td>
			<td>Обхват груди</td>
			<td>Обхват талии</td>
			<td>Обхват бедер</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>ONE SIZE</td>
			<td>42-48</td>
			<td>82-98</td>
			<td>62-78</td>
			<td>90-106</td>
		</tr>
		<tr>
			<td>XS/S</td>
			<td>40-42</td>
			<td>78-86</td>
			<td>58-66</td>
			<td>86-94</td>
		</tr>
		<tr>
			<td>S/M</td>
			<td>42-44</td>
			<td>82-90</td>
			<td>62-70</td>
			<td>90-98</td>
		</tr>
		<tr>
			<td>M/L</td>
			<td>44-46</td>
			<td>86-94</td>
			<td>66-74</td>
			<td>94-102</td>
		</tr>
		<tr>
			<td>L/XL</td>
			<td>46-48</td>
			<td>90-98</td>
			<td>70-78</td>
			<td>98-106</td>
		</tr>
		<tr>
			<td>XS</td>
			<td>40</td>
			<td>78-82</td>
			<td>58-62</td>
			<td>86-90</td>
		</tr>
		<tr>
			<td>S</td>
			<td>42</td>
			<td>82-86</td>
			<td>62-66</td>
			<td>90-94</td>
		</tr>
		<tr>
			<td>M</td>
			<td>44</td>
			<td>86-90</td>
			<td>66-70</td>
			<td>94-98</td>
		</tr>
		<tr>
			<td>L</td>
			<td>46</td>
			<td>90-94</td>
			<td>70-74</td>
			<td>98-102</td>
		</tr>
		<tr>
			<td>XL</td>
			<td>48</td>
			<td>94-98</td>
			<td>74-78</td>
			<td>102-106</td>
		</tr>
	</tbody>
</table>

        </div>
    </div>
</div>


<script defer src="<?= esc_url(get_template_directory_uri()) ?>/assets/js/product.js"></script>