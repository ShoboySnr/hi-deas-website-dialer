(function ($) {
    "use strict";

    let hideasAdmin = {};

    hideasAdmin.toggle_display_as = (event) => {
        let display_as = event.target.value;

        if(display_as === 'text') {
            $('#hideasCallCentralPhoneTextSelection').show();
            $('#hideasCallCentralPhoneIconURLSelection').hide();
        } else {
            $('#hideasCallCentralPhoneTextSelection').hide();
            $('#hideasCallCentralPhoneIconURLSelection').show();
        }
    }

    hideasAdmin.init = () => {
        $("select[name*='hideasCallCenterDisplayAs']").change(hideasAdmin.toggle_display_as).change();
    }

    $(window).on('load', hideasAdmin.init);


})(jQuery);