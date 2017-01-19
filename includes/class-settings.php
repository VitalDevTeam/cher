<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Cher_Settings {

	/**
	 * The single instance of Cher_Settings.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The main plugin object.
	 * @var 	object
	 * @access  public
	 * @since 	1.0.0
	 */
	public $parent = null;

	/**
	 * Prefix for plugin settings.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $base = '';

	/**
	 * Available settings for plugin.
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = array();

	public function __construct ( $parent ) {
		$this->parent = $parent;

		$this->base = 'cher_';

		// Initialise settings
		add_action( 'init', array( $this, 'init_settings' ), 11 );

		// Register plugin settings
		add_action( 'admin_init' , array( $this, 'register_settings' ) );

		// Add settings page to menu
		add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

		// Add settings link to plugins page
		add_filter( 'plugin_action_links_' . plugin_basename( $this->parent->file ) , array( $this, 'add_settings_link' ) );
	}

	/**
	 * Initialise settings
	 * @return void
	 */
	public function init_settings () {
		$this->settings = $this->settings_fields();
	}

	/**
	 * Add settings page to admin menu
	 * @return void
	 */
	public function add_menu_item () {
		$page = add_options_page( __( 'Cher', 'cher' ) , __( 'Cher', 'cher' ) , 'manage_options' , $this->parent->_token . '_settings' ,  array( $this, 'settings_page' ) );
	}

	/**
	 * Add settings link to plugin list table
	 * @param  array $links Existing links
	 * @return array 		Modified links
	 */
	public function add_settings_link ( $links ) {
		$settings_link = '<a href="options-general.php?page=' . $this->parent->_token . '_settings">' . __( 'Settings', 'cher' ) . '</a>';
  		array_unshift( $links, $settings_link );
  		return $links;
	}

	/**
	 * Build settings fields
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields () {

		$settings['profile_urls'] = array(
			'title'					=> __( 'Profiles', 'cher' ),
			'description'			=> __( 'Set the URLs for your social profiles. Use the PHP tags to print your URLs in your page templates.', 'cher' ),
			'fields'				=> array(
				array(
					'id' 			=> 'twitter_url',
					'label'			=> __( 'Twitter' , 'cher' ),
					'description'	=> __( "<code style='cursor: text; font-style: normal;'>&lt;?php echo cher_profile_url('twitter'); ?&gt;</code>", 'cher' ),
					'type'			=> 'url',
					'default'		=> '',
					'placeholder'	=> __( '', 'cher' )
				),
				array(
					'id' 			=> 'facebook_url',
					'label'			=> __( 'Facebook' , 'cher' ),
					'description'	=> __( "<code style='cursor: text; font-style: normal;'>&lt;?php echo cher_profile_url('facebook'); ?&gt;</code>", 'cher' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'cher' )
				),
                array(
                    'id' 			=> 'linkedin_url',
                    'label'			=> __( 'LinkedIn' , 'cher' ),
                    'description'	=> __( "<code style='cursor: text; font-style: normal;'>&lt;?php echo cher_profile_url('linkedin'); ?&gt;</code>", 'cher' ),
                    'type'			=> 'text',
                    'default'		=> '',
                    'placeholder'	=> __( '', 'cher' )
                ),
				array(
					'id' 			=> 'googleplus_url',
					'label'			=> __( 'Google+' , 'cher' ),
					'description'	=> __( "<code style='cursor: text; font-style: normal;'>&lt;?php echo cher_profile_url('googleplus'); ?&gt;</code>", 'cher' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'cher' )
				),
				array(
					'id' 			=> 'youtube_url',
					'label'			=> __( 'YouTube' , 'cher' ),
					'description'	=> __( "<code style='cursor: text; font-style: normal;'>&lt;?php echo cher_profile_url('youtube'); ?&gt;</code>", 'cher' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'cher' )
				),
				array(
					'id' 			=> 'vimeo_url',
					'label'			=> __( 'Vimeo' , 'cher' ),
					'description'	=> __( "<code style='cursor: text; font-style: normal;'>&lt;?php echo cher_profile_url('vimeo'); ?&gt;</code>", 'cher' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'cher' )
				),
				array(
					'id' 			=> 'instagram_url',
					'label'			=> __( 'Instagram' , 'cher' ),
					'description'	=> __( "<code style='cursor: text; font-style: normal;'>&lt;?php echo cher_profile_url('instagram'); ?&gt;</code>", 'cher' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'cher' )
				),
				array(
					'id' 			=> 'pinterest_url',
					'label'			=> __( 'Pinterest' , 'cher' ),
					'description'	=> __( "<code style='cursor: text; font-style: normal;'>&lt;?php echo cher_profile_url('pinterest'); ?&gt;</code>", 'cher' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'cher' )
				),
				array(
					'id' 			=> 'houzz_url',
					'label'			=> __( 'Houzz' , 'cher' ),
					'description'	=> __( "<code style='cursor: text; font-style: normal;'>&lt;?php echo cher_profile_url('houzz'); ?&gt;</code>", 'cher' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'cher' )
				),
			)
		);

		$settings['cher_links'] = array(
			'title'					=> __( 'Share Links', 'cher' ),
			'description'			=> __( "Add the share links to templates using the tag <code>&lt;?php cher_links(); ?&gt;</code>. You can also use the shortcode <code>[cher-links]</code> in the editor.", 'cher' ),
			'fields'				=> array(
                array(
					'id' 			=> 'show_links',
					'label'			=> __( 'Show Links', 'cher' ),
					'description'	=> __( 'Select which links to display.', 'cher' ),
					'type'			=> 'checkbox_multi',
					'options'		=> array( 'twitter' => 'Twitter', 'facebook' => 'Facebook', 'linkedin' => 'LinkedIn', 'googleplus' => 'Google+', 'pinterest' => 'Pinterest', 'email' => 'Email' ),
					'default'		=> array()
				)
			)
		);

		$settings['settings'] = array(
			'title'					=> __( 'Settings', 'cher' ),
			'description'			=> __( '', 'cher' ),
			'fields'				=> array(
                array(
					'id' 			=> 'delete_options',
					'label'			=> __( 'Delete Plugin Settings', 'cher' ),
					'description'	=> __( 'Delete plugin settings on deactivation.', 'cher' ),
					'type'			=> 'checkbox',
					'default'		=> ''
				)
			)
		);

		$settings = apply_filters( $this->parent->_token . '_settings_fields', $settings );

		return $settings;
	}

	/**
	 * Register plugin settings
	 * @return void
	 */
	public function register_settings () {
		if ( is_array( $this->settings ) ) {

			// Check posted/selected tab
			$current_section = '';
			if ( isset( $_POST['tab'] ) && $_POST['tab'] ) {
				$current_section = $_POST['tab'];
			} else {
				if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
					$current_section = $_GET['tab'];
				}
			}

			foreach ( $this->settings as $section => $data ) {

				if ( $current_section && $current_section != $section ) continue;

				// Add section to page
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), $this->parent->_token . '_settings' );

				foreach ( $data['fields'] as $field ) {

					// Validation callback for field
					$validation = '';
					if ( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}

					// Register field
					$option_name = $this->base . $field['id'];
					register_setting( $this->parent->_token . '_settings', $option_name, $validation );

					// Add field to page
					add_settings_field( $field['id'], $field['label'], array( $this->parent->admin, 'display_field' ), $this->parent->_token . '_settings', $section, array( 'field' => $field, 'prefix' => $this->base ) );
				}

				if ( ! $current_section ) break;
			}
		}
	}

	public function settings_section ( $section ) {
		$html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html;
	}

	/**
	 * Load settings page content
	 * @return void
	 */
	public function settings_page () {

		// Build page HTML
		$html = '<div class="wrap" id="' . $this->parent->_token . '_settings">' . "\n";
			$html .= '<h2>' . __( 'Cher' , 'cher' ) . '</h2>' . "\n";

			$tab = '';
			if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
				$tab .= $_GET['tab'];
			}

			// Show page tabs
			if ( is_array( $this->settings ) && 1 < count( $this->settings ) ) {

				$html .= '<h2 class="nav-tab-wrapper">' . "\n";

				$c = 0;
				foreach ( $this->settings as $section => $data ) {

					// Set tab class
					$class = 'nav-tab';
					if ( ! isset( $_GET['tab'] ) ) {
						if ( 0 == $c ) {
							$class .= ' nav-tab-active';
						}
					} else {
						if ( isset( $_GET['tab'] ) && $section == $_GET['tab'] ) {
							$class .= ' nav-tab-active';
						}
					}

					// Set tab link
					$tab_link = add_query_arg( array( 'tab' => $section ) );
					if ( isset( $_GET['settings-updated'] ) ) {
						$tab_link = remove_query_arg( 'settings-updated', $tab_link );
					}

					// Output tab
					$html .= '<a href="' . $tab_link . '" class="' . esc_attr( $class ) . '">' . esc_html( $data['title'] ) . '</a>' . "\n";

					++$c;
				}

				$html .= '</h2>' . "\n";
			}

			$html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";

				// Get settings fields
				ob_start();
				settings_fields( $this->parent->_token . '_settings' );
				do_settings_sections( $this->parent->_token . '_settings' );
				$html .= ob_get_clean();

				$html .= '<p class="submit">' . "\n";
					$html .= '<input type="hidden" name="tab" value="' . esc_attr( $tab ) . '" />' . "\n";
					$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings' , 'cher' ) ) . '" />' . "\n";
				$html .= '</p>' . "\n";
			$html .= '</form>' . "\n";
		$html .= '</div>' . "\n";

		echo $html;
	}

	/**
	 * Main Cher_Settings Instance
	 *
	 * Ensures only one instance of Cher_Settings is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see WordPress_Plugin_Template()
	 * @return Main Cher_Settings instance
	 */
	public static function instance ( $parent ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $parent );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Invalid request.' ), $this->parent->_version );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Invalid request.' ), $this->parent->_version );
	} // End __wakeup()

}