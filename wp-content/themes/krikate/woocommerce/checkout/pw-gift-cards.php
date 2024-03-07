<?php

defined( 'ABSPATH' ) or exit;

?>
<style>
    .pwgc-checkout-subtitle {
        line-height: 1.4;
        font-size: 80%;
        font-weight: 300;
    }
</style>
<?php

$session_data = (array) WC()->session->get( PWGC_SESSION_KEY );
if ( isset( $session_data['gift_cards'] ) ) {

    foreach ( $session_data['gift_cards'] as $card_number => $discount_amount ) {
        $pw_gift_card = new PW_Gift_Card( $card_number );
        if ( $pw_gift_card->get_id() ) {
            $balance = apply_filters( 'pwgc_to_current_currency', $pw_gift_card->get_balance() );
            $balance -= $discount_amount;
            $balance = apply_filters( 'pwgc_remaining_balance_checkout', $balance, $pw_gift_card );
            ?>
            <div class="basket-total__item --mb-5">
                <?php _e( 'Gift card', 'pw-woocommerce-gift-cards' ); ?>
                <span class="basket-total__item_full-price"><?php echo $pw_gift_card->get_number(); ?></span>
            </div>
            <div class="basket-total__item --mb-5">
                Будет списано с карты
                <span class="basket-total__item_full-price"><?php echo wc_price( $discount_amount * -1 ); ?></span>
            </div>
            <div class="basket-total__item --mb-5">
                <?php echo sprintf( __( 'Remaining balance is %s', 'pw-woocommerce-gift-cards' ), wc_price( $balance ) ); ?>
            </div>
            <div class="basket-total__item">
                <div></div>
                <div class="basket-total__item_full-price"><a href="#" onclick="updateCartOnClick()" class="pwgc-remove-card basket-total__item_full-price" data-card-number="<?php esc_attr_e( $card_number ); ?>"><?php _e( '[Remove]', 'pw-woocommerce-gift-cards' ); ?></a></div>
            </div>
            <tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $card_number ) ); ?>">
                <th>
                    <div class="pwgc-checkout-subtitle">
                        
                        <?php
                            if ( $pw_gift_card->has_expired() ) {
                                ?>
                                <br />
                                <span style="color: red; font-weight: 600;">
                                    <?php _e( 'Expired', 'pw-woocommerce-gift-cards' ); ?>
                                </span>
                                <?php
                            }
                        ?>
                    </div>
                </th>
            </tr>
            <?php
        }
    }
}

