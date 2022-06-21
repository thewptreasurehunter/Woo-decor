<?php 

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    

        // To change add to cart text on single product page
        add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
        function woocommerce_custom_single_add_to_cart_text() {
        $singleshop = get_option( 'woodecor_options1' );
            if(!empty($singleshop)){
                return _e( $singleshop , 'woodecor' ); 
            }
            else{
                return __( 'Add To cart' , 'woodecor' ); 
            }
            
        }


        // To change add to cart text on product archives(Collection) page

        add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
        function woocommerce_custom_product_add_to_cart_text() {
            $archiveshop = get_option( 'woodecor_options1' );
            $outofstockbtn = get_option( 'woodecor_options2' );
          global $product;       
           if ( $product && ! $product->is_in_stock() ) {           
              return __(  $outofstockbtn, 'woodecor' );
           } 
           else{


                return __( $archiveshopbtn = !empty($archiveshop) ? $archiveshop : 'Add to cart' , 'woodecor' );
           }



        }
//stickyt

add_filter('woocommerce_after_single_product','my_func');
function my_func(){
        global $woocommerce;
        global $post;
        if ( ! is_singular( 'product' ) ) {
            return;
        }
        else{

                   //get woocommerce object according to specific product
            $product_details = new WC_Product( $post->ID );
            // $class = $options['fix_postion'];
        ?>
            <!-- Main Container of stick bar -->
                <div class="woodecor-sticky-cart">
                    <?php echo $product_details->get_name(); ?>
                                                    <div class="mg-wsac-col mg-wsac-container mg-wsac-center center-blck padding">
                                <?php $currency_symb = get_woocommerce_currency_symbol(get_woocommerce_currency()) //get currency then convert to symbol ; ?>
                                <?php if( !empty($product_details->get_sale_price())) : // check for sale price ?>
                                <strike class="stky-strike">
                                    <span class="stky-reglr-price">
                                        <?php echo $currency_symb.number_format($product_details->get_regular_price(),2)?>
                                    </span>

                                </strike>
                                &nbsp;
                                <span class="mg-wsac-badge">
                                    <?php echo $currency_symb.number_format($product_details->get_sale_price(),2)?>

                                </span>
                                <?php else: ?>
                                <span class="mg-wsac-badge">
                                    <?php echo $currency_symb.number_format($product_details->get_regular_price(),2); ?>
                                </span>     
                                <?php endif ; ?>
                            </div>
                                                    <!-- Fourth section or add to cart section  -->
                        <div class="col-width mg-wsac-container mg-wsac-center padding"  >
                            <div class="mg-wsac-row  height" >
                                <div class="mg-wsac-col mg-wsac-container mg-wsac-center center-blck stky-cart-section">
                                    <?php if( $product_details->is_in_stock() ) : 
                                        $shop_page_url = get_site_url();
                                    $_product = wc_get_product( $post->ID );
                                        if( $_product->is_type( 'simple' ) ) 
                                            $product_class = 'simple-product'; 
                                        else
                                            $product_class = 'variable-product'; 
                                    ?>
                                    <a href="<?php echo $shop_page_url; ?>/shop/?add-to-cart=<?php echo $post->ID?>" class="woodecor-button <?php echo $product_class; ?>  cart-text">

                                    <?php if( $product_class == 'variable-product' ) : ?>
                                        <?php echo _e('add to cart' , 'wsac'); ?></a>
                                    <?php else : ?>
                                        <?php echo _e('add cart' , 'wsac'); ?></a>
                                    <?php endif; ?>
        
                                      <?php else : ?>
                                      <p class="mg-wsac-out-of-stock ">
                                        <?php echo _e('Out Of Stock' , 'wsac' ) ; ?>
                                      </p>
                                    <?php endif ; ?>
                                </div>
                            </div>
                        </div>
                        <!-- End of fourth section or add to cart button  -->

                </div>
                <!-- end of main container  -->
            <?php

        }

 
            
        }
    


}



?>