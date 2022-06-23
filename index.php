<?php 
/*
Plugin Name: Woo decor
Plugin URI : thewptreasurehunter.com
Description:  WooCommerce add to cart button make editable
Version:1.0
Author: thewptreasurehunter
Author URI : thewptreasurehunter.com
License : GPL v or later
Text Domain: woodecor
Domain Path : /languages/
WC requires at least: 4.2.0
WC tested up to: 6.1.1
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

 // * custom option and settings
 // */

function wttwoodecor_settings_init() {
    // Register a new setting for "woodecor" page.
    register_setting( 'woodecor', 'woodecor_options1' );
    register_setting( 'woodecor', 'woodecor_options2' );
    register_setting( 'woodecor', 'woodecor_options3' );
 
    // Register a new section in the "woodecor" page.
    add_settings_section(
        'woodecor_section_developers',
        __( 'Here set your settings', 'woodecor' ), 'woodecor_section_developers_callback',
        'woodecor'
    );
 
    // Register a new field in the "woodecor_section_developers" section, inside the "woodecor" page.
    add_settings_field(
        'woodecor_field_cart', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Add to Cart Button Text', 'woodecor' ),
        'woodecor_field_cart_cb',
        'woodecor',
        'woodecor_section_developers');

        add_settings_field('woodecor_field_readmore', __( 'Out of Stock Button Text', 'woodecor' ),

        'woodecor_field_readmore_cb',
        'woodecor',
        'woodecor_section_developers');

        add_settings_field('woodecor_sticky_cart', __( 'Sticky Cart enable', 'woodecor' ),
            
        'woodecor_sticky_cart_cb',
        'woodecor',
        'woodecor_section_developers');

}
 
/**
 * Register our woodecor_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'wttwoodecor_settings_init' );
 
 
/**
 * Custom option and settings:
 *  - callback functions
 */
 
 
/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */

function woodecor_section_developers_callback( $args ) {
   if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) { ?>
        <div id="message" class="error">
        <p>Woo Decor Add To Cart requires <a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a> to be activated in order to work. Please install and activate <a href="<?php echo admin_url('/plugin-install.php?tab=search&amp;type=term&amp;s=WooCommerce'); ?>" target="">WooCommerce</a> first.</p>
      </div>
      <?php deactivate_plugins( '/woo-decor/index.php' );
    }

   
}
 
/**
 * Pill field callbakc function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args
 */
function woodecor_field_cart_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'woodecor_options1' );
    ?>
   
      <span class="toltip-section">
        
          <span class="tooltiptext">Set Add to cart Button Text</span>
       
    </span>
    <input id='woodecor_field_cart' placeholder="Add To Cart" name='woodecor_options1' type='text' value="<?php echo esc_html($options);?>" />
    <p class="description">
       
        <?php esc_html_e( 'here set your text.', 'woodecor' ); ?>
    </p>
  
    <?php
}
function woodecor_field_readmore_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'woodecor_options2' );
    ?>
    <span class="toltip-section">
        
          <span class="tooltiptext">Set Out of Stock Button Text</span>
       
    </span>
  
    <input id='woodecor_field_readmore' placeholder="Read More" name='woodecor_options2' type='text' value="<?php echo esc_html($options);?>" />
    <p class="description">
         
        <?php esc_html_e( 'here set your text.', 'woodecor' ); ?>
    </p>
   

         
  
    <?php
}
 
 function woodecor_sticky_cart_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'woodecor_options3' );
    // Get the value of this option.
$checked = $options;
 
// The value to compare with (the value of the checkbox below).
$current = 1; 
 
// True by default, just here to make things clear.
$echo = true;
 
?>

    <span class="toltip-section">
        
          <span class="tooltiptext">Check this to enable sticky</span>
       
    </span>
  

    <input type="checkbox" id="woodecor_sticky_cart" name="woodecor_options3" value="1" <?php checked( $checked, $current, $echo ); ?>/>
    <p class="description">
         
        <?php esc_html_e( 'Check this to enable.', 'woodecor' ); ?>
    </p>
   

         
  
    <?php
}
/**
 * Add the top level menu page.
 */


function woodecor_options_page() {
    add_menu_page(
        'WooDecor Option Page',
        'WooDecor',
        'manage_options',
        'woodecor',
        'woodecor_options_page_html'
    );
}
 
 
/**
 * Register our woodecor_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'woodecor_options_page' );
 
 
/**
 * Top level menu callback function
 */
function woodecor_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
 
    // add error/update messages
 
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'woodecor_messages', 'woodecor_message', __( 'Settings Saved', 'woodecor' ), 'updated' );
    }
 
    // show error/update messages
    settings_errors( 'woodecor_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "woodecor"
            settings_fields( 'woodecor' );
            // output setting sections and their fields
            // (sections are registered for "woodecor", each field is registered to a specific section)
            do_settings_sections( 'woodecor' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

function woodecor_enqueue_scripts() {
 
    wp_register_style( 'woodecor-stylesheet',  plugin_dir_url( __FILE__ ) . 'assets/css/wtt-style.css' );
        wp_enqueue_style( 'woodecor-stylesheet' );



   }
   add_action( 'admin_enqueue_scripts', 'woodecor_enqueue_scripts');
function woodecor_enqueue_front_scripts() {
 
    wp_register_style( 'woodecor-front-stylesheet',  plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
        wp_enqueue_style( 'woodecor-front-stylesheet' );



   }
   add_action( 'wp_enqueue_scripts', 'woodecor_enqueue_front_scripts');
require_once('function.php');
