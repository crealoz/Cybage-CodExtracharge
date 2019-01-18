/** * Copyright (c) 1995-2019 Cybage Software Pvt. Ltd., India * http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx */

define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function($) {
    'use strict';
 
    return function (optionsConfig) {
        var rulesData = $('<div/>').html(optionsConfig.html).modal({
            modalClass: 'rules',
            title: $.mage.__('Configured rules'),
            buttons: [{
                text: 'Ok',
                click: function () {
                    this.closeModal();
                }
            }]
        });
        $('#custom-rules').on('click', function() {
            rulesData.modal('openModal');
        });
    };
});