<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
	exit;
}

// do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
	echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
	return;
}

?>

<form name="checkout" method="post" class="woocommerce-checkout checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
	<h2 class="checkout__title page-title">Оформление заказа</h2>

	<?php if ($checkout->get_checkout_fields()) : ?>
		<?php do_action('woocommerce_checkout_before_customer_details'); ?>

		<?php do_action('woocommerce_checkout_billing'); ?>

		<div id="order_review" class="woocommerce-checkout-review-order checkout__section">
			<h3 class="checkout__subtitle">Способ доставки</h3>
			<?php do_action('woocommerce_checkout_order_review'); ?>
		</div>

		<?php do_action('woocommerce_checkout_after_customer_details'); ?>

	<?php endif; ?>

	<?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

	<?php do_action('woocommerce_checkout_shipping'); ?>

	<?php do_action('woocommerce_checkout_before_order_review'); ?>



	<div class="checkout__section">
		<div class="basket-total">
			<div class="basket-total__item">
				Сумма заказа
				<span class="basket-total__item_full-price"> 0 BYN</span>
			</div>
			
			<!-- <div class="basket-total__item">
				Скидка
				<span class="basket-total__item_sale-price">— 0 BYN</span>
			</div> -->

			<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

			<div class="basket-total__item">
				Стоимость доставки
				<span class="basket-total__item_delivery-price">0 BYN</span>
			</div>
			<div class="basket-total__item">
				Итого к оплате
				<span class="basket-total__result"><? wc_cart_totals_order_total_html(); ?></span>
			</div>
		</div>
	</div>


	<?php do_action('woocommerce_checkout_after_order_review'); ?>

	<div class="checkout__section checkout__promocode">
		<?
		$applied_coupons = WC()->cart->get_applied_coupons();
		if (count($applied_coupons) == 0) :
		?>
			<!-- <div class="checkout__promocode-activate">У меня есть промокод</div> -->
			<div class="checkout__promocode-box">
				<input type="text" class="checkout__promocode-input" placeholder="У меня есть промокод">
				<div class="checkout__promocode-apply btn-reset secondary-button">Применить</div>
			</div>
		<? else : ?>
			<div class="">Применённый промокод:</div>
			<div class="checkout__promocode-active btn-reset">
				<svg width="10" height="10" viewBox="0 0 10 10">
					<use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#remove"></use>
				</svg>
				<span class="checkout__promocode-name"><?= $applied_coupons[0] ?></span>
			</div>
		<? endif; ?>
		<div class="checkout__promocode-massage"></div>
	</div>


	<div class="checkout__section submit-nt">
		<div class="checkout__policy"> <input type="checkbox" name="accept-policy" checked> <label for="accept-policy"> Размещая заказ, вы принимаете наши <a href="<?= get_field('policy', 'option'); ?>">Политику
                            конфиденциальности</a> и <a href="/publichnaya-oferta/">Договор публичной оферты.</a></label></div>

		<div class="form-row place-order">
			<noscript>
				<?php
				/* translators: $1 and $2 opening and closing emphasis tags respectively */
				printf(esc_html__('Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce'), '<em>', '</em>');
				?>
				<br /><button type="submit" class="checkout__btn primary-button btn-reset<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e('Update totals', 'woocommerce'); ?>"><?php esc_html_e('Update totals', 'woocommerce'); ?></button>
			</noscript>

			<?php //wc_get_template('checkout/terms.php'); 
			$order_button_text = 'Оформить заказ';
			?>

			<?php do_action('woocommerce_review_order_before_submit'); ?>

			<?php echo apply_filters('woocommerce_order_button_html', '<button type="submit" class="checkout__btn primary-button btn-reset' . esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '') . '" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '">' . esc_html($order_button_text) . '</button>'); // @codingStandardsIgnoreLine 
			?>

			<?php do_action('woocommerce_review_order_after_submit'); ?>

			<?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
		</div>
	</div>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>