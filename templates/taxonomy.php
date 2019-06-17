<?php
/**
 * This template displays the Product Category and Tag taxonomy term archives.
 *
 * @package Genesis_Connect_WooCommerce
 * @version 0.9.8
 * @since 0.9.0
 *
 * Note for customisers/users: Do not edit this file!
 * ==================================================
 * If you want to customise this template, copy this file (keep same name) and place the
 * copy in the child theme's woocommerce folder, ie themes/my-child-theme/woocommerce
 * (Your theme may not have a 'woocommerce' folder, in which case create one.)
 * The version in the child theme's woocommerce folder will override this template, and
 * any future updates to this plugin won't wipe out your customisations.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

remove_action( 'genesis_loop', 'genesis_do_loop' );
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description' );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_filter( 'woocommerce_show_page_title', '__return_false' );

add_filter( 'genesis_term_intro_text_output', 'genesiswooc_term_intro_text_output' );
/**
 * Fall back to the archive description if no intro text is set.
 *
 * @since 1.0.0
 *
 * @param string $intro_text The default Genesis archive intro text.
 *
 * @return string Archive intro text, or archive description if no intro text set.
 */
function genesiswooc_term_intro_text_output( $intro_text ) {

	$wp_archive_description = get_the_archive_description();

	if ( ! $intro_text && $wp_archive_description ) {
		return $wp_archive_description;
	}

	return $intro_text;

}

add_action( 'genesis_loop', 'genesiswooc_product_taxonomy_loop' );
/**
 * Displays shop items for the queried taxonomy term.
 *
 * This function has been refactored in 0.9.4 to provide compatibility with
 * both WooC 1.6.0 and backwards compatibility with older versions.
 * This is needed thanks to substantial changes to WooC template contents
 * introduced in WooC 1.6.0.
 *
 * @global $woocommerce $woocommerce The WooCommerce instance.
 *
 * @uses genesiswooc_content_product() if WooC is version 1.6.0+
 * @uses genesiswooc_product_taxonomy() for earlier WooC versions
 *
 * @since 0.9.0
 */
function genesiswooc_product_taxonomy_loop() {

	global $woocommerce;

	$new = version_compare( $woocommerce->version, '1.6.0', '>=' );

	if ( $new ) {
		genesiswooc_content_product();
	} else {
		genesiswooc_product_taxonomy();
	}

}

genesis();
