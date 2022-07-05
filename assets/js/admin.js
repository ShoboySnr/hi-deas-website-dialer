(function ($) {
    "use strict";

    let hideasAdmin = {};

    hideasAdmin.toggle_display_as = (event) => {
        let display_as = event.target.value;

        if(display_as === 'text') {
            $('#HiDeasWebsiteDialerPhoneTextSelection').show();
            $('#HiDeasWebsiteDialerPhoneIconURLSelection').hide();
        } else {
            $('#HiDeasWebsiteDialerPhoneTextSelection').hide();
            $('#HiDeasWebsiteDialerPhoneIconURLSelection').show();
        }
    }

    hideasAdmin.init = () => {
        $("select[name*='HiDeasWebsiteDialerDisplayAs']").change(hideasAdmin.toggle_display_as).change();
    }

    $(window).on('load', hideasAdmin.init);


})(jQuery);