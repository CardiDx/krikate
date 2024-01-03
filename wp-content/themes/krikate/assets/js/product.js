document.addEventListener('DOMContentLoaded', function() {
    initGallerySwiper();
    setupCustomLightbox();
    stock_check();

    var productId = document.getElementById('product-id');
    if (productId) {
        var productId = productId.value;

        var colorBlock = document.querySelectorAll('.product__color-item');
        var sizeBlock = document.querySelectorAll('.size-btn');
        var galleryBlock = document.querySelector('.product__gallery');

        var oneClickBuy = document.querySelector('.popup-form__product');

        updatePrice();
        updateSize();
        updateColor();
        updateImage();

        colorBlock.forEach(function(color) {
            color.addEventListener('click', function() {
                var key = color.getAttribute('data-product-color');
                document.querySelector('.product__size-list.selected-variation-color').classList.remove('selected-variation-color');
                let new_size = '.product__size-list[data-product-color="' + key + '"]';
                var new_size_block = document.querySelector(new_size);
                new_size_block.classList.add('selected-variation-color');
                document.querySelector('.size-btn.size-btn--selected').classList.remove('size-btn--selected');
                new_size_block.querySelector('.size-btn').classList.add("size-btn--selected");
                updatePrice();
                updateSize();
                updateColor();
                stock_check();

                var loadingAnimation = '<div class="product-loader"><div class="three-body"><div class="three-body__dot"></div><div class="three-body__dot"></div><div class="three-body__dot"></div></div></div>';
                galleryBlock.innerHTML = loadingAnimation;


                jQuery.ajax({
                    type: 'POST',
                    url: '/wp-admin/admin-ajax.php',
                    data: {
                        action: 'my_ajax_view_product_image',
                        key: key,
                        product_id: productId
                    },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (response) {
                            loadingAnimation.innerHTML = '';
                            if (typeof gallerySwiper !== 'undefined' && gallerySwiper.destroy) {
                                gallerySwiper.destroy(true, true);
                            }

                            galleryBlock.innerHTML = result;

                            initGallerySwiper();
                            setupCustomLightbox();
                            updateImage();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });


        sizeBlock.forEach(function(color) {
            color.addEventListener('click', function() {
                updatePrice();
                updateSize();
                stock_check();
            });
        });

    }

    function updatePrice() {
        document.querySelector('.product__price.selected-variation').classList.remove('selected-variation');
        let variationId = document.querySelector('.size-btn.size-btn--selected').getAttribute('data-variation');
        let newVar = '.product__price[data-variation="' + variationId + '"]';
        var newPriceItem = document.querySelector(newVar);
        newPriceItem.classList.add('selected-variation');

        oneClickBuy.querySelector('.cart-item__price').innerHTML = newPriceItem.querySelector('.product__price.selected-variation .product__price-current').textContent;
        if (newPriceItem.querySelector('.product__price.selected-variation .product__price-discount')) {
            oneClickBuy.querySelector('.cart-item__discount').innerHTML = newPriceItem.querySelector('.product__price.selected-variation .product__price-discount').textContent;
            oneClickBuy.querySelector('.cart-item__old').innerHTML = newPriceItem.querySelector('.product__price.selected-variation .product__price-old').textContent;
        } else {
            oneClickBuy.querySelector('.cart-item__discount').innerHTML = '';
            oneClickBuy.querySelector('.cart-item__old').innerHTML = '';
        }
    }

    function updateSize() {
        let sizeName = document.querySelector('.size-btn.size-btn--selected').textContent;
        oneClickBuy.querySelector('.cart-item__size').innerHTML = sizeName;
    }

    function updateColor() {
        let colorName = document.querySelector('.product__color-value').textContent;
        oneClickBuy.querySelector('.cart-item__color').innerHTML = colorName;
    }

    function updateImage() {
        oneClickBuy.querySelector('.cart-item__picture').innerHTML = '';
        var originalImage = galleryBlock.querySelector('img');
        var clonedImage = originalImage.cloneNode(true);
        var targetElement = oneClickBuy.querySelector('.cart-item__picture');
        targetElement.appendChild(clonedImage);
    }


});

function initGallerySwiper() {
    const galllerySwiper = new Swiper(".gallery-slider", {
        loop: true,
        spaceBetween: 0,
        breakpoints: {
            541: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
        },
    });

}

function setupCustomLightbox() {
    if (document.querySelector(".glightbox")) {
        const gallerySlides = document.querySelectorAll(".gallery-slider__item");
        const slideArr = [];
        gallerySlides.forEach((item) => {
            const index = item.getAttribute("data-swiper-slide-index");
            const smImg = item.querySelector("img");
            slideArr.push({ index: index, small: smImg.src });
        });

        const customLightboxHTML = `<div id="glightbox-body" class="glightbox-container">
	    <div class="gloader visible"></div>
	    <div class="goverlay"></div>
	    <div class="gcontainer">
	    <div id="glightbox-slider" class="gslider">
            <div class="mini-gallery swiper">
                <div class="mini-gallery__wrapper swiper-wrapper">
                    ${slideArr
                        .map(
                            (item) => `<div class="mini-gallery__item swiper-slide" data-swiper-slide-index="${item.index}">
                    <img src="${item.small}">
                </div>`
                        )
                        .join("")}
                </div>
            </div>
        </div>
	    <button style="display:none;" class="gnext gbtn" tabindex="0" aria-label="Next" data-customattribute="example">{nextSVG}</button>
	    <button style="display:none;" class="gprev gbtn" tabindex="1" aria-label="Previous">{prevSVG}</button>
	    <button style="display:none;" class="gclose gbtn" tabindex="2" aria-label="Close">{closeSVG}</button>
	</div>
	</div>`;

        const lightbox = GLightbox({
            selector: ".glightbox",
            lightboxHTML: customLightboxHTML,
            openEffect: "zoom",
            slideEffect: "zoom",
            closeButton: false,
            draggable: false,
            zoomable: false,
        });

        lightbox.on("open", () => {
            window.scrollTo({
                top: 0,
            });

            const minGalllerySwiper = new Swiper(".mini-gallery", {
                loop: true,
                slidesPerView: 6,
                spaceBetween: 5,
                direction: "vertical",
            });

            document.querySelectorAll(".mini-gallery__item").forEach((slide) => {
                slide.addEventListener("mouseover", (e) => {
                    const index = slide.getAttribute("data-swiper-slide-index");
                    lightbox.goToSlide(index);
                    setTimeout(() => {
                        document
                            .querySelector(".gslide.current .gslide-image img")
                            .addEventListener("click", () => {
                                lightbox.close();
                                lightbox.reload();
                            });
                    }, 200);
                });
            });

            document.querySelectorAll(".gslide-image img").forEach((item) => {
                item.addEventListener("click", () => {
                    lightbox.close();
                    lightbox.reload();
                });
            });
        });

        if (window.screen.width < 1040) {
            lightbox.settings.closeButton = true;
            lightbox.settings.zoomable = true;
        }
    }
}

function stock_check() {
    if (document.querySelector('.size-btn.size-btn--selected')) {
        var variation_stock = document.querySelector('.size-btn.size-btn--selected').getAttribute('data-variation-stock');
        if (variation_stock == 'onbackorder' || variation_stock == 'outofstock') {
            document.querySelector('.product__content .add-to-cart').classList.add("hidden");
            document.querySelector('.product__content .product_onbackorder_block').classList.remove("hidden");
        } else {
            document.querySelector('.product__content .add-to-cart').classList.remove("hidden");
            document.querySelector('.product__content .product_onbackorder_block').classList.add("hidden");
        }
    }
}