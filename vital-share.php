<?php
/*
    Plugin Name: Vital Share Plugin
    Plugin URI: https://vtldesign.com
    Description: Custom, lightweight social sharing buttons
    Version: 1.0
    Author: Vital
    Author URI: http://vtldesign.com
*/


/*  ==========================================================================
     OPTIONS PAGE
    ==========================================================================  */

function vtlshare_add_options_page() {

    add_options_page(
        'Share Buttons Settings',
        'Share Buttons',
        'administrator',
        'vtlshare_buttons',
        'vtlshare_options_display'
    );

}
add_action( 'admin_menu', 'vtlshare_add_options_page' );

function vtlshare_options_display() {
?>
    <div class="wrap">
        <h2>Share Buttons Settings</h2>
        <p>Add the share buttons to templates using the tag <code>&lt;?php if (function_exists('share_buttons')) { share_buttons(); } ?></code>. You can also use the shortcode <code>[share_buttons]</code> in the editor.</p>
        <form method="post" action="options.php">
            <?php
                settings_fields( 'vtlshare_options' );
                do_settings_sections( 'vtlshare_display_options' );
                do_settings_sections( 'vtlshare_style_options' );

                submit_button();
            ?>
        </form>
    </div>
<?php
}


/*  ==========================================================================
     SETTINGS REGISTRATION
    ==========================================================================  */

/*   Display Options
    --------------------------------------------------------------------------  */

function vtlshare_default_display_options() {

    $defaults = array(
        'show_twitter'       => 1,
        'show_facebook'      => 1,
        'show_googleplus'    => 1,
        'show_linkedin'      => 1
    );
    return apply_filters( 'vtlshare_default_display_options', $defaults );
}

function vtlshare_init_display_options() {

    if ( false == get_option( 'vtlshare_display_options' ) ) {
        add_option( 'vtlshare_display_options', apply_filters( 'vtlshare_default_display_options', vtlshare_default_display_options() ) );
    }

    add_settings_section(
        'vtlshare_display_options_section',
        'Display Options',
        'vtlshare_display_options_callback',
        'vtlshare_display_options'
    );

    add_settings_field(
        'show_twitter',
        'Twitter',
        'vtlshare_show_twitter_callback',
        'vtlshare_display_options',
        'vtlshare_display_options_section'
    );

    add_settings_field(
        'show_facebook',
        'Facebook',
        'vtlshare_show_facebook_callback',
        'vtlshare_display_options',
        'vtlshare_display_options_section'
    );

    add_settings_field(
        'show_googleplus',
        'Google+',
        'vtlshare_show_googleplus_callback',
        'vtlshare_display_options',
        'vtlshare_display_options_section'
    );

    add_settings_field(
        'show_linkedin',
        'LinkedIn',
        'vtlshare_show_linkedin_callback',
        'vtlshare_display_options',
        'vtlshare_display_options_section'
    );

    register_setting(
        'vtlshare_options',
        'vtlshare_display_options'
    );

}
add_action( 'admin_init', 'vtlshare_init_display_options' );


/*   Style Options
    --------------------------------------------------------------------------  */

function vtlshare_default_style_options() {

    $defaults = array(
        'output_css'    => 1
    );
    return apply_filters( 'vtlshare_default_style_options', $defaults );
}

function vtlshare_init_style_options() {

    if ( false == get_option( 'vtlshare_style_options' ) ) {
        add_option( 'vtlshare_style_options', apply_filters( 'vtlshare_default_style_options', vtlshare_default_style_options() ) );
    }

    add_settings_section(
        'vtlshare_style_options_section',
        'Style Options',
        'vtlshare_style_options_callback',
        'vtlshare_style_options'
    );

    add_settings_field(
        'output_css',
        'Output CSS',
        'vtlshare_output_css_callback',
        'vtlshare_style_options',
        'vtlshare_style_options_section',
        array(
            'Uncheck this box to remove all default button styles',
        )
    );

    register_setting(
        'vtlshare_options',
        'vtlshare_style_options'
    );

}
add_action( 'admin_init', 'vtlshare_init_style_options' );


/*  ==========================================================================
     SECTION CALLBACKS
    ==========================================================================  */

/*   Display Options
    --------------------------------------------------------------------------  */

function vtlshare_display_options_callback() {
    echo '<p class="description">Select which buttons to display</p>';
}

/*   Style Options
    --------------------------------------------------------------------------  */

function vtlshare_style_options_callback() {}


/*  ==========================================================================
     FIELD CALLBACKS
    ==========================================================================  */

/*   Display Options
    --------------------------------------------------------------------------  */

function vtlshare_show_twitter_callback($args) {
    $options = get_option('vtlshare_display_options');
    $html = '<input type="checkbox" id="show_twitter" name="vtlshare_display_options[show_twitter]" value="1" ' . checked( 1, isset( $options['show_twitter'] ) ? $options['show_twitter'] : 0, false ) . '/>';
    echo $html;
}

function vtlshare_show_facebook_callback($args) {
    $options = get_option('vtlshare_display_options');
    $html = '<input type="checkbox" id="show_facebook" name="vtlshare_display_options[show_facebook]" value="1" ' . checked( 1, isset( $options['show_facebook'] ) ? $options['show_facebook'] : 0, false ) . '/>';
    echo $html;
}

function vtlshare_show_googleplus_callback($args) {
    $options = get_option('vtlshare_display_options');
    $html = '<input type="checkbox" id="show_googleplus" name="vtlshare_display_options[show_googleplus]" value="1" ' . checked( 1, isset( $options['show_googleplus'] ) ? $options['show_googleplus'] : 0, false ) . '/>';
    echo $html;
}

function vtlshare_show_linkedin_callback($args) {
    $options = get_option('vtlshare_display_options');
    $html = '<input type="checkbox" id="show_linkedin" name="vtlshare_display_options[show_linkedin]" value="1" ' . checked( 1, isset( $options['show_linkedin'] ) ? $options['show_linkedin'] : 0, false ) . '/>';
    echo $html;
}

/*   Style Options
    --------------------------------------------------------------------------  */

function vtlshare_output_css_callback() {
    $options = get_option('vtlshare_style_options');

    $html = '<input type="radio" id="output_css_false" name="vtlshare_style_options[output_css]" value="0"' . checked( 0, $options['output_css'], false ) . '/>';
    $html .= '<label for="output_css_false">No</label>';
    $html .= '&nbsp;&nbsp;&nbsp;&nbsp;';
    $html .= '<input type="radio" id="output_css_true" name="vtlshare_style_options[output_css]" value="1"' . checked( 1, $options['output_css'], false ) . '/>';
    $html .= '<label for="output_css_true">Yes</label>';
    $html .= '<p class="description">Set this option to "No" to disable default button styles.</p>';

    echo $html;
}


/*  ==========================================================================
     ENQUEUE PLUGIN FILES
    ==========================================================================  */

function vtlshare_enqueuer() {

    $style_options = get_option('vtlshare_style_options');

    if ( !is_admin() && 1 == $style_options['output_css'] ) {
        wp_enqueue_style( 'vital_share_css', plugins_url('vital-share.css', __FILE__), null, '1.0');
    }
}

add_action('wp_enqueue_scripts', 'vtlshare_enqueuer');


/*  ==========================================================================
     INITIALIZE AND RENDER BUTTONS
    ==========================================================================  */

function share_buttons() {

    $display_options = get_option('vtlshare_display_options');
    $item_toggles = null;

    global $post;
    $post_title_encoded   = urlencode( get_the_title() );
    $post_excerpt_encoded = urlencode( get_the_excerpt() );
    $post_url_encoded     = urlencode( get_permalink($post->ID) );

    $share_items = array ();

    $twitter_btn = array(
        "class" => "twitter",
        "href" => "https://twitter.com/share?text={$post_title_encoded}&amp;url={$post_url_encoded}&amp;via=Vital_Design",
        "text" => "Share on Twitter"
    );
    $facebook_btn = array(
        "class" => "facebook",
        "href" => "https://www.facebook.com/sharer.php?u={$post_url_encoded}&amp;t={$post_title_encoded}",
        "text" => "Share on Facebook"
    );
    $googleplus_btn = array(
        "class" => "googleplus",
        "href" => "https://plus.google.com/share?url={$post_url_encoded}",
        "text" => "Share on Google+"
    );
    $linkedin_btn = array(
        "class" => "linkedin",
        "href" => "https://www.linkedin.com/shareArticle?mini=true&url={$post_url_encoded}&title={$post_title_encoded}&summary={$post_excerpt_encoded}&source={$post_url_encoded}",
        "text" => "Share on LinkedIn"
    );

    if ( isset( $display_options['show_twitter'] ) && $display_options[ 'show_twitter' ] ) {
        array_push( $share_items, $twitter_btn );
    }
    if ( isset( $display_options['show_facebook'] ) && $display_options[ 'show_facebook' ] ) {
        array_push( $share_items, $facebook_btn );
    }
    if ( isset( $display_options['show_googleplus'] ) && $display_options[ 'show_googleplus' ] ) {
        array_push( $share_items, $googleplus_btn );
    }
    if ( isset( $display_options['show_linkedin'] ) && $display_options[ 'show_linkedin' ] ) {
        array_push( $share_items, $linkedin_btn );
    }

    if ( !empty($share_items) ) {

        $share_output = "<ul id=\"vtlshare-buttons\">\n";
        foreach ( $share_items as $share_item ) {
            $share_output .= "<li class=\"vtlshare-button vtlshare-button-{$share_item['class']}\">";
            $share_output .= "<a class=\"vtlshare-link\" href=\"{$share_item['href']}\" title=\"{$share_item['text']}\" rel=\"nofollow\" target=\"_blank\">{$share_item['text']}</a>";
            $share_output .= "</li>";
        }
        $share_output .= "</ul>";
        echo $share_output;
    }

}

// add shortcode to output buttons
function vtlshare_shortcode( $content = null ) {

    ob_start();
    share_buttons();
    $output_string = ob_get_contents();
    ob_end_clean();
    return force_balance_tags( $output_string );
}

add_shortcode( 'share-buttons', 'vtlshare_shortcode' );
?>