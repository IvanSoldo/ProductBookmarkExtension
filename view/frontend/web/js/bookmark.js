define([
    'jquery',
    'Magento_Customer/js/customer-data'
], function ($, customerData) {
    'use strict';

    let isLoggedIn = function () {
        let customer = customerData.get('customer')();
        if (customer.firstname) {
            return true;
        }
        return false;
    };

    return function (config, element) {
        if (isLoggedIn()) {
            jQuery.ajax({
                type: 'POST',
                url: '/inchoo_bookmark/block',
                dataType: 'text',
                success: function (result) {
                    element.innerHTML = result;
                    let productId = document.getElementById('product');
                    productId.value = config.product;
                }
            });
        }
    }
});
