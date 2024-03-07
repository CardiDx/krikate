<?php

defined( 'ABSPATH' ) or exit;

global $pw_gift_cards_redeeming;
if ( $pw_gift_cards_redeeming->cart_contains_gift_card() && 'yes' !== get_option( 'pwgc_allow_gift_card_purchasing', 'yes' ) ) {
    return;
}

if ( 'review_order_before_submit' === get_option( 'pwgc_redeem_checkout_location', 'review_order_before_submit' ) ) {
    ?>
    <div id="pwgc-redeem-gift-card-form" class="checkout__section checkout__promocode">
        <!-- <form id="pwgc-redeem-form"> -->
        <div id="pwgc-redeem-form">
            <!-- <label for="pwgc-redeem-gift-card-number"><?php //_e( 'Have a gift card?', 'pw-woocommerce-gift-cards' ); ?></label> -->
            <!-- <div class="basket-total__item" style="margin-bottom: 0;">
                <label for="pwgc-redeem-gift-card-number"><?php //_e( 'Have a gift card?', 'pw-woocommerce-gift-cards' ); ?></label>
            </div> -->
            <div id="pwgc-redeem-error" style="color: red;"></div>
            <div class="checkout__promocode-box">
                <input type="text" id="pwgc-redeem-gift-card-number" class="checkout__promocode-input" name="card_number" autocomplete="off" placeholder="<?php esc_html_e( 'Gift card number', 'pw-woocommerce-gift-cards' ); ?>">
                <input type="submit" onclick="updateCartOnClick()" id="pwgc-redeem-button" class="checkout__promocode-apply btn-reset secondary-button" data-wait-text="<?php esc_html_e( 'Please wait...', 'pw-woocommerce-gift-cards' ); ?>" value="Применить">
            </div>
        <!-- </form> -->
        </div>
    </div>
    <script>
        jQuery(function() {
            jQuery('#pwgc-redeem-form').off('submit.pimwick').on('submit.pimwick', function(e) {
                pwgc_checkout_redeem_gift_card(jQuery('#pwgc-redeem-button'));
                e.preventDefault();
                return false;
            });
        });
    </script>
    <?php
}
