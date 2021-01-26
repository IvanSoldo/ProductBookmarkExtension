define(['jquery'], function ($) {
    'use strict';

    return function (config, element) {
        $.get({
            url: '/inchoo_bookmark/block',
            success: function (result) {
                element.innerHTML = result;
                let productId = document.getElementById('product');
                productId.value = config.product;
            }
        });
    }
});
