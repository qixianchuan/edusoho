define(function(require, exports, module) {

  var Validator = require('bootstrap.validator');
  require('common/validator-rules').inject(Validator);

  exports.run = function() {
    var $form = $('#order-adjust-form');

    var validator = new Validator({
      element: $form,
      autoSubmit: false,
      autoFocus: false,
      onFormValidated: function(error, results, $form) {
        if (error) {
          return ;
        }

        $.post($form.action, {adjustPrice:$form.find('.js-adjust-price').val()}, function(resp) {
          "use strict";



        });

        $('#refund-confirm-btn').button('submiting').addClass('disabled');
      }
    });

    validator.getExplain = function (ele) {
      return $('.js-display-error ');
    };

    validator.addItem({
      element: 'input[name=adjust-by-price]',
      required: false,
      rule: 'decimal'
    });

    validator.addItem({
      element: 'input[name=adjust-by-discount]',
      required: false,
      rule: 'decimal max{max: 10}',
      display: '折扣'
    });

    var originPayAmount = $form.find('.js-pay-amount').data('originAmount');
    $form.on('change', '.js-adjust-price', function () {
      $el = $(this);
      var adjustPrice = $el.val();
      if ($.isNumeric(adjustPrice)) {
        var discount = (parseFloat(adjustPrice))*10/parseFloat(originPayAmount).toFixed(1);
        $form.find('.js-adjust-discount').val(discount);
      }

    });

    $form.on('change', '.js-adjust-discount', function () {
      $el = $(this);
      var discount = $el.val();
      if ($.isNumeric(discount)) {
        var adjustPrice = (discount * originPayAmount / 10).toFixed(1);
        $form.find('.js-adjust-price').val(adjustPrice);
      }

    });

  };

});