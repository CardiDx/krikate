const basket__body = document.querySelector('.basket__body');
const basket__checkout = document.querySelector('.basket__checkout');

function removeFromCart(productId, variationId) {
    jQuery.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'remove_from_cart',
            product_id: productId,
            variation_id: variationId,
        },
        success: function(response) {
            updateCart();
        }
    });
}

function removeFromCartPage(removeItem) {
    removeItem = removeItem.closest('[data-cart-product]');

    var productId = removeItem.getAttribute('data-cart-product');
    var variationId = removeItem.getAttribute('data-cart-variation');

    var itemName = removeItem.querySelector('.cart-product__item-title').textContent;
    var itemQuantity = removeItem.querySelector('.counter__value').textContent;

    jQuery.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'remove_from_cart',
            product_id: productId,
            variation_id: variationId,
        },
        success: function(response) {
            jQuery.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: 'update_cart',
                },
                success: function(response) {
                    document.querySelector('.header__cart-dropdown .cart__wrapper').innerHTML = response.slice(0, -1);
                    document.querySelector('.h-cart__count').innerHTML = document.querySelector('.all-cart-count').textContent;
                    document.querySelector('.cart_preloader').classList.add('disabled');
                    updateCheckout();
                }
            });

            removeItem.innerHTML = '<div class="cart-product__removed">Товар ' + itemName + ' был удален из корзины<button class="cart-product__restore btn-reset">Восстановить</button></div>';
            document.querySelector('.cart-product__restore').addEventListener('click', function() {
                jQuery.ajax({
                    type: 'POST',
                    url: '/wp-admin/admin-ajax.php',
                    data: {
                        action: 'add_to_cart',
                        variation_id: variationId,
                        quantity: itemQuantity,
                    },
                    success: function(response) {
                        updateCart();
                    }
                });
            });
        }
    });


}


function updateCartOnClick() {
    updateCart();
    setTimeout(
        function() 
        {
            location.reload();
        },
    1000);
}


function clearCart() {
    jQuery.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'clear_cart'
        },
        success: function(response) {
            updateCart();
            if (basket__checkout) {
                location.reload();
            }
        }
    });
}

function updateCartItemQuantity(productId, variationId, quantity) {
    // Отправляем AJAX-запрос на сервер для обновления количества товара
    jQuery.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'update_cart_item_quantity',
            product_id: productId,
            variation_id: variationId,
            quantity: quantity
        },
        success: function(response) {
            updateCart();
        }
    });
}

function updateCart() {
    document.querySelector('.cart_preloader').classList.remove('disabled');


    jQuery.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'update_cart',
        },
        success: function(response) {
            document.querySelector('.header__cart-dropdown .cart__wrapper').innerHTML = response.slice(0, -1);
            document.querySelector('.h-cart__count').innerHTML = document.querySelector('.all-cart-count').textContent;
            document.querySelector('.cart_preloader').classList.add('disabled');

            if (basket__body) {
                document.querySelector('.cart_preloader-page').classList.remove('disabled');
                jQuery.ajax({
                    type: 'POST',
                    url: '/wp-admin/admin-ajax.php',
                    data: {
                        action: 'update_cart_page',
                    },
                    success: function(response) {
                        basket__body.innerHTML = response.slice(0, -1);
                        document.querySelector('.cart_preloader').classList.add('disabled');
                        targetCartElements();
                        updateCheckout();
                    }
                });
            } else {
                document.querySelector('.cart_preloader').classList.add('disabled');
                targetCartElements();

            }
        }
    });

}

function updateCheckout() {
    document.querySelector('.checkout_preloader-page').classList.remove('disabled');
    jQuery.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'update_checkout',
        },
        success: function(response) {
            basket__checkout.innerHTML = response.slice(0, -1);
            updateCheckoutPrice();
            document.querySelector('.checkout_preloader-page').classList.add('disabled');
            delivery_metod();
            jQuery('#shipping_country').select2();
            inputValidate();
        }
    });

}
const masksList = {
    au: "+61-9A9-999-999",
    at: "+43-999-999-999",
    az: "+994-99-999-99-99",
    al: "+355-99-999-999",
    by: "+375 (99) 999-99-99",
    dz: "+213-999-99-99-99",
    ao: "+244-999-999-999",
    ar: "+54-9A9-999-9999",
    am: "+374-99-999-999",
    aw: "+297-999-9999",
    bd: "+880-1999-999999",
    bh: "+973-9999-9999",
    be: "+32-499-99-99-99",
    bj: "+229-99-99-99-99",
    bg: "+359-999-999-999",
    bo: "+591-6999-9999",
    ba: "+387-99-999-999",
    bw: "+267-9999-9999",
    br: "+55-99-9999-9999",
    bf: "+226-99-99-99-99",
    bi: "+257-9999-9999",
    va: "+379-9999-999999",
    gb: "+44-7999-999-999",
    hu: "+36-99-999-9999",
    vn: "+84-999-999-999",
    ht: "+509-9999-9999",
    gy: "+592-999-9999",
    gh: "+233-999-999-999",
    de: "+49-9999-9999999",
    hk: "+852-9999-9999",
    gr: "+30-999-999-9999",
    ge: "+995-999-999-999",
    dk: "+45-99-99-99-99",
    do: "+1-999-999-9999",
    eg: "+20-9999-999-999",
    zm: "+260-9999-999-999",
    zw: "+263-999-999-999",
    il: "+972-999-999-999",
    in: "+91-99999-99999",
    jo: "+962-9999-9999",
    id: "+62-999-999-9999",
    ir: "+98-9999-999-999",
    ie: "+353-99-999-9999",
    is: "+354-999-9999",
    es: "+34-999-999-999",
    it: "+39-999-999-9999",
    kz: "+7-999-999-99-99",
    cm: "+237-9999-9999",
    ca: "+1-999-999-9999",
    qa: "+974-9999-9999",
    ke: "+254-999-999-999",
    cy: "+357-9999-9999",
    cn: "+86-999-9999-9999",
    co: "+57-999-999-9999",
    km: "+269-9999-9999",
    cd: "+243-999-999-999",
    kr: "+82-999-9999-9999",
    cr: "+506-9999-9999",
    cu: "+53-5-999-9999",
    kw: "+965-9999-9999",
    kg: "+996-999-999-999",
    cw: "+599-999-9999",
    lv: "+371-9999-9999",
    ls: "+266-9999-9999",
    lr: "+231-9999-9999",
    lb: "+961-9999-9999",
    lt: "+370-999-99999",
    lu: "+352-999-999-999",
    mr: "+222-9999-9999",
    mu: "+230-9999-9999",
    mg: "+261-999-99-99999",
    mk: "+389-999-999-999",
    mw: "+265-9999-9999",
    my: "+60-999-999-9999",
    ml: "+223-9999-9999",
    mv: "+960-999-9999",
    mt: "+356-9999-9999",
    ma: "+212-9999-999-999",
    mx: "+52-999-9999-999",
    mz: "+258-9999-999-999",
    md: "+373-9999-9999",
    mc: "+377-9999-9999",
    np: "+977-9999-999999",
    nl: "+31-6-99999999",
    an: "+599-999-9999",
    nz: "+64-999-999-9999",
    no: "+47-999-99-999",
    ae: "+971-9999-9999",
    om: "+968-9999-9999",
    pk: "+92-9999-9999999",
    pa: "+507-999-9999",
    pe: "+51-999-999-999",
    pl: "+48-999-999-999",
    pt: "+351-999-999-999",
    ru: "+7-999-999-99-99",
    rw: "+250-9999-9999",
    ro: "+40-999-999-999",
    sv: "+503-9999-9999",
    sc: "+248-9999-9999",
    sn: "+221-9999-9999",
    rs: "+381-99-999-9999",
    sg: "+65-9999-9999",
    sk: "+421-999-999-999",
    si: "+386-99-999-999",
    sr: "+597-999-9999",
    sl: "+232-9999-9999",
    us: "+1-999-999-9999",
    tj: "+992-9999-9999",
    th: "+66-999-999-9999",
    tw: "+886-9999-9999",
    tc: "+1-999-999-9999",
    tg: "+228-9999-9999",
    tt: "+1-868-999-9999",
    tn: "+216-9999-9999",
    tm: "+993-9999-9999",
    tr: "+90-999-999-9999",
    uz: "+998-999-999-999",
    uy: "+598-9999-9999",
    ph: "+63-999-999-9999",
    fr: "+33-999-999-999",
    pf: "+689-9999-99-9999",
    hr: "+385-999-999-9999",
    td: "+235-9999-9999",
    me: "+382-99-999-999",
    cz: "+420-999-999-999",
    cl: "+56-999-999-9999",
    ch: "+41-999-999-9999",
    se: "+46-999-999-9999",
    lk: "+94-999-999-999",
    ec: "+593-999-999-9999",
    er: "+291-9999-9999",
    sz: "+268-9999-9999",
    ee: "+372-9999-9999",
    et: "+251-999-999-999",
    za: "+27-999-999-9999",
    jm: "+1-876-999-9999",
    jp: "+81-999-9999-9999",
};

function inputValidate() {
    var telInputCheckout = document.querySelector("#billing_phone");
    let imTel = new Inputmask("+375 (99) 999-99-99");
    if (telInputCheckout) {
        var itl = intlTelInput(telInputCheckout, {
            customContainer: "iti-custom",
            onlyCountries: ["by", "au", "at", "az", "al", "dz", "ao", "ar", "am", "aw", "bd", "bh", "be", "bj", "bg", "bo", "ba", "bw", "br", "bf", "bi", "va", "gb", "hu", "vn", "ht", "gy", "gh", "de", "hk", "gr", "ge", "dk", "do", "eg", "zm", "zw", "il", "in", "jo", "id", "ir", "ie", "is", "es", "it", "kz", "cm", "ca", "qa", "ke", "cy", "cn", "co", "km", "cd", "kr", "cr", "cu", "kw", "kg", "cw", "lv", "ls", "lr", "lb", "lt", "lu", "mr", "mu", "mg", "mk", "mw", "my", "ml", "mv", "mt", "ma", "mx", "mz", "md", "mc", "np", "nl", "an", "nz", "no", "ae", "om", "pk", "pa", "pe", "pl", "pt", "ru", "rw", "ro", "sv", "sc", "sn", "rs", "sg", "sk", "si", "sr", "sl", "us", "tj", "th", "tw", "tc", "tg", "tt", "tn", "tm", "tr", "uz", "uy", "ph", "fr", "pf", "hr", "td", "me", "cz", "cl", "ch", "se", "lk", "ec", "er", "sz", "ee", "et", "za", "jm", "jp"],
            initialCountry: "by",// "auto",
            geoIpLookup: callback => {
                fetch("https://ipapi.co/json")
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("us"));
            },
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
        });
        imTel.mask(telInputCheckout);
        telInputCheckout.addEventListener("countrychange", () => {
            let country = itl.getSelectedCountryData();
            Inputmask(masksList[country.iso2]).mask(telInputCheckout);
        });
        telInputCheckout.addEventListener("open:countrydropdown", (e) => {
            const telInputRect = e.target.getBoundingClientRect();
            const mobileContainer = document.querySelector(".iti.iti--container");
            if (mobileContainer) {
                mobileContainer.style.top = `${telInputRect.bottom}px`;
                mobileContainer.style.left = `calc(${telInputRect.right}px - 280px)`;
            }
        });
    }

    inputCheckoutValidate(itl);
    document.querySelector(".checkout").addEventListener('keyup', function() {
        inputCheckoutValidate(itl, 'keyup');
    });
    document.querySelector(".checkout").addEventListener('change', function(e) {
        inputCheckoutValidate(itl, 'change', e.target);
    });
}

function inputCheckoutValidate(itl, type, input) {
    if (document.querySelector(".checkout")) {
        const form = document.querySelector(".basket__checkout");
        const formButton = form.querySelector(".checkout__btn");

        formButton.disabled = true;

        var billing_first_name = form.querySelector('#billing_first_name');
        var billing_last_name = form.querySelector('#billing_last_name');
        var billing_phone = form.querySelector("#billing_phone");
        var billing_email = form.querySelector('#billing_email');

        let first_nameValidate;
        let last_nameValidate;
        let phoneValidate;
        let emailValidate;

        if (billing_first_name.value !== '') {
            first_nameValidate = true;
            billing_first_name.closest('.checkout__inp').classList.add('validate_ok');
            if (type == 'keyup') {
                billing_first_name.closest('.checkout__inp').classList.remove('validation_error');
            }
        } else {
            first_nameValidate = false;
            billing_first_name.closest('.checkout__inp').classList.remove('validate_ok');
            if (type == 'change' && billing_first_name == input) {
                billing_first_name.closest('.checkout__inp').classList.add('validation_error');
            }
        }

        if (billing_last_name.value !== '') {
            last_nameValidate = true;
            billing_last_name.closest('.checkout__inp').classList.add('validate_ok');
            if (type == 'keyup') {
                billing_last_name.closest('.checkout__inp').classList.remove('validation_error');
            }
        } else {
            last_nameValidate = false;
            billing_last_name.closest('.checkout__inp').classList.remove('validate_ok');
            if (type == 'change' && billing_last_name == input) {
                billing_last_name.closest('.checkout__inp').classList.add('validation_error');
            }
        }


        if (itl.isValidNumber()) {
            phoneValidate = true;
            billing_phone.closest('.checkout__inp').classList.add('validate_ok');
            if (type == 'keyup') {
                billing_phone.closest('.checkout__inp').classList.remove('validation_error');
            }
        } else {
            phoneValidate = false;
            billing_phone.closest('.checkout__inp').classList.remove('validate_ok');
            if (type == 'change' && billing_phone == input) {
                billing_phone.closest('.checkout__inp').classList.add('validation_error');
            }
        }

        var pattern_email = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (pattern_email.test(billing_email.value)) {
            emailValidate = true;
            billing_email.closest('.checkout__inp').classList.add('validate_ok');
            if (type == 'keyup') {
                billing_email.closest('.checkout__inp').classList.remove('validation_error');
            }
        } else {
            emailValidate = false;
            billing_email.closest('.checkout__inp').classList.remove('validate_ok');
            if (type == 'change' && billing_email == input) {
                billing_email.closest('.checkout__inp').classList.add('validation_error');
            }
        }

        var isValid = true;
        if (form.querySelector('#shipping_method_0_local_pickup-3').checked == false) {
            var shipping_inputs = document.querySelectorAll('.shipping_address .validate-required input');

            for (var i = 0; i < shipping_inputs.length; i++) {
                if (shipping_inputs[i].value.trim() === '') {
                    isValid = false;
                    shipping_inputs[i].closest('.checkout__inp').classList.remove('validate_ok');
                    if (type == 'change' && shipping_inputs[i] == input) {
                        shipping_inputs[i].closest('.checkout__inp').classList.add('validation_error');
                    }
                } else {
                    if (shipping_inputs[i].getAttribute('name') == 'shipping_postcode') {
                        var pattern_postcode = /^[0-9]+$/;
                        if (!pattern_postcode.test(shipping_inputs[i].value)) {
                            isValid = false;
                            shipping_inputs[i].closest('.checkout__inp').classList.remove('validate_ok');
                            if (type == 'change' && shipping_inputs[i] == input) {
                                shipping_inputs[i].closest('.checkout__inp').classList.add('validation_error');
                            }
                        } else {
                            shipping_inputs[i].closest('.checkout__inp').classList.add('validate_ok');
                            if (type == 'keyup') {
                                shipping_inputs[i].closest('.checkout__inp').classList.remove('validation_error');
                            }
                        }
                    } else {
                        shipping_inputs[i].closest('.checkout__inp').classList.add('validate_ok');
                        if (type == 'keyup') {
                            shipping_inputs[i].closest('.checkout__inp').classList.remove('validation_error');
                        }
                    }
                }
            }
        }

        if (form.querySelector('[name="accept-policy"]').checked == false) {
            isValid = false;
        }

        if (first_nameValidate == true && last_nameValidate == true && phoneValidate == true && emailValidate == true && isValid == true) {
            formButton.disabled = false;
        }
    }
}



function delivery_metod() {
    var delivery_metod = document.querySelector('.woocommerce-shipping-methods input:checked');
    var shipping_country_field = document.querySelector('#shipping_country_field');

    var shipping_address_1 = document.querySelector('#shipping_address_1');
    var shipping_address_2 = document.querySelector('#shipping_address_2');
    var shipping_city = document.querySelector('#shipping_city');
    var shipping_postcode = document.querySelector('#shipping_postcode');

    if (delivery_metod) {
        var shipping_form = document.querySelector('.woocommerce-shipping-fields');
        if (delivery_metod.value == 'local_pickup:3') {
            shipping_form.classList.add('disabled');

            shipping_address_1.value = "Самовывоз";
            shipping_address_2.value = "Самовывоз";
            shipping_city.value = "Самовывоз";
            shipping_postcode.value = "0000000";
        } else {
            shipping_form.classList.remove('disabled');

            shipping_address_1.value = '';
            shipping_address_2.value = '';
            shipping_city.value = '';
            shipping_postcode.value = '';

            if (delivery_metod.value == 'free_shipping:4' || delivery_metod.value == 'flat_rate:8') {
                shipping_country_field.classList.add('disabled');
            } else {
                shipping_country_field.classList.remove('disabled');
            }
        }
    }
}

function updateCheckoutPrice() {
    basket__checkout.querySelector('.basket-total__item_full-price').textContent = document.querySelector('.cart__total-item_full-price').textContent;
    basket__checkout.querySelector('.basket-total__item_sale-price').textContent = document.querySelector('.cart__total-item_sale-price').textContent;
    basket__checkout.querySelectorAll('input.shipping_method').forEach(function(item) {
        item.addEventListener('click', function() {
            updateCheckoutPriceDelivery(item);
            addDeliveryDesc(item);
        });
        if (item.checked) {
            updateCheckoutPriceDelivery(item);
            addDeliveryDesc(item);
        }
    });
}

function addDeliveryDesc(item) {
    if (document.querySelector('.delivery_description')) {
        document.querySelector('.delivery_description').remove();
    }

    var value = item.getAttribute('value');
    var delivery_description = document.createElement('div');
    delivery_description.className = 'delivery_description';
    switch (value) {
        case 'local_pickup:3':
            delivery_description.innerHTML = 'Примерить и забрать Вашу покупку сможете в нашем брендовом шоу-руме в Гродно, на Советской, 31';
            break;
        case 'free_shipping:4':
            delivery_description.innerHTML = 'Мы доставим Вашу покупку в любое отделение Белпочта . Стоимость доставки оплачивается по тарифам РУП «Белпочта» при получении. Совершая покупку на 300 бел.рублей и больше мы доставим ее до удобного для Вас отделения Белпочта бесплатно.';
            break;
        case 'flat_rate:8':
            delivery_description.innerHTML = 'Мы доставим покупку прямо к Вам домой или в офис. Стоимость доставки оплачивается по тарифам РУП «Белпочта» при получении. Совершая покупку на 600 бел.рублей и больше мы доставим ее до двери Бесплатно.';
            break;
        case 'flat_rate:9':
            delivery_description.innerHTML = 'Мы доставим Вашу покупку до отделения СДЭК в Вашем городе или до двери. Сроки и стоимость доставки по тарифам ТК «СДЭК». Оплатить стоимость доставки Вы сможете при получении отправления.';
            break;
        case 'flat_rate:10':
            delivery_description.innerHTML = 'Мы отправим Вашу покупку в любую страну, где принимают посылки из Беларуси. Стоимость и сроки доставки зависят от веса и страны назначения. Примерную стоимость доставки можете рассчитать на сайте <a href="http://tarifikator.belpost.by/forms/international/ems.php" target="_blank">http://tarifikator.belpost.by/forms/international/ems.php</a> или напишите нашим менеджерам <a href="tel:+375339144161">+375339144161</a> и они смогут рассчитать ориентировочную стоимость доставки';
            break;
        default:
            break;
    }
    item.closest('.checkout__radio').insertAdjacentElement('afterend', delivery_description);
}

function updateCheckoutPriceDelivery(item) {
    if (item.checked) {
        var element = item.closest('.checkout__radio').querySelector('bdi');
        var price_delivery = 0;
        if (element) {
            element = element.textContent.replace(/[^0-9.]/g, '');
            price_delivery = parseFloat(element);
        }
        basket__checkout.querySelector('.basket-total__item_delivery-price').textContent = price_delivery + ' BYN';

        jQuery(document.body).on('updated_checkout', function() {
            jQuery.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: 'update_checkout_total_price',
                },
                success: function(response) {
                    basket__checkout.querySelector('.basket-total__result').innerHTML = response.slice(0, -1);
                }
            });
        });
        jQuery(document.body).trigger('init_checkout');
    }
    delivery_metod();
}

function checkoutPromocodeReset(code) {
    let promocodeMassage = document.querySelector('.checkout__promocode-massage');

    jQuery.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'reset_promocode',
            code: code,
        },
        success: function(response) {
            promocodeMassage.innerHTML = response;
            updateCart();
        }
    });
}

function checkoutPromocodeAdd(code) {
    let promocodeMassage = document.querySelector('.checkout__promocode-massage');

    jQuery.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'add_promocode',
            code: code,
        },
        success: function(response) {
            if (response !== 'NULL') {
                promocodeMassage.innerHTML = response;
                setTimeout(() => {
                    updateCart();
                }, "1000");
            } else {
                promocodeMassage.innerHTML = 'Данного промокода не существует.';
            }
        }
    });
}

function targetCartElements() {
    var openOneClickPopupButton = document.getElementById("openOneClickPopup");
    if (openOneClickPopupButton) {
        const oneClickPopup = document.getElementById("oneClickPopup");

        openOneClickPopupButton.addEventListener("click", () => {
            oneClickPopup.classList.add("popup--active");
            document.body.classList.add("fixed");
        });
    }

    document.querySelectorAll('.cart-item__remove').forEach(function(removeItem) {
        removeItem.addEventListener('click', function() {
            var productId = removeItem.closest('.cart-item').getAttribute('data-cart-product');
            var variationId = removeItem.closest('.cart-item').getAttribute('data-cart-variation');
            removeFromCart(productId, variationId);
        });

    });

    document.querySelectorAll('.cart-product__remove-btn').forEach(function(removeItem) {
        removeItem.addEventListener('click', function() {
            document.querySelector('.cart_preloader').classList.remove('disabled');
            removeFromCartPage(removeItem);
        });

    });

    document.querySelector('.cart__reset').addEventListener('click', function() {
        clearCart();
    });

    if (basket__body) {
        basket__body.querySelector('.basket__clear').addEventListener('click', function() {
            clearCart();
        });
        document.querySelector('.basket__clear-basket').addEventListener('click', function() {
            clearCart();
        });
    }


    const cart = document.querySelector(".cart");
    const closeCart = cart.querySelector(".cart__back");
    closeCart.addEventListener("click", () => {
        cart.classList.remove("cart--active");
        document.body.classList.remove("fixed");
    });

    const counter = document.querySelectorAll(".counter");
    if (counter) {
        counter.forEach((item) => {
            const counterMinus = item.querySelector(".counter__btn--minus");
            const counterPlus = item.querySelector(".counter__btn--plus");
            const counterValue = item.querySelector(".counter__value");

            let value = +counterValue.textContent;
            counterValue.textContent = value;
            if (value < 2) {
                counterMinus.disabled = true;
            }

            counterPlus.addEventListener("click", () => {
                let value = +counterValue.textContent;
                value++;
                counterValue.textContent = value;
                if (value > 1) {
                    counterMinus.disabled = false;
                }
            });

            counterMinus.addEventListener("click", () => {
                let value = +counterValue.textContent;
                value--;
                counterValue.textContent = value;
                if (value < 2) {
                    counterMinus.disabled = true;
                }
            });

            var timeoutId;

            item.addEventListener("click", function() {
                if (timeoutId) {
                    clearTimeout(timeoutId); // Отменяем предыдущий таймер
                }

                timeoutId = setTimeout(function() {
                    document.querySelector('.cart_preloader').classList.remove('disabled');
                    var productId = item.closest('[data-cart-product]').getAttribute('data-cart-product');
                    var variationId = item.closest('[data-cart-product]').getAttribute('data-cart-variation');
                    var quantity = counterValue.textContent;
                    updateCartItemQuantity(productId, variationId, quantity);
                    timeoutId = null; // Сбрасываем таймер
                }, 1300);
            });

        });
    }


}


document.addEventListener('DOMContentLoaded', function() {
    targetCartElements();
    if (basket__checkout) {
        updateCheckoutPrice();
        inputValidate();

        var checkout__promocode = document.querySelector('.checkout__promocode');
        if (checkout__promocode) {
            basket__checkout.addEventListener('click', function(e) {
                targetEl = e.target;
                if (targetEl.classList.contains('checkout__promocode-active') || targetEl.closest('.checkout__promocode-active')) {
                    let code = document.querySelector('.checkout__promocode-name').textContent;
                    checkoutPromocodeReset(code);
                }
                if (targetEl.classList.contains('checkout__promocode-apply')) {
                    let code = document.querySelector('.checkout__promocode-input').value;
                    checkoutPromocodeAdd(code);
                }
            });
        }
    }




    var add_cart_btn = document.querySelector('.product__add-to-cart');

    if (add_cart_btn) {
        add_cart_btn.addEventListener('click', function() {
            var variationId = document.querySelector('.size-btn.size-btn--selected').getAttribute('data-variation');
            if (!add_cart_btn.disabled && variationId) {
                jQuery.ajax({
                    type: 'POST',
                    url: '/wp-admin/admin-ajax.php',
                    data: {
                        action: 'add_to_cart',
                        variation_id: variationId,
                        quantity: 1,
                    },
                    success: function(response) {
                        var addToCartPopup = document.getElementById("addToCart");
                        addToCartPopup.classList.add("popup--active");
                        document.body.classList.add("fixed");
                        var add_to_cart_block_before = document.querySelector('.add-to-cart-block_before');
                        var add_to_cart_block_after = document.querySelector('.add-to-cart-block_after');
                        add_to_cart_block_before.classList.add('disabled');
                        add_to_cart_block_after.classList.remove('disabled');


                        add_cart_btn.disabled = true;
                        var btnName = add_cart_btn.textContent;
                        add_cart_btn.innerHTML = response;
                        setTimeout(function() {
                            add_cart_btn.disabled = false;
                            add_cart_btn.innerHTML = btnName;
                        }, 2000);
                        updateCart();
                    }
                });
            }
        });
    }

    const listing_add_cart_btn = document.querySelector('.listing_add_cart_btn');
    const add_to_cart_block_before = document.querySelector('.add-to-cart-block_before');
    const add_to_cart_block_after = document.querySelector('.add-to-cart-block_after');
    if (listing_add_cart_btn) {
        listing_add_cart_btn.disabled = true;
        listing_add_cart_btn.addEventListener('click', function() {
            var variationId = document.querySelector('button.size-btn--selected[data-variation-product-id]').getAttribute('data-variation-product-id');
            if (listing_add_cart_btn.disabled !== true && variationId) {
                jQuery.ajax({
                    type: 'POST',
                    url: '/wp-admin/admin-ajax.php',
                    data: {
                        action: 'add_to_cart',
                        variation_id: variationId,
                        quantity: 1,
                    },
                    success: function(response) {
                        add_to_cart_block_before.classList.add('disabled');
                        add_to_cart_block_after.classList.remove('disabled');
                        listing_add_cart_btn.disabled = true;
                        var btnName = listing_add_cart_btn.textContent;
                        listing_add_cart_btn.innerHTML = response;
                        setTimeout(function() {
                            listing_add_cart_btn.disabled = false;
                            listing_add_cart_btn.innerHTML = btnName;
                        }, 3000);
                        updateCart();

                    }
                });
            }
        });
    }


});