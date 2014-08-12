<?php
/*
	Plugin Name: Vital Share Plugin
	Plugin URI: https://vtldesign.com
	Description: Custom, lightweight social sharing buttons
	Author: Vital
	Author URI: http://vtldesign.com
*/

function vital_share( $attr_twitter = null, $attr_items = null ) {

	// parse variables
	$twitter_account = $attr_twitter;
	$item_toggles = $attr_items;

	// get post content and urlencode it
	global $post;
	$browser_title_encoded = urlencode( trim( wp_title( '', false, 'right' ) ) );
	$page_title_encoded = urlencode( get_the_title() );
	$page_url_encoded = urlencode( get_permalink($post->ID) );

	// create share items array
	$share_items = array ();

	// set each item
	$item_facebook = array(
		"class" => "facebook",
		"href" => "http://www.facebook.com/sharer.php?u={$page_url_encoded}&amp;t={$browser_title_encoded}",
		"text" => "Share on Facebook"
	);
	$item_twitter = array(
		"class" => "twitter",
		"href" => "http://twitter.com/share?text={$page_title_encoded}&amp;url={$page_url_encoded}&amp;via={$twitter_account}",
		"text" => "Share on Twitter"
	);
	$item_google = array(
		"class" => "google",
		"href" => "http://plus.google.com/share?url={$page_url_encoded}",
		"text" => "Share on Google+"
	);

	// test whether to display each item
	if($item_toggles) {
		// explode into array
		$item_toggles_array = explode( ",", $item_toggles );
		// set each item on or off
		$show_facebook = $item_toggles_array['0'];
		$show_twitter = $item_toggles_array['1'];
		$show_google = $item_toggles_array['2'];
	}
	else {
		$display_all_items = 1;
	}

	// form array of items set to 1
	if( $show_facebook==1 || $display_all_items ) {
		array_push( $share_items, $item_facebook );
	}
	if( $show_twitter==1 || $display_all_items) {
		array_push( $share_items, $item_twitter );
	}
	if( $show_google==1 || $display_all_items) {
		array_push( $share_items, $item_google );
	}

	// if one or more items
	if ( ! empty( $share_items ) ) {
		// create output
		$share_output = "<ul class=\"vtl-share\">\n";
		foreach ( $share_items as $share_item ) {
			$share_output .= "<li class=\"vtl-share-item\">\n";
			$share_output .= "<a class=\"vtl-share-link ico-{$share_item['class']}\" href=\"{$share_item['href']}\" rel=\"nofollow\" target=\"_blank\">{$share_item['text']}</a>\n";
			$share_output .= "</li>\n";
		}
		$share_output .= "</ul>";
		// echo output
		echo $share_output;
	}

}

// add shortcode to output buttons
function vital_share_shortcode( $atts, $content = null ) {
	// parse variables / set defaults
	extract( shortcode_atts( array(
		'twitter' => '',
		'display' => '1,1,1',
	), $atts ) );
	// output buttons
	ob_start();
	vital_share( $twitter, $display );
	$output_string = ob_get_contents();
	ob_end_clean();
	return force_balance_tags( $output_string );
}

add_shortcode( 'share-buttons', 'vital_share_shortcode' );

?>