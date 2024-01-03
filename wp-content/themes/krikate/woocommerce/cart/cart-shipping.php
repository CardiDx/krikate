<?php

/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.3.0
 */

defined('ABSPATH') || exit;

$formatted_destination    = isset($formatted_destination) ? $formatted_destination : WC()->countries->get_formatted_address($package['destination'], ', ');
$has_calculated_shipping  = !empty($has_calculated_shipping);
$show_shipping_calculator = !empty($show_shipping_calculator);
$calculator_text          = '';
?>

<?php if ($available_methods) : ?>
    <div class="checkout__section">
        <div id="shipping_method" class="woocommerce-shipping-methods">
            <?php foreach ($available_methods as $method) : ?>
                <div class="checkout__radio c-radio">
                    <?php
                    if (1 < count($available_methods)) {
                        printf('<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />', $index, esc_attr(sanitize_title($method->id)), esc_attr($method->id), checked($method->id, $chosen_method, false)); // WPCS: XSS ok.
                    } else {
                        printf('<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr(sanitize_title($method->id)), esc_attr($method->id)); // WPCS: XSS ok.
                    }
                    printf('<div class="c-radio__body"><div class="c-radio__box"></div><div class="c-radio__label" for="shipping_method_%1$s_%2$s">%3$s</div></div>', $index, esc_attr(sanitize_title($method->id)), wc_cart_totals_shipping_method_label($method)); // WPCS: XSS ok.
                    do_action('woocommerce_after_shipping_rate', $method, $index);
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php
// elseif (!$has_calculated_shipping || !$formatted_destination) :
//     if (is_cart() && 'no' === get_option('woocommerce_enable_shipping_calc')) {
//         echo wp_kses_post(apply_filters('woocommerce_shipping_not_enabled_on_cart_html', __('Shipping costs are calculated during checkout.', 'woocommerce')));
//     } else {
//         echo wp_kses_post(apply_filters('woocommerce_shipping_may_be_available_html', __('Enter your address to view shipping options.', 'woocommerce')));
//     }
// elseif (!is_cart()) :
//     echo wp_kses_post(apply_filters('woocommerce_no_shipping_available_html', __('There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce')));
// else :
//     echo wp_kses_post(
//         /**
//          * Provides a means of overriding the default 'no shipping available' HTML string.
//          *
//          * @since 3.0.0
//          *
//          * @param string $html                  HTML message.
//          * @param string $formatted_destination The formatted shipping destination.
//          */
//         apply_filters(
//             'woocommerce_cart_no_shipping_available_html',
//             // Translators: $s shipping destination.
//             sprintf(esc_html__('No shipping options were found for %s.', 'woocommerce') . ' ', '<strong>' . esc_html($formatted_destination) . '</strong>'),
//             $formatted_destination
//         )
//     );
//     $calculator_text = esc_html__('Enter a different address', 'woocommerce');
endif;
?>

<?php if ($show_package_details) : ?>
    <?php //echo '<p class="woocommerce-shipping-contents"><small>' . esc_html($package_details) . '</small></p>'; ?>
<?php endif; ?>

<?php if ($show_shipping_calculator) : ?>
    <?php //woocommerce_shipping_calculator($calculator_text); ?>
<?php endif; ?>