jQuery(document).ready(function() {
    if (document.documentElement.clientWidth < 1040) {
        jQuery('.menu-main-menu-container').prepend('<div class="mobile-menu-headline justify-content-between d-flex"><div><strong>Меню</strong></div><div class="close-menu"><i class="las la-times"></i></div></div>');
        jQuery('.menu-main-menu-container .menu-item-has-children>a').append('<img class="open-child" src="/wp-content/themes/krikate/assets/img/arrow-down.svg">');
    }

    jQuery('.mobile-menu-btn').on('click', function() {
        jQuery('.menu-main-menu-container').addClass('show-modal-menu');
        jQuery('body').addClass('open-modal');
    });
    jQuery('.close-menu').on('click', function() {
        jQuery('.menu-main-menu-container').removeClass('show-modal-menu');
        jQuery('body').removeClass('open-modal');
    });
    jQuery('.menu-main-menu-container .open-child').on('click', function(e) {
        e.preventDefault();
        var parent_menu_item = jQuery(this).parent('a').parent('.menu-item-has-children');
        if (jQuery(parent_menu_item).hasClass('show')) {
            jQuery(parent_menu_item).find('.show').removeClass('show');
        }
        jQuery(parent_menu_item).toggleClass('show');
    });
    $('.open-filter-btn').on('click', function() {
        $('.category-filter-form').toggle();
    });
});