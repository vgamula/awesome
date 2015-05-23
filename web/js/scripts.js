jQuery(function () {
    jQuery('[rel="fancybox"]').fancybox();
    jQuery('[data-zoom-image]').elevateZoom({zoomWindowPosition: 1, zoomWindowOffetx: 10});

    var cart = jQuery('#cart'),
        updateCart = function (data) {
            var block = cart.find('.cart-block');
            block.fadeIn();
            cart.find('.cost').text(data.cost);
            cart.find('.count').text(data.count);
            setTimeout(function () {
                block.fadeOut();
            }, 2500);
        };

    jQuery('a.btn-buy').off('click').click(function (e) {
        var element = jQuery(this),
            amount = parseInt(element.parents('.order-form').find('[name="amount"]').val());
        element.find('i').addClass('fa-spinner fa-spin');
        element.find('i').removeClass('fa-shopping-cart');
        e.preventDefault(e);
        jQuery.ajax({
            url: element.attr('href').addUrlParam('amount', amount),
            success: function (data) {
                element.find('i').removeClass('fa-spinner fa-spin');
                element.find('i').addClass('fa-shopping-cart');
                updateCart(data);
            }
        });
    });
});

var plush = {};