<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;


if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<section class="product section-offset">
        <div class="product__container container">
            <div class="product__wrapper">
				
				<?php
				/**
				 * Hook: woocommerce_before_single_product_summary.
				 *
				 * @hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				//do_action( 'woocommerce_before_single_product_summary' );
				?>

				<?php 
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->id ), 'single-post-thumbnail' );
				$attachment_ids = $product->get_gallery_image_ids();

				
				// echo '<pre>';
				// print_r($attachment_ids);
				// echo '</pre>';
				?>

				<div class="product__gallery">
					<div class="gallery-slider swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
						<div class="gallery-slider__wrapper gallery-slider__wrapper--gitf-card swiper-wrapper" style="    justify-content: center;">
							<?php foreach($attachment_ids as $attachment_id) { ?>

								<div class="gallery-slider__item swiper-slide">
									<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->id ), 'single-post-thumbnail' );?>                                    
									<a href="<?= wp_get_attachment_image_url($attachment_id, 'Full'); ?>" class="glightbox nofancybox">
										<img width="1280" height="1920" src="<?= wp_get_attachment_image_url($attachment_id, 'Full'); ?>">
									</a>
								</div>
								
							<?php } ?>
						</div>
						<div class="swiper-pagination"></div>
					</div>
                </div>

                <div class="product__tile">
					<div class="gallery-tile-wrapper">
						<div class="gallery-tile">
							<?php foreach($attachment_ids as $attachment_id) { ?>
								<div class="gallery-tile__img-wrapper">
									<?php 
									echo $attachment_id;
									?>
									<img width="1280" height="1920" src="<?= wp_get_attachment_image_url($attachment_id, 'Full'); ?>">
								</div>
							<?php } ?>
						</div>
					</div>
                </div>

				<div class="product__content">
                    <div class="product__breadcrumbs breadcrumbs">
                        <ul class="breadcrumbs__list list-reset">
                            <?php yoast_breadcrumb(); ?>
                        </ul>
                    </div>
                    
                    <div class="product-crosslinks-wrapper">
                        <span class="product-crosslinks__title">Тип карты:</span>
                        <div class="product-crosslinks">
							<?php
							// if($product->slug == 'podarochnaja-karta' || $product->slug == 'fizicheskij-sertifikat' ) {
							if($product->slug == 'podarochnaja-karta' ) {
							?>
								<a href="/shop/sertifikat/fizicheskij-sertifikat/" class="product-crosslink">Физическая</a>
								<span class="product-crosslink">Электронная</span>
							<?php } ?>
							<?php
							if( $product->slug == 'fizicheskij-sertifikat' ) {
							?>
								<span class="product-crosslink">Физическая</span>
								<a href="/shop/sertifikat/podarochnaja-karta/" class="product-crosslink">Электронная</a>
							<?php } ?>
                        </div>
                    </div>

					<div class="" style="font-family: 'Arsenal', sans-serif;"><!-- summary entry-summary -->
						<?php
						
						/**
						 * Hook: woocommerce_before_single_product.
						 *
						 * @hooked woocommerce_output_all_notices - 10
						 */
						do_action( 'woocommerce_before_single_product' );
						/**
						 * Hook: woocommerce_single_product_summary.
						 *
						 * @hooked woocommerce_template_single_title - 5
						 * @hooked woocommerce_template_single_rating - 10
						 * @hooked woocommerce_template_single_price - 10
						 * @hooked woocommerce_template_single_excerpt - 20
						 * @hooked woocommerce_template_single_add_to_cart - 30
						 * @hooked woocommerce_template_single_meta - 40
						 * @hooked woocommerce_template_single_sharing - 50
						 * @hooked WC_Structured_Data::generate_product_data() - 60
						 */
						do_action( 'woocommerce_single_product_summary' );
						?>
					</div>

					<?php //include('single-product/add-to-cart/pw-gift-card-before-add-to-cart-quantity.php'); ?>

					<?php
					/**
					 * Hook: woocommerce_after_single_product_summary.
					 *
					 * @hooked woocommerce_output_product_data_tabs - 10
					 * @hooked woocommerce_upsell_display - 15
					 * @hooked woocommerce_output_related_products - 20
					 */
					//do_action( 'woocommerce_after_single_product_summary' );
					
					?>
        
					<?php if ( !empty( get_the_content() ) ){ ?>
						<div class="product__accordion accordion" style="margin-top: 10px;">
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
					<?php } ?>   
					
				</div>

			</div>
		</div>
	</div>

</div>

<?php //do_action( 'woocommerce_after_single_product' ); ?>
