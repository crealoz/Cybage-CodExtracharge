/* Copyright (c) 1995-2019 Cybage Software Pvt. Ltd., India * http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx */
define(
    [
        'ko',
        'jquery',
        'mage/storage',
        'Magento_Checkout/js/view/payment/default',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/action/get-totals',
        'Magento_Checkout/js/model/url-builder',
        'mage/url',
        'Magento_Checkout/js/model/full-screen-loader',
        'Cybage_CodExtracharge/js/view/checkout/cashondelivery',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/model/totals'
    ],
    function (ko, $, storage, Component, quote, getTotalsAction, urlBuilder, mageUrlBuilder, fullScreenLoader, cashondelivery, customer, totals) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Cybage_CodExtracharge/payment/cashondelivery-form'
            },
            lastDetectedMethod: null,
            extraFeeText: ko.observable(''),
            refreshMethod: function () {
                var serviceUrl;
                var paymentData = quote.paymentMethod();

                paymentData = JSON.parse(JSON.stringify(paymentData));
                delete paymentData['title'];

                fullScreenLoader.startLoader();
                
                if (customer.isLoggedIn()) {
                    serviceUrl = urlBuilder.createUrl('/carts/mine/selected-payment-method', {});
                } else {
                    serviceUrl = urlBuilder.createUrl('/guest-carts/:cartId/selected-payment-method', {
                        cartId: quote.getQuoteId()
                    });
                }

                var payload = {
                    cartId: quote.getQuoteId(),
                    method: paymentData
                };

                return storage.put(
                    serviceUrl,
                    JSON.stringify(payload)
                ).done(function () {
                    cashondelivery.canShowCashOnDelivery(quote.paymentMethod().method == 'cashondelivery');
                    getTotalsAction([]);
                    
                    fullScreenLoader.stopLoader();
                });
            },
            initObservable: function () {
                this._super();
                var me = this;
                var serviceUrl = urlBuilder.createUrl(window.checkoutConfig.cybCodInfo, {});
                storage.get(
                    serviceUrl
                ).done(function (data) {
                    
                    me.extraFeeText(data.fee_label);
                });

                quote.paymentMethod.subscribe(function () {
                    if (quote.paymentMethod().method !== me.lastDetectedMethod) {
                        if (
                            (quote.paymentMethod().method === window.checkoutConfig.cybPaymentMethod) ||
                            (me.lastDetectedMethod === window.checkoutConfig.cybPaymentMethod) ||
                            (totals.getSegment('cyb_codextracharge') && (me.lastDetectedMethod === null))
                        ) {
                            me.refreshMethod();
                        }
                        me.lastDetectedMethod = quote.paymentMethod().method;
                    }
                });
                return this;
            }
        });
    }
);
