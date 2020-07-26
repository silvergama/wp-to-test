jQuery(document).ready(function($) {
    // Code that uses jQuery's $ can follow here.
    jQuery("body").on(
        "click",
        "#pagseguro-payment-methods input[type=radio]",
        function() {
            let payment_method = jQuery(this).val();
            // console.log(type)
            let data = {
                action: "get_my_option",
                payment_method: payment_method
            };

            jQuery.ajax({
                type: "POST",
                url: ajax_object.ajax_url,
                dataType: "json",
                data: data,
                success: function(j) {
                    console.log(j);
                    jQuery(document.body).trigger("update_checkout");
                }
            });
        }
    );
});
