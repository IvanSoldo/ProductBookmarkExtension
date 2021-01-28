define([
    'jquery',
    'Magento_Customer/js/customer-data'
], function ($, customerData) {
    'use strict';

    let isLoggedIn = function () {
        var customer = customerData.get('customer')();
        if (customer.fullname && customer.firstname)
        {
            return true;
        }
        return false;
    };

    return function (config, element) {

        if (isLoggedIn()) {
            $.get({
                url: '/inchoo_bookmark/block',
                success: function (result) {
                    element.innerHTML = result;
                    let productId = document.getElementById('product');
                    productId.value = config.product;
                }
            });
        }

    }
});
