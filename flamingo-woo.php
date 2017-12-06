<?php
/**
 * Functions.php
 *
 * @package  Theme_Customisations
 * @author   WooThemes
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * functions.php
 * Add PHP snippets here
 */
 
// Adding Meta container admin shop_order pages
add_action( 'add_meta_boxes', 'mv_add_meta_boxes' );
if ( ! function_exists( 'mv_add_meta_boxes' ) )
{
    function mv_add_meta_boxes()
    {
        add_meta_box( 'mv_other_fields', __('My Field','woocommerce'), 'mv_add_other_fields_for_packaging', 'shop_order', 'side', 'core' );
    }
}

// Adding Meta field in the meta container admin shop_order pages
if ( ! function_exists( 'mv_add_other_fields_for_packaging' ) )
{
    function mv_add_other_fields_for_packaging()
    {
        $lastContact = new Flamingo_Inbound_Message(46);

		flamingo_inbound_fields_meta_box($lastContact);
    }
}

function flamingo_inbound_fields_meta_box( $post ) {
?>
<table class="widefat message-fields striped">
<tbody>

<?php foreach ( (array) $post->fields as $key => $value ) : ?>
<tr>
<td class="field-title"><?php echo esc_html( $key ); ?></td>
<td class="field-value"><?php echo flamingo_htmlize( $value ); ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
<?php
}
