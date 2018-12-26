/* Copyright (c) 1995-2017 Cybage Software Pvt. Ltd., India * http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx */
define(
    [
        'ko',
        'Cybage_CodExtracharge/js/view/checkout/summary/cashondelivery',
        'Cybage_CodExtracharge/js/view/checkout/cashondelivery'
    ],
    function (ko, Component, cashondelivery) {
        'use strict';

        return Component.extend({
            isDisplayed: function () {
                return this.isFullMode();
            }
        });
    }
);