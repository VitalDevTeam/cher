<?php
if (!defined('ABSPATH')) exit;

if (!function_exists('get_social_url')) {

    /**
     * Get social profile URL option from the database
     */
    function cher_profile_url($id = null) {
        if ($id === null) return;
        $url = get_option('cher_' . $id . '_url');
        if (!empty($url)) {
            return $url;
        }
    }
}

if (!function_exists('cher_links')) {

    function cher_links() {

        $cher_show_links = get_option('cher_show_links');

        if (empty($cher_show_links)) {
            return;
        }

        $html = '<div class="cher"><ul class="cher-links">';

        global $post;

        $title = get_the_title();
        $excerpt = get_the_excerpt();
        $url = get_permalink($post->ID);
        $image_src = '';

        if (has_post_thumbnail()) {
            $image_src = get_the_post_thumbnail_url($post->ID, 'large');
        }

        $share_schemes = array(
            'twitter' => array(
                'id' => 'twitter',
                'href_base' => 'https://twitter.com/intent/tweet/',
                'href_params' => array(
                    'url' => $url,
                    'text' => $title
                ),
                'title' => 'Share on Twitter'
            ),
            'facebook' => array(
                'id' => 'facebook',
                'href_base' => 'https://facebook.com/sharer.php',
                'href_params' => array(
                    'u' => $url
                ),
                'title' => 'Share on Facebook'
            ),
            'linkedin' => array(
                'id' => 'linkedin',
                'href_base' => 'https://www.linkedin.com/shareArticle',
                'href_params' => array(
                    'mini' => 'true',
                    'url' => $url,
                    'title' => $title,
                    'summary' => $excerpt,
                    'source' => $url
                ),
                'title' => 'Share on LinkedIn'
            ),
            'googleplus' => array(
                'id' => 'googleplus',
                'href_base' => 'https://plus.google.com/share',
                'href_params' => array(
                    'url' => $url
                ),
                'title' => 'Share on Google+'
            ),
            'pinterest' => array(
                'id' => 'pinterest',
                'href_base' => 'http://pinterest.com/pin/create/button/',
                'href_params' => array(
                    'url' => $url,
                    'media' => $image_src,
                    'description' => $title
                ),
                'title' => 'Share on Pinterest'
            ),
            'email' => array(
                'id' => 'email',
                'href_base' => 'mailto:',
                'href_params' => array(
                    'subject' => $title,
                    'body' => $title . '%0A' . $url
                ),
                'title' => 'Share via Email'
            ),
        );

        foreach ($cher_show_links as $link) {

            $profile = $share_schemes[$link];
            $share_id = $profile['id'];

            if ($share_id === 'email') {
                $share_url = $profile['href_base'] . '?';
                $share_url .= 'subject=' . $profile['href_params']['subject'];
                $share_url .= '&amp;body=' . $profile['href_params']['body'];
            } else {
                $share_url = $profile['href_base'] . '?';
                $share_url .= http_build_query($profile['href_params']);
            }

            $share_title = $profile['title'];

            $html .= '<li class="cher-link-item cher-link-' . $share_id . '">';
            $html .= '<a id="cher-link-' . $share_id . '" class="cher-link" href="' . $share_url . '" title="' . esc_attr($share_title) . '" rel="nofollow,noopener"';

            if ($share_id !== 'email') {
                $html .= ' target="_blank"';
            }

            $html .= '><span class="cher-link-text">' . esc_html($share_title) . '</span>';
            $html .= "</a></li>";

        }

        $html .= '</ul></div>';

        echo $html;

    }

    function cher_shortcode($content = null) {
        ob_start();
        cher_links();
        $output_string = ob_get_contents();
        ob_end_clean();
        return force_balance_tags($output_string);
    }

    add_shortcode('cher-links', 'cher_shortcode');

}