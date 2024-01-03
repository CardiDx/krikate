(() => {
    const swiper = new Swiper(".hero__slider", {
        loop: true,
        spaceBetween: 10,
        autoplay: {
            delay: 6000,
        },
        watchSlidesProgress: true,
        pagination: {
            el: ".hero__slider-pagination",
        },
        navigation: {
            nextEl: ".hero__slider-nav-btn--next",
            prevEl: ".hero__slider-nav-btn--prev",
        },
        breakpoints: {
            1000: {
                slidesPerView: 2.2,
            },
            740: {
                slidesPerView: 2.1,
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
        },
    });

    const lookbookSwiper = new Swiper(".more-lookbooks__slider", {
        loop: true,
        spaceBetween: 10,
        navigation: {
            nextEl: ".more-lookbooks__slider-nav-btn--next",
            prevEl: ".more-lookbooks__slider-nav-btn--prev",
        },
        breakpoints: {
            1000: {
                slidesPerView: 4.08,
            },
            740: {
                slidesPerView: 3.2,
            },
            540: {
                slidesPerView: 2.2,
            },
            320: {
                slidesPerView: 1.5,
            },
        },
    });

    const companySwiper = new Swiper(".company__slider", {
        loop: true,
        spaceBetween: 10,
        centeredSlides: true,
        navigation: {
            nextEl: ".company__slider-nav-btn--next",
            prevEl: ".company__slider-nav-btn--prev",
        },
        breakpoints: {
            1000: {
                slidesPerView: 1.8,
            },
            740: {
                slidesPerView: 1.6,
            },
            540: {
                slidesPerView: 1.4,
            },
            320: {
                slidesPerView: 1.2,
            },
        },
    });

    const categoriesSwiper = new Swiper(".categories-slider", {
        loop: true,
        slidesPerView: 6.25,
        spaceBetween: 10,
        navigation: {
            nextEl: ".categories-slider__nav-btn--next",
            prevEl: ".categories-slider__nav-btn--prev",
        },
        breakpoints: {
            1500: {
                slidesPerView: 6.25,
            },
            1240: {
                slidesPerView: 5.25,
            },
            1000: {
                slidesPerView: 4.25,
            },
            320: {
                slidesPerView: 3.7,
            },
        },
    });

    // const galllerySwiper = new Swiper(".gallery-slider", {
    // 	loop: true,
    // 	spaceBetween: 0,
    // 	breakpoints: {
    // 		541: {
    // 			slidesPerView: 2,
    // 			spaceBetween: 10,
    // 		},
    // 	},
    // });

    // function initGallerySwiper() {
    //     const galllerySwiper = new Swiper(".gallery-slider", {
    //         loop: true,
    //         spaceBetween: 0,
    //         breakpoints: {
    //             541: {
    //                 slidesPerView: 2,
    //                 spaceBetween: 10,
    //             },
    //         },
    //     });

    // }

    // initGallerySwiper();

    const psSearchResults = new PerfectScrollbar(".search__results");
    if (document.querySelector(".filter__body")) {
        const psFilterBody = new PerfectScrollbar(".filter__body");

        if (window.screen.width < 1040) {
            psFilterBody.destroy();
        }
    }
    const psCartBody = new PerfectScrollbar(".cart__body");

    const psMobileMenuWrapper = new PerfectScrollbar(".header__modile-menu");

    const openCatalogMenuButton = document.getElementById("openCatalogMenu");
    const openBuyersMenuButton = document.getElementById("openBuyersMenu");
    const catalogMenu = document.getElementById("catalogMenu");
    const buyersMenu = document.getElementById("buyersMenu");
    const closeDropdown = document.querySelectorAll(".h-dropdown__close");

    openCatalogMenuButton.addEventListener("click", () => {
        document.body.classList.add("fixed");
        if (buyersMenu.classList.contains("header__dropdown--active")) {
            buyersMenu.classList.remove("header__dropdown--active");
        }
        catalogMenu.classList.add("header__dropdown--active");
    });

    openBuyersMenuButton.addEventListener("click", () => {
        document.body.classList.add("fixed");
        if (catalogMenu.classList.contains("header__dropdown--active")) {
            catalogMenu.classList.remove("header__dropdown--active");
        }
        buyersMenu.classList.add("header__dropdown--active");
    });

    closeDropdown.forEach((item) => {
        item.addEventListener("click", () => {
            if (catalogMenu.classList.contains("header__dropdown--active")) {
                catalogMenu.classList.remove("header__dropdown--active");
            }
            if (buyersMenu.classList.contains("header__dropdown--active")) {
                buyersMenu.classList.remove("header__dropdown--active");
            }
            document.body.classList.remove("fixed");
        });
    });

    const cartButton = document.querySelector(".header__cart");
    const cart = document.querySelector(".cart");
    const cartWrapper = cart.querySelector(".cart__wrapper");
    const closeCart = cart.querySelector(".cart__back");
    cartButton.addEventListener("click", () => {
        if (mobileMenu.classList.contains("header__modile-menu--active")) {
            burgerButton.classList.remove("header__burger--active");
            mobileMenu.classList.remove("header__modile-menu--active");
            mobileMenuLinks.forEach((link) => link.classList.remove("not-active"));
        }
        if (catalogMenu.classList.contains("header__dropdown--active")) {
            catalogMenu.classList.remove("header__dropdown--active");
        }
        cart.classList.add("cart--active");
        document.body.classList.add("fixed");
    });

    closeCart.addEventListener("click", () => {
        cart.classList.remove("cart--active");
        document.body.classList.remove("fixed");
    });

    cart.addEventListener("click", (e) => {
        if (!cartWrapper.contains(e.target)) {
            cart.classList.remove("cart--active");
            document.body.classList.remove("fixed");
        }
    });

    const searchButton = document.querySelector(".header__search");
    const search = document.querySelector(".search");
    const searchTop = search.querySelector(".search__top");
    const searchBody = search.querySelector(".search__body");
    searchButton.addEventListener("click", () => {
        if (catalogMenu.classList.contains("header__dropdown--active")) {
            catalogMenu.classList.remove("header__dropdown--active");
            document.body.classList.remove("fixed");
        }
        if (mobileMenu.classList.contains("header__modile-menu--active")) {
            burgerButton.classList.remove("header__burger--active");
            mobileMenu.classList.remove("header__modile-menu--active");
            mobileMenuLinks.forEach((link) => link.classList.remove("not-active"));
            document.body.classList.remove("fixed");
        }
        search.classList.toggle("search--active");
        document.body.classList.toggle("fixed");
    });

    search.addEventListener("click", (e) => {
        if (!searchTop.contains(e.target) && !searchBody.contains(e.target)) {
            search.classList.remove("search--active");
            document.body.classList.remove("fixed");
        }
    });

    const clearSearchButton = search.querySelector(".search__clear");
    const searchInput = search.querySelector(".search__inp");
    clearSearchButton.addEventListener("click", () => {
        searchInput.value = "";
        document.querySelector('.search__results').innerHTML = '';
        search.classList.toggle("search--active");
        document.body.classList.toggle("fixed");
    });

    const burgerButton = document.querySelector(".header__burger");
    const mobileMenu = document.querySelector(".header__modile-menu");

    burgerButton.addEventListener("click", () => {
        burgerButton.classList.toggle("header__burger--active");
        mobileMenu.classList.toggle("header__modile-menu--active");
        document.body.classList.toggle("fixed");
        mobileMenuLinks.forEach((link) => link.classList.remove("not-active"));
        if (catalogNestedMenu.classList.contains("h-mobile-menu__level--active")) {
            openCatalogNestedMenuButton.classList.remove(
                "h-mobile-menu__btn--active"
            );
            catalogNestedMenu.classList.remove("h-mobile-menu__level--active");
        }
        if (buyersNestedMenu.classList.contains("h-mobile-menu__level--active")) {
            openBuyersNestedMenuButton.classList.remove("h-mobile-menu__btn--active");
            buyersNestedMenu.classList.remove("h-mobile-menu__level--active");
        }
    });

    const openCatalogNestedMenuButton = document.getElementById(
        "openCatalogNestedMenu"
    );
    const catalogNestedMenu = document.getElementById("catalogNestedMenu");
    const openBuyersNestedMenuButton = document.getElementById(
        "openBuyersNestedMenu"
    );
    const buyersNestedMenu = document.getElementById("buyersNestedMenu");
    const closeNestedMenuButton = document.querySelectorAll(
        ".h-mobile-menu__back"
    );
    const mobileMenuLinks = document.querySelectorAll(
        ".h-mobile-menu__link:not(.h-mobile-menu__btn--active)"
    );

    openCatalogNestedMenuButton.addEventListener("click", () => {
        if (buyersNestedMenu.classList.contains("h-mobile-menu__level--active")) {
            openBuyersNestedMenuButton.classList.remove("h-mobile-menu__btn--active");
            buyersNestedMenu.classList.remove("h-mobile-menu__level--active");
        }
        mobileMenuLinks.forEach((link) => {
            link.classList.add("not-active");
        });
        openCatalogNestedMenuButton.classList.add("h-mobile-menu__btn--active");
        catalogNestedMenu.classList.add("h-mobile-menu__level--active");
    });

    openBuyersNestedMenuButton.addEventListener("click", () => {
        if (catalogNestedMenu.classList.contains("h-mobile-menu__level--active")) {
            openCatalogNestedMenuButton.classList.remove(
                "h-mobile-menu__btn--active"
            );
            catalogNestedMenu.classList.remove("h-mobile-menu__level--active");
        }
        mobileMenuLinks.forEach((link) => {
            link.classList.add("not-active");
        });
        openBuyersNestedMenuButton.classList.add("h-mobile-menu__btn--active");
        buyersNestedMenu.classList.add("h-mobile-menu__level--active");
    });

    closeNestedMenuButton.forEach((item) => {
        item.addEventListener("click", () => {
            mobileMenuLinks.forEach((link) => {
                link.classList.remove("not-active");
            });
            if (
                catalogNestedMenu.classList.contains("h-mobile-menu__level--active")
            ) {
                openCatalogNestedMenuButton.classList.remove(
                    "h-mobile-menu__btn--active"
                );
                catalogNestedMenu.classList.remove("h-mobile-menu__level--active");
            }
            if (buyersNestedMenu.classList.contains("h-mobile-menu__level--active")) {
                openBuyersNestedMenuButton.classList.remove(
                    "h-mobile-menu__btn--active"
                );
                buyersNestedMenu.classList.remove("h-mobile-menu__level--active");
            }
        });
    });

    const openFilter = document.querySelector(".catalog__filter-btn");
    if (openFilter) {
        const closeFilter = document.querySelector(".filter__back");
        const filter = document.querySelector(".filter");
        const filterWrapper = document.querySelector(".filter__wrapper");

        openFilter.addEventListener("click", () => {
            filter.classList.add("filter--active");
        });

        filter.addEventListener("click", (e) => {
            if (!filterWrapper.contains(e.target)) {
                filter.classList.remove("filter--active");
            }
        });

        closeFilter.addEventListener("click", () => {
            filter.classList.remove("filter--active");
        });



        const filterSections = document.querySelectorAll(".filter-section");
        filterSections.forEach((section) => {
            const sectionArrowBtn = section.querySelector(".filter-section__arrow");
            const sectionBody = section.querySelector(".filter-section__body");

            if (sectionArrowBtn) {
                sectionArrowBtn.addEventListener("click", () => {
                    sectionArrowBtn.classList.toggle("filter-section__arrow--down");
                    sectionBody.classList.toggle("filter-section__body--open");
                });
            }
        });

        const filterCategories = document.querySelectorAll(
            ".filter-section__category-item"
        );

        filterCategories.forEach((item) => {
            item.addEventListener("click", () => {
                item.classList.toggle("filter-section__category-item--active");
            });
        });

        const filterRange = document.querySelector(".filter-range");
        if (filterRange) {
            let min = parseInt(filter.querySelector('.filter-range__values>#min>span').textContent);
            let max = parseInt(filter.querySelector('.filter-range__values>#max>span').textContent);
            let min_const = parseInt(filter.querySelector('.filter-range__values>#min>span').textContent);
            let max_const = parseInt(filter.querySelector('.filter-range__values>#max>span').textContent);

            const calcLeftPosition = (value) => (100 / (max_const - min_const)) * (parseInt(value) - min_const);
            const rangeMin = filter.querySelector("#rangeMin");
            const rangeMax = filter.querySelector("#rangeMax");
            const thumbMin = filter.querySelector("#thumbMin");
            const thumbMax = filter.querySelector("#thumbMax");
            const line = filter.querySelector(".filter-range__line");

            const minValue = filter.querySelector("#min span");
            const maxValue = filter.querySelector("#max span");

            rangeMin.addEventListener("input", (e) => {
                const newValue = parseInt(e.target.value);
                if (newValue > max) return;
                min = newValue;
                thumbMin.style.left = calcLeftPosition(newValue) + "%";
                minValue.textContent = newValue;
                line.style.left = calcLeftPosition(newValue) + "%";
                line.style.right = 100 - calcLeftPosition(max) + "%";
            });


            rangeMax.addEventListener("input", function(e) {
                const newValue = parseInt(e.target.value);
                if (newValue < min) return;
                max = newValue;
                thumbMax.style.left = calcLeftPosition(newValue) + "%";
                maxValue.textContent = newValue;
                line.style.left = calcLeftPosition(min) + "%";
                line.style.right = 100 - calcLeftPosition(newValue) + "%";
            });

            document.addEventListener('DOMContentLoaded', function() {
                let newValue = parseInt(rangeMin.value);
                if (newValue > max) return;
                thumbMin.style.left = calcLeftPosition(newValue) + "%";
                minValue.textContent = newValue;
                line.style.left = calcLeftPosition(newValue) + "%";
                line.style.right = 100 - calcLeftPosition(max) + "%";

                newValue = parseInt(rangeMax.value);
                if (newValue < min) return;
                thumbMax.style.left = calcLeftPosition(newValue) + "%";
                maxValue.textContent = newValue;
                line.style.left = calcLeftPosition(min) + "%";
                line.style.right = 100 - calcLeftPosition(newValue) + "%";
            });
        }
    }

    const productCards = document.querySelectorAll(".product-card");
    if (productCards) {
        productCards.forEach((product) => {
            const colorsBtns = product.querySelectorAll(".product-card__colors-item");
            const pictureGroups = product.querySelectorAll(
                ".product-card__picture-group"
            );

            const addToCartButton = product.querySelector(".product-card__add");
            const addToCartPopup = document.getElementById("addToCart");

            if (addToCartButton) {

                addToCartButton.addEventListener("click", () => {
                    document.querySelector('.listing_onbackorder_block').classList.add('hidden');
                    document.querySelector('.listing_add_cart_btn').classList.remove('hidden');
                    document.querySelector('.listing_add_cart_btn').disabled = true;

                    addToCartPopup.classList.add("popup--active");
                    document.body.classList.add("fixed");
                    var color_var = addToCartButton.closest('.product-card').querySelector('.product-card__colors-item.product-card__colors-item--selected').getAttribute('id');
                    var color_var_name = addToCartButton.closest('.product-card').querySelector('.product-card__colors-item.product-card__colors-item--selected').getAttribute('data-color-name');
                    var product_id = addToCartButton.getAttribute('data-product-id');
                    var info__sizes = document.querySelector('.order-info__sizes');
                    var order_info__size = document.querySelector('.order-info__size span');
                    info__sizes.innerHTML = '<div class="cart_preloader"><svg viewBox="25 25 50 50"><circle r="20" cy="50" cx="50"></circle></svg></div>';
                    order_info__size.innerHTML = 'Выберите размер';
                    order_info__size.style.color = "#D91015";
                    jQuery.ajax({
                        type: 'POST',
                        url: '/wp-admin/admin-ajax.php',
                        data: {
                            action: 'select_size_product',
                            color_var: color_var,
                            product_id: product_id,
                        },
                        success: function(response) {
                            info__sizes.innerHTML = response;
                            var order_info__color = document.querySelector('.order-info__color span');
                            order_info__color.textContent = color_var_name;

                            var info__sizes_btn = info__sizes.querySelectorAll('.size-btn');

                            info__sizes_btn.forEach((btn) => {
                                btn.addEventListener("click", () => {
                                    info__sizes_btn.forEach((item) => {
                                        order_info__size.textContent = "";
                                        item.classList.remove("size-btn--selected");
                                    });
                                    order_info__size.textContent = btn.textContent;
                                    order_info__size.style.color = "initial";
                                    btn.classList.toggle("size-btn--selected");
                                    if (btn.getAttribute('data-variation-product-stock') == 'onbackorder' || btn.getAttribute('data-variation-product-stock') == 'outofstock') {
                                        document.querySelector('.listing_onbackorder_block').classList.remove('hidden');
                                        document.querySelector('.listing_add_cart_btn').classList.add('hidden');
                                    } else {
                                        document.querySelector('.listing_add_cart_btn').disabled = false;
                                        document.querySelector('.listing_onbackorder_block').classList.add('hidden');
                                        document.querySelector('.listing_add_cart_btn').classList.remove('hidden');
                                    }

                                });
                            });
                        }
                    });
                });

                colorsBtns.forEach((btn) => {
                    btn.addEventListener("click", () => {
                        colorsBtns.forEach((item) =>
                            item.classList.remove("product-card__colors-item--selected")
                        );
                        pictureGroups.forEach((item) => {
                            item.classList.remove("product-card__picture-group--selected");

                            if (item.dataset.color === btn.id) {
                                item.classList.add("product-card__picture-group--selected");
                            }
                        });
                        btn.classList.add("product-card__colors-item--selected");

                        var color_var = btn.closest('.product-card').querySelector('.product-card__colors-item.product-card__colors-item--selected').getAttribute('id');
                        var product_id = btn.closest('.product-card').getAttribute('data-product-id');
                        jQuery.ajax({
                            type: 'POST',
                            url: '/wp-admin/admin-ajax.php',
                            data: {
                                action: 'view_product_price_listing',
                                product_color: color_var,
                                product_id: product_id,
                            },
                            success: function(response) {
                                var priceWrap = btn.closest('.product-card').querySelector('.product-card__wrap');
                                response_view = response.slice(0, -1);
                                priceWrap.innerHTML = response_view;
                            }
                        });
                    });
                });
            }
        });
    }

    const orderInfo = document.querySelector(".order-info");
    if (orderInfo) {
        const orderInfoSize = orderInfo.querySelector(".order-info__size");

        const sizeButtons = document.querySelectorAll(".size-btn");
        sizeButtons.forEach((btn) => {
            btn.addEventListener("click", () => {
                sizeButtons.forEach((item) => {
                    orderInfoSize.textContent = "";
                    item.classList.remove("size-btn--selected");
                });
                orderInfoSize.textContent = btn.textContent;
                orderInfoSize.style.color = "initial";
                btn.classList.toggle("size-btn--selected");
            });
        });
        updateSelectSize();

    }

    function updateSelectSize() {
        var size_btn = document.querySelector(".product__size-list.selected-variation-color .size-btn");
        if (size_btn) {
            size_btn.classList.add("size-btn--selected");
        }

    }





    const openOneClickProductPopupButton = document.getElementById("openOneClickProductPopup");
    if (openOneClickProductPopupButton) {
        const oneClickPopup = document.getElementById("oneClickPopup");

        openOneClickProductPopupButton.addEventListener("click", () => {
            var single_var = oneClickPopup.querySelector('input[name="single_variation_id"]');
            if (single_var) {
                single_var.value = document.querySelector('.size-btn.size-btn--selected').getAttribute('data-variation');
            }
            oneClickPopup.classList.add("popup--active");
            document.body.classList.add("fixed");
        });
    }

    const openOnBackorderPopupButton = document.querySelectorAll("#openOnBackorderPopup");
    if (openOnBackorderPopupButton) {
        const onBackorderPopup = document.getElementById("onBackorderPopup");

        openOnBackorderPopupButton.forEach(function(button) {
            button.addEventListener("click", () => {
                var otherPopup = document.querySelector('.popup--active');
                if (otherPopup) {
                    otherPopup.classList.remove("popup--active");
                }
                onBackorderPopup.classList.add("popup--active");
                document.body.classList.add("fixed");

                if (button.classList.contains('product_onbackorder')) {
                    var variationId = document.querySelector('.size-btn.size-btn--selected').getAttribute('data-variation');
                } else {
                    var variationId = document.querySelector('button.size-btn--selected[data-variation-product-id]').getAttribute('data-variation-product-id');
                }

                onBackorderPopup.querySelector('input[name="variation_id"]').value = variationId;

                jQuery.ajax({
                    type: 'POST',
                    url: '/wp-admin/admin-ajax.php',
                    data: {
                        action: 'onbackorder_product_info',
                        variation_id: variationId,
                    },
                    success: function(response) {
                        onBackorderPopup.querySelector('.cart-item').innerHTML = response;
                    }
                });
            });


        });
    }

    jQuery('.popup-form').submit(function() {
        var form = jQuery(this);
        var formData = jQuery(this).serialize();
        jQuery.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php',
            data: formData + '&action=onBackorderForm',
            success: function(response) {
                console.log(response);
                if (response == 1) {
                    form.closest('.popup__body').find('.error').css("display", 'none');
                    var otherPopup = document.querySelector('.popup--active');
                    if (otherPopup) {
                        otherPopup.classList.remove("popup--active");
                    }
                    document.querySelector('#thanksPopup').classList.add("popup--active");
                    document.body.classList.add("fixed");
                } else {
                    form.closest('.popup__body').find('.error').css("display", 'block');
                }
            }
        });
        return false;
    });


    jQuery('.subscription__form').submit(function() {
        var formMessage = document.querySelector('.subscription__form-message');
        var email = jQuery(this).find('input[type="email"]').val();
        var pattern_email = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        console.log(pattern_email.test(email.value));
        if (pattern_email.test(email)) {
            var formMessage = document.querySelector('.subscription__form-message');
            var formData = jQuery(this).serialize();
            jQuery.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                data: formData + '&action=subscriptionForm',
                success: function(response) {
                    // console.log(response);
                    if (response == 1) {
                        formMessage.innerHTML = "Ваша заявка на рассылку успешно отправлена";
                    } else {
                        formMessage.innerHTML = "Произошла ошибка, свяжитесь с администрацией сайта";
                    }
                }
            });
        } else {
            formMessage.innerHTML = "Введите корректный email";
        }
        return false;
    });

    // const openOnBackorderPopupButton = document.getElementById("openOnBackorderPopup");
    // if (openOnBackorderPopupButton) {
    //     const onBackorderPopup = document.getElementById("onBackorderPopup");

    //     openOnBackorderPopupButton.addEventListener("click", () => {
    //         var otherPopup = document.querySelector('.popup--active');
    //         if (otherPopup) {
    //             otherPopup.classList.remove("popup--active");
    //         }
    //         onBackorderPopup.classList.add("popup--active");
    //         document.body.classList.add("fixed");

    //         if () {
    //             var variationId = document.querySelector('.size-btn.size-btn--selected').getAttribute('data-variation');
    //         } else {
    //             var variationId = document.querySelector('button.size-btn--selected[data-variation-product-id]').getAttribute('data-variation-product-id');
    //         }

    //         onBackorderPopup.querySelector('input[name="variation_id"]').value = variationId;

    //         jQuery.ajax({
    //             type: 'POST',
    //             url: '/wp-admin/admin-ajax.php',
    //             data: {
    //                 action: 'onbackorder_product_info',
    //                 variation_id: variationId,
    //             },
    //             success: function(response) {
    //                 onBackorderPopup.querySelector('.cart-item').innerHTML = response;
    //             }
    //         });
    //     });

    //     jQuery('#onBackorderForm').submit(function() {
    //         var formData = jQuery(this).serialize();
    //         jQuery.ajax({
    //             type: 'POST',
    //             url: '/wp-admin/admin-ajax.php',
    //             data: formData + '&action=onBackorderForm',
    //             success: function(response) {
    //                 console.log(response);
    //                 if (response == 1) {
    //                     onBackorderPopup.querySelector('.error').style.display = "none";
    //                     var otherPopup = document.querySelector('.popup--active');
    //                     if (otherPopup) {
    //                         otherPopup.classList.remove("popup--active");
    //                     }
    //                     document.querySelector('#thanksPopup').classList.add("popup--active");
    //                     document.body.classList.add("fixed");
    //                 } else {
    //                     onBackorderPopup.querySelector('.error').style.display = "block";
    //                 }
    //             }
    //         });
    //         return false;
    //     });
    // }

    const openSizesTablePopupButton = document.querySelector(
        ".product__size-table"
    );
    if (openSizesTablePopupButton) {
        const sizesTablePopup = document.getElementById("sizesTablePopup");
        openSizesTablePopupButton.addEventListener("click", () => {
            sizesTablePopup.classList.add("popup--active");
            document.body.classList.add("fixed");
        });
    }

    const popups = document.querySelectorAll(".popup");
    popups.forEach((popup) => {
        const popupContainer = popup.querySelector(".popup__container");
        const closePopupButton = popup.querySelector(".popup__close");
        const closePopupButtonStatic = popup.querySelector(".popup__close-static");

        if (closePopupButtonStatic) {
            closePopupButtonStatic.addEventListener("click", () => {
                popup.classList.remove("popup--active");
                document.body.classList.remove("fixed");
                reset_addToCart();
            });
        }


        closePopupButton.addEventListener("click", () => {
            popup.classList.remove("popup--active");
            document.body.classList.remove("fixed");
            reset_addToCart();
        });
        popup.addEventListener("click", (e) => {
            if (!popupContainer.contains(e.target)) {
                popup.classList.remove("popup--active");
                document.body.classList.remove("fixed");
                reset_addToCart();
            }
        });
    });

    function reset_addToCart() {
        var add_to_cart_block_before = document.querySelector('.add-to-cart-block_before');
        var add_to_cart_block_after = document.querySelector('.add-to-cart-block_after');
        add_to_cart_block_before.classList.remove('disabled');
        add_to_cart_block_after.classList.add('disabled');
    }



    const productColorSelect = document.querySelector(".product__color");
    if (productColorSelect) {
        const colorSelectLabel = productColorSelect.querySelector(
            ".product__color-value"
        );
        const colorSelectButtons = productColorSelect.querySelectorAll(
            ".product__color-item"
        );
        colorSelectButtons.forEach((button) => {
            button.addEventListener("click", () => {
                colorSelectButtons.forEach((item) =>
                    item.classList.remove("product__color-item--selected")
                );
                colorSelectLabel.textContent = button.dataset.color;
                button.classList.add("product__color-item--selected");
            });
        });
    }

    const accordion = document.querySelectorAll(".accordion");
    accordion.forEach((item) => {
        const accordionHeader = item.querySelector(".accordion__header");
        const accordionBody = item.querySelector(".accordion__body");

        accordionHeader.addEventListener("click", () => {
            accordionHeader.classList.toggle("accordion__header--active");
            accordionBody.classList.toggle("accordion__body--active");
        });
    });

    //     if (document.querySelector(".glightbox")) {
    //         const gallerySlides = document.querySelectorAll(".gallery-slider__item");
    //         const slideArr = [];
    //         gallerySlides.forEach((item) => {
    //             const index = item.getAttribute("data-swiper-slide-index");
    //             const smImg = item.querySelector("img");
    //             slideArr.push({ index: index, small: smImg.src });
    //         });

    //         const customLightboxHTML = `<div id="glightbox-body" class="glightbox-container">
    //     <div class="gloader visible"></div>
    //     <div class="goverlay"></div>
    //     <div class="gcontainer">
    //     <div id="glightbox-slider" class="gslider">
    //         <div class="mini-gallery swiper">
    //             <div class="mini-gallery__wrapper swiper-wrapper">
    //                 ${slideArr
    // 										.map(
    // 											(
    // 												item
    // 											) => `<div class="mini-gallery__item swiper-slide" data-swiper-slide-index="${item.index}">
    //                 <img src="${item.small}">
    //             </div>`
    // 										)
    // 										.join("")}
    //             </div>
    //         </div>
    //     </div>
    //     <button style="display:none;" class="gnext gbtn" tabindex="0" aria-label="Next" data-customattribute="example">{nextSVG}</button>
    //     <button style="display:none;" class="gprev gbtn" tabindex="1" aria-label="Previous">{prevSVG}</button>
    //     <button style="display:none;" class="gclose gbtn" tabindex="2" aria-label="Close">{closeSVG}</button>
    // </div>
    // </div>`;

    // 	const lightbox = GLightbox({
    // 		selector: ".glightbox",
    // 		lightboxHTML: customLightboxHTML,
    // 		openEffect: "zoom",
    // 		slideEffect: "zoom",
    // 		closeButton: false,
    // 		draggable: false,
    // 		zoomable: false,
    // 	});

    // 	lightbox.on("open", () => {
    // 		window.scrollTo({
    // 			top: 0,
    // 		});

    // 		const minGalllerySwiper = new Swiper(".mini-gallery", {
    // 			loop: true,
    // 			slidesPerView: 6,
    // 			spaceBetween: 5,
    // 			direction: "vertical",
    // 		});

    // 		document.querySelectorAll(".mini-gallery__item").forEach((slide) => {
    // 			slide.addEventListener("mouseover", (e) => {
    // 				const index = slide.getAttribute("data-swiper-slide-index");
    // 				lightbox.goToSlide(index);
    // 				setTimeout(() => {
    // 					document
    // 						.querySelector(".gslide.current .gslide-image img")
    // 						.addEventListener("click", () => {
    // 							lightbox.close();
    // 							lightbox.reload();
    // 						});
    // 				}, 200);
    // 			});
    // 		});

    // 		document.querySelectorAll(".gslide-image img").forEach((item) => {
    // 			item.addEventListener("click", () => {
    // 				lightbox.close();
    // 				lightbox.reload();
    // 			});
    // 		});
    // 	});

    // 	if (window.screen.width < 1040) {
    // 		lightbox.settings.closeButton = true;
    // 		lightbox.settings.zoomable = true;
    // 	}
    // }

    const userScreenHeight = window.screen.height;
    const backToTopButton = document.querySelector(".back-to-top-btn");
    if (window.scrollY > userScreenHeight) {
        backToTopButton.classList.add("back-to-top-btn--active");
    }
    document.addEventListener("scroll", (e) => {
        if (window.scrollY > userScreenHeight) {
            backToTopButton.classList.add("back-to-top-btn--active");
        } else {
            backToTopButton.classList.remove("back-to-top-btn--active");
        }
    });
    backToTopButton.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
        backToTopButton.classList.remove("back-to-top-btn--active");
    });

    if (window.screen.width < 1040) {
        let oldScrollTopPosition = 0;
        document.addEventListener("scroll", () => {
            const scrollTopPosition = document.documentElement.scrollTop;
            if (oldScrollTopPosition > scrollTopPosition) {
                document.querySelector(".header").classList.add("fixed");
            } else {
                document.querySelector(".header").classList.remove("fixed");
            }
            if (scrollTopPosition === 0) {
                document.querySelector(".header").classList.remove("fixed");
            }
            oldScrollTopPosition = scrollTopPosition;
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

    const phoneInput = document.querySelectorAll("#phone");
    let im = new Inputmask("+375 (99) 999-99-99");
    if (phoneInput) {
        phoneInput.forEach(function(input) {
            let itl = intlTelInput(input, {
                onlyCountries: ["au", "at", "az", "al", "by", "dz", "ao", "ar", "am", "aw", "bd", "bh", "be", "bj", "bg", "bo", "ba", "bw", "br", "bf", "bi", "va", "gb", "hu", "vn", "ht", "gy", "gh", "de", "hk", "gr", "ge", "dk", "do", "eg", "zm", "zw", "il", "in", "jo", "id", "ir", "ie", "is", "es", "it", "kz", "cm", "ca", "qa", "ke", "cy", "cn", "co", "km", "cd", "kr", "cr", "cu", "kw", "kg", "cw", "lv", "ls", "lr", "lb", "lt", "lu", "mr", "mu", "mg", "mk", "mw", "my", "ml", "mv", "mt", "ma", "mx", "mz", "md", "mc", "np", "nl", "an", "nz", "no", "ae", "om", "pk", "pa", "pe", "pl", "pt", "ru", "rw", "ro", "sv", "sc", "sn", "rs", "sg", "sk", "si", "sr", "sl", "us", "tj", "th", "tw", "tc", "tg", "tt", "tn", "tm", "tr", "uz", "uy", "ph", "fr", "pf", "hr", "td", "me", "cz", "cl", "ch", "se", "lk", "ec", "er", "sz", "ee", "et", "za", "jm", "jp"],
                initialCountry: "by", // "auto",
                geoIpLookup: callback => {
                    fetch("https://ipapi.co/json")
                        .then(res => res.json())
                        .then(data => callback(data.country_code))
                        .catch(() => callback("us"));
                },
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
            });
            im.mask(input);
            input.addEventListener("countrychange", function() {
                let country = itl.getSelectedCountryData();
                Inputmask(masksList[country.iso2]).mask(input);
            });
            input.addEventListener("open:countrydropdown", (e) => {
                const phoneInputRect = e.target.getBoundingClientRect();
                const mobileContainer = document.querySelector(".iti.iti--container");
                if (mobileContainer) {
                    mobileContainer.style.top = `${phoneInputRect.bottom}px`;
                    mobileContainer.style.left = `calc(${phoneInputRect.right}px - 280px)`;
                }
            });
        });
    }

    if (document.querySelector("#onBackorderForm")) {
        const validate = new window.JustValidate("#onBackorderForm");
        const formButton = validate.form.querySelector(".popup-form__btn");
        validate
            .addField("#name", [{
                rule: "required",
                validateBeforeSubmitting: true,
            }, ])
            .addField("#phone", [{
                    rule: "required",
                    validateBeforeSubmitting: true,
                },
                {
                    validator: (name, value) => {
                        const phone = validate.form.querySelector("#phone").inputmask.unmaskedvalue();
                        return Number(phone) && phone.length === 9;
                    },
                },
            ]);
        validate.onValidate(() => {
            if (Object.values(validate.fields).every((v) => v.isValid === true)) {
                formButton.disabled = false;
            } else {
                formButton.disabled = true;
            }
        });
    }

    if (document.querySelector(".popup-form")) {
        const validate = new window.JustValidate(".popup-form");
        const formButton = validate.form.querySelector(".popup-form__btn");
        validate
            .addField("#name", [{
                rule: "required",
                validateBeforeSubmitting: true,
            }, ])
            .addField("#phone", [{
                    rule: "required",
                    validateBeforeSubmitting: true,
                },
                {
                    validator: (name, value) => {
                        const phone = validate.form.querySelector("#phone").inputmask.unmaskedvalue();
                        return Number(phone) && phone.length === 9;
                    },
                },
            ]);
        validate.onValidate(() => {
            if (Object.values(validate.fields).every((v) => v.isValid === true)) {
                formButton.disabled = false;
            } else {
                formButton.disabled = true;
            }
        });
    }

    const telInput = document.querySelector("#tel");
    // const telInputCheckout = document.querySelector("#billing_phone");
    let imTel = new Inputmask("+375 (99) 999-99-99");
    if (telInput) {
        let itl = intlTelInput(telInput, {
            customContainer: "iti-custom",
            onlyCountries: ["au", "at", "az", "al", "by", "dz", "ao", "ar", "am", "aw", "bd", "bh", "be", "bj", "bg", "bo", "ba", "bw", "br", "bf", "bi", "va", "gb", "hu", "vn", "ht", "gy", "gh", "de", "hk", "gr", "ge", "dk", "do", "eg", "zm", "zw", "il", "in", "jo", "id", "ir", "ie", "is", "es", "it", "kz", "cm", "ca", "qa", "ke", "cy", "cn", "co", "km", "cd", "kr", "cr", "cu", "kw", "kg", "cw", "lv", "ls", "lr", "lb", "lt", "lu", "mr", "mu", "mg", "mk", "mw", "my", "ml", "mv", "mt", "ma", "mx", "mz", "md", "mc", "np", "nl", "an", "nz", "no", "ae", "om", "pk", "pa", "pe", "pl", "pt", "ru", "rw", "ro", "sv", "sc", "sn", "rs", "sg", "sk", "si", "sr", "sl", "us", "tj", "th", "tw", "tc", "tg", "tt", "tn", "tm", "tr", "uz", "uy", "ph", "fr", "pf", "hr", "td", "me", "cz", "cl", "ch", "se", "lk", "ec", "er", "sz", "ee", "et", "za", "jm", "jp"],
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
        });
        imTel.mask(telInput);
        telInput.addEventListener("countrychange", () => {
            let country = itl.getSelectedCountryData();
            Inputmask(masksList[country.iso2]).mask(telInput);
        });
        telInput.addEventListener("open:countrydropdown", (e) => {
            const telInputRect = e.target.getBoundingClientRect();
            const mobileContainer = document.querySelector(".iti.iti--container");
            if (mobileContainer) {
                mobileContainer.style.top = `${telInputRect.bottom}px`;
                mobileContainer.style.left = `calc(${telInputRect.right}px - 280px)`;
            }
        });
    }


    var timeoutSearchAjax;
    const searchInputAjax = document.querySelector('.search__inp');
    const searchResultAjax = document.querySelector('.search__results');
    const search__allBtn = document.querySelector('.search__all-btn');
    search__allBtn.disabled = true;
    searchInputAjax.addEventListener('keyup', function() {
        if (timeoutSearchAjax) {
            clearTimeout(timeoutSearchAjax);
        }
        search__allBtn.disabled = true;
        searchResultAjax.innerHTML = '<div class="cart_preloader"><svg viewBox="25 25 50 50"><circle r="20" cy="50" cx="50"></circle></svg></div>';

        timeoutSearchAjax = setTimeout(function() {
            var searchQuery = searchInputAjax.value;

            if (searchQuery !== '') {
                jQuery.ajax({
                    type: 'POST',
                    url: '/wp-admin/admin-ajax.php',
                    data: {
                        action: 'product_search_ajax',
                        search_query: searchQuery
                    },
                    success: function(response) {
                        searchResultAjax.innerHTML = response;
                        if (response !== 'Ничего не найдено.') {
                            const newUrl = `/?s=` + searchInputAjax.value;
                            search__allBtn.disabled = false;

                            search__allBtn.addEventListener('click', function() {
                                window.location.href = newUrl;
                            });
                        }
                    }
                });
            } else {
                searchResultAjax.innerHTML = '';
            }

        }, 800);
    })


})();