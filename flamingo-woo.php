<?php
/*
Plugin Name:  Flamingo Woo
Plugin URI: https://placeholder.com/
Description: Display the latest contact message from Flamingo on WooCommerce order detail 
Author: Neo Wang
Author URI: https://placeholder.wordpress.com/
Text Domain: flamingo-woo
Domain Path: /languages/
Version: 0.01
License:     GPL2
 
Flamingo User is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Flamingo User is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Flamingo User. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html.

*/

// Adding Meta container admin shop_order pages
add_action( 'add_meta_boxes', 'flamingo_woo_add_meta_boxes' );
if ( ! function_exists( 'flamingo_woo_add_meta_boxes' ) )
{
    function flamingo_woo_add_meta_boxes()
    {
        add_meta_box( 'flamingo_woo_last_contact', __('Last Contact','woocommerce'), 'flamingo_woo_add_last_contact', 'shop_order', 'normal', 'core' );
    }
}

// Adding Meta field in the meta container admin shop_order pages
if ( ! function_exists( 'flamingo_woo_add_last_contact' ) )
{
    function flamingo_woo_add_last_contact()
    {
        $current_user = wp_get_current_user();
        $allCF7s = WPCF7_ContactForm::find(array('post_status'=>'publish'));
		
		global $post;

$order = new WC_Order($post->ID);

		
        foreach($allCF7s as $c) :
            echo $c->title;
            //$list = Flamingo_Inbound_Message::find(array('post_status'=>'publish','channel'=>$c->title));
            $list = Flamingo_Inbound_Message::find(array('post_status'=>'publish','meta_key'=>'post_author_email','meta_value'=>$order->get_user()->get('user_email'),'channel'=>$c->title));
            //$list = Flamingo_Inbound_Message::find(array('post_status'=>'publish','meta_key'=>'post_author_email','meta_value'=>$current_user->user_email,'channel_id'=>$c->id));
            foreach($list as $lastContact) :
     		    flamingo_woo_meta_box($lastContact);
            endforeach;
        endforeach;

    }
}

if ( ! function_exists( 'flamingo_woo_meta_box' ) )
{

function flamingo_woo_meta_box( $post ) {
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
}
