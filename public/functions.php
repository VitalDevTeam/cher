<?php
if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('cher_profile_url')) {

	/**
	 * Get social profile URL option from the database
	 */
	function cher_profile_url($id = null) {
		return get_option("cher_{$id}_url");
	}
}

if (!function_exists('cher_profiles')) {
	function cher_profiles($return = false) {
		$cher_settings = Cher_Settings::instance(null)->settings;
		if (!isset($cher_settings['profile_urls'])) {
			return;
		}

		$profile_links = [];
		$profile_fields = $cher_settings['profile_urls']['fields'];
		foreach ($profile_fields as $profile) {
			$url = get_option("cher_{$profile['id']}");
			if (!$url) {
				continue;
			}

			$id = str_replace('_url', '', $profile['id']);
			$profile_links[] = cher_profile_link($id, $url, $profile['label']);
		}

		$ret = sprintf('<div class="profile-links">%s</div>', implode('', $profile_links));

		if (!$return) {
			echo $ret;
		}

		return $ret;
	}
}

if (!function_exists('cher_profile_link')) {
	function cher_profile_link($id, $url, $label) {
		$label = apply_filters('cher_profile_link_label', $label, $id);
		$label = apply_filters("cher_profile_link_label_{$id}", $label, $id);

		return sprintf('<a href="%s" class="cher-profile-link %s" target="_blank">%s</a>', $url, $id, $label);
	}
}

if (!function_exists('cher_get_schemes')) {
	function cher_get_schemes($post_id = null) {
		$cher_show_links = get_option('cher_show_links');
		if (empty($cher_show_links)) {
			return [];
		}

		if (!$post_id) {
			$post_id = get_the_ID();
		}

		$title = html_entity_decode(get_the_title($post_id));
		$email_title = str_replace('&', '%26', $title);
		$post_content = apply_filters('the_content', get_post_field('post_content', $post_id));
		$excerpt = wp_trim_words($post_content);
		$url = get_permalink($post_id);
		$image_src = '';
		if (has_post_thumbnail($post_id)) {
			$image_src = get_the_post_thumbnail_url($post_id, 'large');
		}

		$ret = [
			'twitter'    => [
				'id'          => 'twitter',
				'title'       => 'Share on Twitter',
				'href_base'   => 'https://twitter.com/intent/tweet/',
				'href_params' => [
					'url'  => $url,
					'text' => $title,
				],
			],

			'facebook'   => [
				'id'          => 'facebook',
				'title'       => 'Share on Facebook',
				'href_base'   => 'https://facebook.com/sharer.php',
				'href_params' => [
					'u' => $url,
				],
			],

			'messenger'  => [
				'id'          => 'messenger',
				'title'       => 'Messenger',
				'href_base'   => $url,
				'href_params' => [],
			],

			'linkedin'   => [
				'id'          => 'linkedin',
				'title'       => 'Follow us on LinkedIn',
				'href_base'   => 'https://www.linkedin.com/shareArticle',
				'href_params' => [
					'mini'    => 'true',
					'url'     => $url,
					'title'   => $title,
					'summary' => $excerpt,
					'source'  => $url,
				],
			],

			'googleplus' => [
				'id'          => 'googleplus',
				'title'       => 'Share on Google+',
				'href_base'   => 'https://plus.google.com/share',
				'href_params' => [
					'url' => $url,
				],
			],

			'pinterest'  => [
				'id'          => 'pinterest',
				'title'       => 'Share on Pinterest',
				'href_base'   => 'http://pinterest.com/pin/create/button/',
				'href_params' => [
					'url'         => $url,
					'media'       => $image_src,
					'description' => $title,
				],
			],

			'email'      => [
				'id'          => 'email',
				'title'       => 'Share via Email',
				'href_base'   => 'mailto:',
				'href_params' => [
					'subject' => $email_title,
					'body'    => $title . '%0A' . $url,
				],
			],
		];

		return array_filter($ret, function($s) use ($cher_show_links) {
			return in_array($s['id'], $cher_show_links);
		});
	}
}

if (!function_exists('cher_links')) {
	function cher_links($return = false, $post_id = null) {
		$share_links = [];
		$share_schemes = cher_get_schemes($post_id);

		foreach ($share_schemes as $share_id => $profile) {
			$share_title = $profile['title'];
			$href_base = $profile['href_base'];
			$href_params = $profile['href_params'];

			$query_string = http_build_query($href_params);
			if ($share_id === 'email') {
				$query_string = str_replace('&', '&amp;', $query_string);
			}

			$share_url = sprintf('%s?%s', $href_base, $query_string);
			$share_links[] = sprintf('<li class="cher-link-item cher-link-%s">%s</li>', $share_id, cher_link($share_id, $share_url, $share_title));
		}

		$html = sprintf('<ul class="cher-links">%s</ul>', implode('', $share_links));

		if (!$return) {
			echo $html;
		}

		return $html;
	}
}

if (!function_exists('cher_link')) {
	function cher_link($share_id, $share_url, $share_title) {
		$share_title = apply_filters('cher_link_title', $share_title, $share_id);
		$share_title = apply_filters("cher_{$share_id}_link_title", $share_title, $share_id);

		$share_url = apply_filters('cher_link_url', $share_url, $share_id);
		$share_url = apply_filters("cher_{$share_id}_link_url", $share_url, $share_id);

		$ret = sprintf('<a href="%s" class="cher-link cher-link-%s" title="%s" target="_blank" rel="nofollow,noopener"><span class="cher-link-text">%s</span></a>',
			$share_url,
			$share_id,
			esc_attr($share_title),
			esc_html($share_title)
		);

		$ret = apply_filters('cher_link', $ret);
		$ret = apply_filters("cher_link_{$share_id}", $ret);

		return $ret;
	}
}

if (!function_exists('cher_shortcode')) {
	function cher_shortcode($content = null) {
		$output_string = cher_links(true);
		return force_balance_tags($output_string);
	}

	add_shortcode('cher-links', 'cher_shortcode');
}
