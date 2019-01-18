/* Copyright (c) 1995-2019 Cybage Software Pvt. Ltd., India * http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx */
define(
    [
        'ko',
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Catalog/js/price-utils',
        'Magento_Checkout/js/model/totals'
    ],
    function (ko, $, Component, quote, priceUtils, totals) {
        "use strict";
        return Component.extend({
            defaults: {
                isFullTaxSummaryDisplayed: window.checkoutConfig.isFullTaxSummaryDisplayed || false,
                template: 'Cybage_CodExtracharge/checkout/summary/cashondelivery'
            },
            totals: quote.getTotals(),
            isTaxDisplayedInGrandTotal: window.checkoutConfig.includeTaxInGrandTotal || false,
            isDisplayed: function () {
                return this.isFullMode();
            },
            hasTotal: function () {
                if (this.totals()) {
                    return !!totals.getSegment('cyb_codextracharge');
                }
                return false;
            },
            getValue: function () {
                var price = 0;
                if (this.hasTotal()) {
                    price = totals.getSegment('cyb_codextracharge').value;
                }
                return this.getFormattedPrice(price);
            },
            getBaseValue: function () {
                var price = 0;
                if (this.hasTotal()) {
                    price = totals.getSegment('cyb_codextracharge').value;
                }
                return this.getFormattedPrice(price);
            },
            shouldDisplay: function () {
                var price = 0;
                if (this.hasTotal()) {
                    price = totals.getSegment('cyb_codextracharge').value;
                }
                return price;
            },
            getLabel: function() {
                var cybcodlabel = window.checkoutConfig.cybcodlabel;
                var price = 0;
                if (this.hasTotal()) {
                   price = this.getFormattedPrice(totals.getSegment('cyb_codextracharge').value);
                   $('.cyb-cashondelivery-payment-method-extrafee span.price').text(price);
               }
                return cybcodlabel;
            }
        });
    }
);