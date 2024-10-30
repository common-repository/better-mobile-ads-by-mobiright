(function ($) {
    'use strict';

    $(function () {
        var mobiright = $('#mobiright');

        mobiright.find('.nav-tab-wrapper a').on('click', function () {
            var tabs = $('.tab');
            tabs.hide();
            tabs.eq($(this).index()).show();
            $('.nav-tab').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');
            return false;
        });

        $("#mobiright-status").onoff();

        var form = $("#mobi-form");
        form.submit(function () {
            var fname = $.trim($('#fname').val());
            var lname = $.trim($('#lname').val());
            var email = $.trim($('#email').val());
            var paypal = $.trim($('#paypal').val());

            if (fname === '' || lname === '' || email === '' || paypal === '') {
                alert('Please fill in all form fields in both tabs.');
                return false;
            } else {
                mobiright.find('.spinner').addClass('is-active');
                mobiright.find('.save-btn').attr('disabled', true);
            }
        });

        form.areYouSure();


    });


})(jQuery);