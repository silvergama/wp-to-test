<?php /**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';

	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
		require 'inc/nux/class-storefront-nux-starter-content.php';
	}
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */


function bbloomer_wc_discount_total_30() {

    global $woocommerce;

    $discount_total = 10;

    foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values) {

        $_product = $values['data'];

        if ( $_product->is_on_sale() ) {
            $regular_price = $_product->get_regular_price();
            $sale_price = $_product->get_sale_price();
            $discount = ($regular_price - $sale_price) * $values['quantity'];
            $discount_total += $discount;
        }

    }

    if ( $discount_total > 0 ) {
         echo '<tr class="cart-discount">
         <th>'. __( 'You Saved', 'woocommerce' ) .'</th>
         <td data-title=" '. __( 'You Saved', 'woocommerce' ) .' ">'
         . wc_price( $discount_total + $woocommerce->cart->discount_cart ) .'</td>
         </tr>';
    }

}

// Hook our values to the Basket and Checkout pages

add_action( 'woocommerce_cart_totals_after_order_total', 'bbloomer_wc_discount_total_30', 99);
add_action( 'woocommerce_review_order_after_order_total', 'bbloomer_wc_discount_total_30', 99);

/**
 * Filtro para adicionar desconto de X% no boleto
 */
add_filter( 'woocommerce_pagseguro_payment_xml', 'sc50k_desconto_boleto', 20, 2 );
add_filter( 'woocommerce_pagseguro_checkout_xml', 'sc50k_desconto_boleto', 20, 2 );
function sc50k_desconto_boleto($xml, $order){

    var_dump($xml);
    exit;
	if ( $xml->method == 'boleto' ){
		$desconto = 5; // Depois dá para colocar dinâmico no admin via get_option()

		$total = $order->get_total();
		$discount = number_format( $total * ( $desconto / 100 ), 2, '.', ',' );
		$xml->add_extra_amount( '-'.$discount );

		$current_order_discount = $order->get_discount_total();
		$order->set_discount_total( $current_order_discount + $discount );

		$current_order_total = $order->get_total();
		$order->set_total( $current_order_total - $discount );

		$order->save();
	}

	return $xml;
}

function add_checkout_script() { ?>

    <script type="text/javascript">
        jQuery(document).on( "updated_checkout", function(){
            jQuery('#pagseguro-payment-methods').on('click', 'li', function(e){
                if (e.handled !== true) {
                    console.log(jQuery(this).text())
                }
            })
        });         
    </script>

<?php       
}
add_action( 'woocommerce_after_checkout_form', 'add_checkout_script', 80);


// $('#estado').on('change', function (e) {
// 			let estado = $(this).val();
// 			$('#cidade').html('');
// 			let data = {
// 				'action': 'buscaCidade',
// 				'uf': estado
// 			};
// 			jQuery.ajax({
// 				url: ajax_object.ajax_url,
// 				data: data,
// 				type: 'POST',
// 				dataType: 'json'
// 			}).done(function (response) {
// 				for (var i = 0; i < response.codigo.length; i++) {
// 					$('#cidade').removeAttr('disabled');
// 					$('#cidade').append('<option value="' + response.nome[i] + '" data-codigo="' + response.id[i] + '">' + response.nome[i] + '</option>');
// 				}
// 			});
// 		});

