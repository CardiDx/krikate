<?
$product_title = get_the_title();
$product_sku = $product->get_sku();
?>

<main>
    <section class="product section-offset">
        <?php include('content-gift-card-product.php'); ?>     
        <?php //wc_get_template_part( 'content', 'single-product' ); ?>
        <?php //include('single-product/add-to-cart/pw-gift-card-before-add-to-cart-quantity.php'); ?>
        <?php //do_action( 'pw-gift-card-before-add-to-cart-quantity' ); ?>
    </section>

    <?php // Это было что-то вроде "похожих товаров". В данном товаре не нужны, но если будет несколько видов карт, то может пригодиться ?>
    <?php /* ?>
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
                        wc_get_template_part('content', 'product');
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
                        wc_get_template_part('content', 'product');
                    }
                    echo '</ul>';
                }
                wp_reset_postdata();
            }

            ?>

        </div>
    </section>
    <?php */ ?>

    <? get_template_part('elements/element-instagram'); ?>

    <?
    $recently_viewed = isset($_COOKIE['recently_viewed']) ? json_decode(stripslashes($_COOKIE['recently_viewed']), true) : array();

    if (!empty($recently_viewed)) {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 4,
            'post__in' => $recently_viewed,
            'orderby' => 'post__in',
        );

        $recently_viewed_query = new WP_Query($args);

        if ($recently_viewed_query->have_posts()) {
            echo '<section class="collection section-offset">
            <div class="collection__container container">
                <h2 class="collection__title">Вы просматривали</h2>';
            echo '<ul class="collection__list list-reset">';

            while ($recently_viewed_query->have_posts()) {
                $recently_viewed_query->the_post();
                wc_get_template_part('content', 'product');
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