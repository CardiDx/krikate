<?php
$template_uri = esc_url(get_template_directory_uri());
?>

<footer class="footer">
	<div class="footer__container container">
		<div class="footer__wrapper">
			<div class="footer__col">
				<a href="/" class="footer__logo">
					<?= wp_get_attachment_image(get_field('logo', 'option')); ?>
				</a>
				<div class="footer__copy">Ⓒ krikate.by — дизайнерский бренд одежды</div>
				<a href="<?= get_field('policy', 'option'); ?>" class="footer__link">Политика конфиденциальности</a>
				<a href="<?= get_field('oferta', 'option'); ?>" class="footer__link">Договор оферты</a>
			</div>
			<nav class="footer__col footer__nav f-menu">
				<div class="f-menu__col">
					<a href="/oplata-i-dostavka/" class="f-menu__link">Доставка и оплата</a>
					<a href="/vozvrat/" class="f-menu__link">Возврат</a>
					<a href="/uhod/" class="f-menu__link">Памятка по уходу</a>
					<a href="/oformlenie-zakaza/" class="f-menu__link">Оформление заказа</a>
					<a href="/bonusnaja-sistema-lojalnosti/" class="f-menu__link">Система лояльности</a>
				</div>
				<div class="f-menu__col">
					<a href="/shop/" class="f-menu__link">Каталог</a>
					<a href="/category/sale/" class="f-menu__link">SALE</a>
					<a href="/shops/" class="f-menu__link">Магазины</a>
					<a href="/check-giftcard-balance/" class="f-menu__link">Баланс сертификата</a>
				</div>
				<div class="f-menu__col">
					<a href="/about/" class="f-menu__link">О бренде</a>
					<a href="/lookbook/" class="f-menu__link">Lookbook</a>
					<a href="/partnership/" class="f-menu__link">Сотрудничество</a>
				</div>
				<div class="f-menu__col f-menu__col--mobile">
					<a href="tel:<?= get_field('phone', 'option'); ?>" class="f-menu__link"><?= get_field('phone', 'option'); ?></a>
					<a href="<?= get_field('instagram', 'option'); ?>" class="f-menu__link" target="_blank">Instagram</a>
					<a href="<?= get_field('telegram', 'option'); ?>" class="f-menu__link" target="_blank">Telegram</a>
					<a href="<?= get_field('viber', 'option'); ?>" class="f-menu__link" target="_blank">Viber</a>
				</div>
			</nav>
			<div class="footer__col">
				<a href="tel:<?= get_field('phone', 'option'); ?>" class="footer__phone"><?= get_field('phone', 'option'); ?></a>
				<ul class="footer__socials list-reset">
					<li class="footer__socials-item">
						<a href="<?= get_field('instagram', 'option'); ?>" target="_blank" class="footer__socials-link">Instagram</a>
					</li>
					<li class="footer__socials-item"><a href="<?= get_field('telegram', 'option'); ?>" target="_blank" class="footer__socials-link">Telegram</a>
					</li>
					<li class="footer__socials-item"><a href="<?= get_field('viber', 'option'); ?>" target="_blank" class="footer__socials-link">Viber</a></li>
				</ul>
				<ul class="footer__payments payments list-reset">
					<li class="payments__item">
						<svg width="48" height="17" viewBox="0 0 48 17">
							<use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#mastercard"></use>
						</svg>
					</li>
					<li class="payments__item">
						<svg width="48" height="17" viewBox="0 0 48 17">
							<use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#visa"></use>
						</svg>
					</li>
					<li class="payments__item">
						<svg width="48" height="17" viewBox="0 0 48 17">
							<use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#belcart"></use>
						</svg>
					</li>
					<li class="payments__item">
						<svg width="48" height="17" viewBox="0 0 48 17">
							<use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#pay"></use>
						</svg>
					</li>
					<li class="payments__item">
						<svg width="48" height="17" viewBox="0 0 48 17">
							<use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#bepaid"></use>
						</svg>
					</li>
					<li class="payments__item">
						<svg width="48" height="17" viewBox="0 0 48 17">
							<use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#securecode"></use>
						</svg>
					</li>
					<li class="payments__item">
						<svg width="48" height="17" viewBox="0 0 48 17">
							<use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#visasecure"></use>
						</svg>
					</li>
					<li class="payments__item">
						<svg width="48" height="17" viewBox="0 0 48 17">
							<use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#belcartpassword"></use>
						</svg>
					</li>
					<li class="payments__item">
						<svg width="48" height="17" viewBox="0 0 48 17">
							<use xlink:href="<? echo $template_uri; ?>/assets/styles/svg-sprite.svg#samsungpay"></use>
						</svg>
					</li>
				</ul>
			</div>
		</div>
	</div>
</footer>

<button class="back-to-top-btn btn-reset">
	<svg width="8" height="20" viewBox="0 0 8 20">
		<use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#top"></use>
	</svg>
</button>

<div class="popup" id="addToCart">
	<div class="popup__container">
		<button class="popup__close btn-reset">
			<svg width="14" height="14" viewBox="0 0 14 14">
				<use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#close"></use>
			</svg>
		</button>
		<div class="add-to-cart-block_before">
			<div class="popup__title">Выберите размер</div>
			<div class="popup__body">
				<div class="popup__content">
					<div class="order-info">
						<div class="order-info__sizes">

						</div>
						<div class="order-info__color">
							Цвет
							<span></span>
						</div>
						<div class="order-info__size">
							Размер
							<span style="color:#D91015;">Выберите размер</span>
						</div>
					</div>
				</div>
				<button class="popup__btn primary-button btn-reset listing_add_cart_btn">В корзину</button>
				<div class="listing_onbackorder_block hidden">
					<p style="margin-bottom: 10px;">Товар доступен только для предзаказа</p>
					<button id="openOnBackorderPopup" class="popup__btn primary-button btn-reset listing_onbackorder">Оформить предзаказ</button>
				</div>
			</div>
		</div>
		<div class="add-to-cart-block_after disabled">
			<div class="popup__title">Товар добавлен в вашу корзину</div>

			<button class="popup__btn primary-button btn-reset popup__close-static">Продолжить покупки</button>
			<a href="/checkout/" class="popup__btn secondary-button btn-reset go-to_checkout">Перейти в корзину</a>
		</div>

	</div>
</div>

<div class="popup popup--small popup--down" id="onBackorderPopup">
    <div class="popup__container">
        <button class="popup__close btn-reset">
            <svg width="14" height="14" viewBox="0 0 14 14">
                <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#close"></use>
            </svg>
        </button>
        <div class="popup__title">Оформить предзаказ</div>
        <div class="popup__body">
            <form id="onBackorderForm" class="popup__form popup-form">
                <div class="popup-form__product cart-item">
                    
                </div>
				<input type="hidden" name="variation_id">
				<input type="hidden" name="form-type" value="pre_order">
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

<div class="popup popup--small" id="thanksPopup">
    <div class="popup__container">
        <button class="popup__close btn-reset">
            <svg width="14" height="14" viewBox="0 0 14 14">
                <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#close"></use>
            </svg>
        </button>
        <div class="popup__title">Спасибо, что оформили предзаказ</div>
        <div class="popup__desc">В течение дня наш менеджер свяжется с вами</div>
        <a href="#" class="popup__btn btn-reset primary-button popup__close-static">Продолжить покупки</a>
    </div>
</div>

<script src="<?= $template_uri ?>/assets/js/inputmask.min.js"></script>
<script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.5/dist/perfect-scrollbar.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/25.2.1/build/js/intlTelInput.min.js" integrity="sha512-IkaM8IicdlJR0eLhPoAHBeDXxQ8QTjVfo7O9hwowr8gTmxZOlV0Z51HFYIDmftcLmdejUlGam6uYVU3k7xP/4A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.0/js/glightbox.min.js" integrity="sha512-RBWI5Qf647bcVhqbEnRoL4KuUT+Liz+oG5jtF+HP05Oa5088M9G0GxG0uoHR9cyq35VbjahcI+Hd1xwY8E1/Kg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.6/perfect-scrollbar.min.js" integrity="sha512-gcLXgodlQJWRXhAyvb5ULNlBAcvjuufaOBRggyLCtCqez+9jW7MxP3Is/9serId1YmNZ0Lx1ewh9z2xBwwZeKg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script defer src="<?= $template_uri ?>/assets/js/index.js"></script>
<script defer src="<?= $template_uri ?>/assets/js/cart.js"></script>
<script defer src="<?= $template_uri ?>/assets/js/filter.js"></script>
<!-- END ALL JS/SCRIPT -->

<?php wp_footer(); ?>
</body>

</html>