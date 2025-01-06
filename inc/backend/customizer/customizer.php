<?php
/**
 * Theme customizer
 *
 * @package Xhub
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add hook to load Kirki textdomain at the correct time
add_action('after_setup_theme', function() {
    if (class_exists('Kirki')) {
        load_textdomain('kirki', get_template_directory() . '/languages/kirki.mo');
    }
}, 20);

class Xhub_Customize {
	/**
	 * Customize settings
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * The class constructor
	 *
	 * @param array $config
	 */
	public function __construct( $config ) {
        $this->config = $config;

        // Move Kirki initialization to init hook
        add_action('init', array($this, 'init_kirki'));
    }

    /**
     * Initialize Kirki
     */
    public function init_kirki() {
        if ( ! class_exists( 'Kirki' ) ) {
            return;
        }

        $this->register();
    }

	/**
	 * Register settings
	 */
	public function register() {

		/**
		 * Add the theme configuration
		 */
		if ( ! empty( $this->config['theme'] ) ) {
			Kirki::add_config(
				$this->config['theme'], array(
					'capability'  => 'edit_theme_options',
					'option_type' => 'theme_mod',
				)
			);
		}

		/**
		 * Add panels
		 */
		if ( ! empty( $this->config['panels'] ) ) {
			foreach ( $this->config['panels'] as $panel => $settings ) {
				Kirki::add_panel( $panel, $settings );
			}
		}

		/**
		 * Add sections
		 */
		if ( ! empty( $this->config['sections'] ) ) {
			foreach ( $this->config['sections'] as $section => $settings ) {
				Kirki::add_section( $section, $settings );
			}
		}

		/**
		 * Add fields
		 */
		if ( ! empty( $this->config['theme'] ) && ! empty( $this->config['fields'] ) ) {
			foreach ( $this->config['fields'] as $name => $settings ) {
				if ( ! isset( $settings['settings'] ) ) {
					$settings['settings'] = $name;
				}

				Kirki::add_field( $this->config['theme'], $settings );
			}
		}
	}

	/**
	 * Get config ID
	 *
	 * @return string
	 */
	public function get_theme() {
		return $this->config['theme'];
	}

	/**
	 * Get customize setting value
	 *
	 * @param string $name
	 *
	 * @return bool|string
	 */
	public function get_option( $name ) {

		$default = $this->get_option_default( $name );

		return get_theme_mod( $name, $default );
	}

	/**
	 * Get default option values
	 *
	 * @param $name
	 *
	 * @return mixed
	 */
	public function get_option_default( $name ) {
		if ( ! isset( $this->config['fields'][ $name ] ) ) {
			return false;
		}

		return isset( $this->config['fields'][ $name ]['default'] ) ? $this->config['fields'][ $name ]['default'] : false;
	}
}

/**
 * This is a short hand function for getting setting value from customizer
 *
 * @param string $name
 *
 * @return bool|string
 */
function xhub_get_option( $name ) {
	global $xhub_customize;

	$value = false;

	if ( class_exists( 'Kirki' ) ) {
		$value = Kirki::get_option( 'xhub', $name );
	} elseif ( ! empty( $xhub_customize ) ) {
		$value = $xhub_customize->get_option( $name );
	}

	return apply_filters( 'xhub_get_option', $value, $name );
}

/**
 * Get default option values
 *
 * @param $name
 *
 * @return mixed
 */
function xhub_get_option_default( $name ) {
	global $xhub_customize;

	if ( empty( $xhub_customize ) ) {
		return false;
	}

	return $xhub_customize->get_option_default( $name );
}

/**
 * Move some default sections to `general` panel that registered by theme
 *
 * @param object $wp_customize
 */
function xhub_customize_modify( $wp_customize ) {
	$wp_customize->get_section( 'title_tagline' )->panel     = 'general';
	$wp_customize->get_section( 'static_front_page' )->panel = 'general';
}

add_action( 'customize_register', 'xhub_customize_modify' );


/**
 * Get customize settings
 *
 * Priority (Order) WordPress Live Customizer default: 
 * @link https://developer.wordpress.org/themes/customize-api/customizer-objects/
 *
 * @return array
 */
function xhub_customize_settings() {
	/**
	 * Customizer configuration
	 */

	$settings = array(
		'theme' => 'xhub',
	);

	$panels = array(
		'general'         => array(
			'priority'    => 5,
			'title'       => esc_html__( 'General', 'xhub' ),
        ),
        'blog'        => array(
			'title'      => esc_html__( 'Blog', 'xhub' ),
			'priority'   => 10,
			'capability' => 'edit_theme_options',
		),
        'portfolio'       => array(
			'title'       => esc_html__( 'Portfolio', 'xhub' ),
			'priority'    => 10,
			'capability'  => 'edit_theme_options',			
		),
	);

	$sections = array(
        /* header */
        'main_header'     => array(
            'title'       => esc_html__( 'Header', 'xhub' ),
            'description' => '',
            'priority'    => 8,
            'capability'  => 'edit_theme_options',
        ),
        /* page header */
        'page_header'     => array(
            'title'       => esc_html__( 'Page Header', 'xhub' ),
            'description' => '',
            'priority'    => 9,
            'capability'  => 'edit_theme_options',
        ),
        /* blog */
        'blog_page'           => array(
			'title'       => esc_html__( 'Blog Page', 'xhub' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'blog',
		),
        'single_post'           => array(
			'title'       => esc_html__( 'Single Post', 'xhub' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'blog',
        ),
        /* footer */
        'footer'         => array(
			'title'      => esc_html__( 'Footer', 'xhub' ),
			'priority'   => 10,
			'capability' => 'edit_theme_options',
		),
        /* portfolio */
        'portfolio_page'  => array(
			'title'       => esc_html__( 'Archive Page', 'xhub' ),
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'portfolio',			
		),
		'portfolio_post'  => array(
			'title'       => esc_html__( 'Single Page', 'xhub' ),
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'portfolio',			
		),
		/* typography */
		'typography'           => array(
            'title'       => esc_html__( 'Typography', 'xhub' ),
            'description' => '',
            'priority'    => 15,
            'capability'  => 'edit_theme_options',
        ),
		/* 404 */
		'error_404'       => array(
            'title'       => esc_html__( '404', 'xhub' ),
            'description' => '',
            'priority'    => 11,
            'capability'  => 'edit_theme_options',
        ),
        /* color scheme */
        'color_scheme'   => array(
			'title'      => esc_html__( 'Color Scheme', 'xhub' ),
			'priority'   => 200,
			'capability' => 'edit_theme_options',
		),
		/* js code */
		'script_code'   => array(
			'title'      => esc_html__( 'Google Analytics(Script Code)', 'xhub' ),
			'priority'   => 210,
			'capability' => 'edit_theme_options',
		),
	);

	$fields = array(
        /* header settings */
		'header_layout'   => array(
			'type'        => 'select',  
	 		'label'       => esc_attr__( 'Select Header Desktop', 'xhub' ), 
	 		'description' => esc_attr__( 'Choose the header on desktop.', 'xhub' ), 
	 		'section'     => 'main_header', 
	 		'default'     => '', 
	 		'priority'    => 3,
	 		'placeholder' => esc_attr__( 'Select a header', 'xhub' ), 
	 		'choices'     => ( class_exists( 'Kirki_Helper' ) ) ? Kirki_Helper::get_posts( array( 'post_type' => 'xp_header_builders', 'posts_per_page' => -1 ) ) : array(),
		),
		'header_fixed'    => array(
            'type'        => 'toggle',
			'label'       => esc_html__( 'Header Transparent?', 'xhub' ),
	 		'description' => esc_attr__( 'Enable when your header is transparent.', 'xhub' ), 
            'section'     => 'main_header',
			'default'     => '1',
			'priority'    => 4,
        ),
        'header_mobile'   => array(
			'type'        => 'select',  
	 		'label'       => esc_attr__( 'Select Header Mobile', 'xhub' ), 
	 		'description' => esc_attr__( 'Choose the header on mobile.', 'xhub' ), 
	 		'section'     => 'main_header', 
	 		'default'     => '', 
	 		'priority'    => 5,
	 		'placeholder' => esc_attr__( 'Select a header', 'xhub' ), 
	 		'choices'     => ( class_exists( 'Kirki_Helper' ) ) ? Kirki_Helper::get_posts( array( 'post_type' => 'xp_header_builders', 'posts_per_page' => -1 ) ) : array(),
        ),
        'is_sidepanel'    => array(
            'type'        => 'toggle',
            'label'       => esc_html__( 'Side Panel for all site?', 'xhub' ),
            'section'     => 'main_header',
            'default'     => '1',
            'priority'    => 6,
        ),
        'sidepanel_layout'     => array(
			'type'        => 'select',  
	 		'label'       => esc_attr__( 'Select Side Panel', 'xhub' ), 
	 		'description' => esc_attr__( 'Choose the side panel on header.', 'xhub' ), 
	 		'section'     => 'main_header', 
	 		'default'     => '', 
	 		'priority'    => 6,
	 		'placeholder' => esc_attr__( 'Select a panel', 'xhub' ), 
	 		'choices'     => ( class_exists( 'Kirki_Helper' ) ) ? Kirki_Helper::get_posts( array( 'post_type' => 'xp_header_builders', 'posts_per_page' => -1 ) ) : array(),
            'active_callback' => array(
                array(
                    'setting'  => 'is_sidepanel',
                    'operator' => '!=',
                    'value'    => '',
                ),
            ),
		),
		'panel_left'     => array(
            'type'        => 'toggle',
			'label'       => esc_html__( 'Side Panel On Left', 'xhub' ),
            'section'     => 'main_header',
			'default'     => '0',
			'priority'    => 7,
            'active_callback' => array(
                array(
                    'setting'  => 'is_sidepanel',
                    'operator' => '!=',
                    'value'    => '',
                ),
                array(
                    'setting'  => 'sidepanel_layout',
                    'operator' => '!=',
                    'value'    => '',
                ),
            ),
        ),
        /*page header */
        'pheader_switch'  => array(
            'type'        => 'toggle',
            'label'       => esc_html__( 'Page Header On/Off', 'xhub' ),
            'section'     => 'page_header',
            'default'     => 1,
            'priority'    => 10,
        ),
        'breadcrumbs'     => array(
            'type'        => 'toggle',
            'label'       => esc_html__( 'Breadcrumbs On/Off', 'xhub' ),
            'section'     => 'page_header',
            'default'     => 1,
            'priority'    => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'pheader_switch',
                    'operator' => '==',
                    'value'    => 1,
                ),
            ),
        ),
        'left_bread'     => array(
            'type'        => 'toggle',
            'label'       => esc_html__( 'Breadcrumbs On Left', 'xhub' ),
            'section'     => 'page_header',
            'default'     => 0,
            'priority'    => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'pheader_switch',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'breadcrumbs',
                    'operator' => '==',
                    'value'    => 1,
                ),
            ),
        ),
        'pheader_img'  => array(
            'type'     => 'image',
            'label'    => esc_html__( 'Background Image', 'xhub' ),
            'section'  => 'page_header',
            'default'  => '',
            'priority' => 10,
            'output'    => array(
                array(
                    'element'  => '.page-header',
                    'property' => 'background-image'
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'pheader_switch',
                    'operator' => '==',
                    'value'    => 1,
                ),
            ),
        ),
        'pheader_color'    => array(
            'type'     => 'color',
            'label'    => esc_html__( 'Background Color', 'xhub' ),
            'section'  => 'page_header',
            'priority' => 10,
            'output'    => array(
                array(
                    'element'  => '.page-header',
                    'property' => 'background-color'
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'pheader_switch',
                    'operator' => '==',
                    'value'    => 1,
                ),
            ),
        ),
        'ptitle_color'    => array(
            'type'     => 'color',
            'label'    => esc_html__( 'Title Color', 'xhub' ),
            'section'  => 'page_header',
            'priority' => 10,
            'output'    => array(
                array(
                    'element'  => '.page-header .page-title',
                    'property' => 'color'
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'pheader_switch',
                    'operator' => '==',
                    'value'    => 1,
                ),
            ),
        ),
        'bread_color'    => array(
            'type'     => 'color',
            'label'    => esc_html__( 'Breadcrumbs Color', 'xhub' ),
            'section'  => 'page_header',
            'priority' => 10,
            'output'    => array(
                array(
                    'element'  => '.page-header .breadcrumbs li, .page-header .breadcrumbs li a, .page-header .breadcrumbs li a:hover, .page-header .breadcrumbs li:before',
                    'property' => 'color'
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'pheader_switch',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'breadcrumbs',
                    'operator' => '==',
                    'value'    => 1,
                ),
            ),
        ),
        'pheader_height'  => array(
            'type'     => 'dimensions',
            'label'    => esc_html__( 'Page Header Height (Ex: 300px)', 'xhub' ),
            'section'  => 'page_header',
            'transport' => 'auto',
            'priority' => 10,
            'choices'   => array(
                'desktop' => esc_attr__( 'Desktop', 'xhub' ),
                'tablet'  => esc_attr__( 'Tablet', 'xhub' ),
                'mobile'  => esc_attr__( 'Mobile', 'xhub' ),
            ),
            'output'   => array(
                array(
                    'choice'      => 'mobile',
                    'element'     => '.page-header',
                    'property'    => 'height',
                    'media_query' => '@media (max-width: 767px)',
                ),
                array(
                    'choice'      => 'tablet',
                    'element'     => '.page-header',
                    'property'    => 'height',
                    'media_query' => '@media (min-width: 768px) and (max-width: 1024px)',
                ),
                array(
                    'choice'      => 'desktop',
                    'element'     => '.page-header',
                    'property'    => 'height',
                    'media_query' => '@media (min-width: 1024px)',
                ),
            ),
            'default' => array(
                'desktop' => '',
                'tablet'  => '',
                'mobile'  => '',
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'pheader_switch',
                    'operator' => '==',
                    'value'    => 1,
                ),
            ),
        ),
        'head_size'  => array(
            'type'     => 'dimensions',
            'label'    => esc_html__( 'Page Title Size (Ex: 30px)', 'xhub' ),
            'section'  => 'page_header',
            'transport' => 'auto',
            'priority' => 10,
            'choices'   => array(
                'desktop' => esc_attr__( 'Desktop', 'xhub' ),
                'tablet'  => esc_attr__( 'Tablet', 'xhub' ),
                'mobile'  => esc_attr__( 'Mobile', 'xhub' ),
            ),
            'output'   => array(
                array(
                    'choice'      => 'mobile',
                    'element'     => '.page-header .page-title',
                    'property'    => 'font-size',
                    'media_query' => '@media (max-width: 767px)',
                ),
                array(
                    'choice'      => 'tablet',
                    'element'     => '.page-header .page-title',
                    'property'    => 'font-size',
                    'media_query' => '@media (min-width: 768px) and (max-width: 1024px)',
                ),
                array(
                    'choice'      => 'desktop',
                    'element'     => '.page-header .page-title',
                    'property'    => 'font-size',
                    'media_query' => '@media (min-width: 1024px)',
                ),
            ),
            'default' => array(
                'desktop' => '',
                'tablet'  => '',
                'mobile'  => '',
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'pheader_switch',
                    'operator' => '==',
                    'value'    => 1,
                ),
            ),
        ),
        /* blog settings */
		'blog_layout'           => array(
			'type'        => 'radio-image',
			'label'       => esc_html__( 'Blog Layout', 'xhub' ),
			'section'     => 'blog_page',
			'default'     => 'content-sidebar',
			'priority'    => 7,
			'description' => esc_html__( 'Select default sidebar for the blog page.', 'xhub' ),
			'choices'     => array(
				'content-sidebar' 	=> get_template_directory_uri() . '/inc/backend/images/right.png',
				'sidebar-content' 	=> get_template_directory_uri() . '/inc/backend/images/left.png',
				'full-content' 		=> get_template_directory_uri() . '/inc/backend/images/full.png',
			)
		),
        'blog_style'           => array(
            'type'        => 'select',
            'label'       => esc_html__( 'Blog Style', 'xhub' ),
            'section'     => 'blog_page',
            'default'     => 'list',
            'priority'    => 8,
            'description' => esc_html__( 'Select style default for the blog page.', 'xhub' ),
            'choices'     => array(
                'list' => esc_attr__( 'Blog List', 'xhub' ),
                'grid' => esc_attr__( 'Blog Grid', 'xhub' ),
            ),
        ),
        'blog_columns'           => array(
            'type'        => 'select',
            'label'       => esc_html__( 'Blog Columns', 'xhub' ),
            'section'     => 'blog_page',
            'default'     => 'pf_2_cols',
            'priority'    => 8,
            'description' => esc_html__( 'Select columns default for the blog page.', 'xhub' ),
            'choices'     => array(
                'pf_2_cols' => esc_attr__( '2 Columns', 'xhub' ),
                'pf_3_cols' => esc_attr__( '3 Columns', 'xhub' ),
                'pf_4_cols' => esc_attr__( '4 Columns', 'xhub' ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'blog_style',
                    'operator' => '==',
                    'value'    => 'grid',
                ),
            ),
        ),	
		'post_entry_meta'              => array(
            'type'     => 'multicheck',
            'label'    => esc_html__( 'Entry Meta', 'xhub' ),
            'section'  => 'blog_page',
            'default'  => array( 'date', 'author', 'comm' ),
            'choices'  => array(
                'date'    => esc_html__( 'Date', 'xhub' ),
                'author'  => esc_html__( 'Author', 'xhub' ),
                'comm'    => esc_html__( 'Comment', 'xhub' ),
            ),
            'priority' => 10,
        ),
        /* single blog */
        'single_post_layout'           => array(
            'type'        => 'radio-image',
            'label'       => esc_html__( 'Layout', 'xhub' ),
            'section'     => 'single_post',
            'default'     => 'content-sidebar',
            'priority'    => 10,
            'choices'     => array(
				'content-sidebar' 	=> get_template_directory_uri() . '/inc/backend/images/right.png',
				'sidebar-content' 	=> get_template_directory_uri() . '/inc/backend/images/left.png',
				'full-content' 		=> get_template_directory_uri() . '/inc/backend/images/full.png',
			)
        ),
        'ptitle_post'               => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Page Title', 'xhub' ),
			'section'         => 'single_post',
			'default'         => esc_html__( 'Blog Single', 'xhub' ),
			'priority'        => 10,
		),
		'single_separator1'     => array(
			'type'        => 'custom',
			'label'       => esc_html__( 'Social Share', 'xhub' ),
			'section'     => 'single_post',
			'default'     => '<hr>',
			'priority'    => 10,
		),
        'post_socials'              => array(
            'type'     => 'multicheck',
            'section'  => 'single_post',
            'default'  => array( 'twitter', 'facebook', 'pinterest', 'linkedin' ),
            'choices'  => array(
                'twit'  	=> esc_html__( 'Twitter', 'xhub' ),
                'face'    	=> esc_html__( 'Facebook', 'xhub' ),
                'pint'     	=> esc_html__( 'Pinterest', 'xhub' ),
                'link'     	=> esc_html__( 'Linkedin', 'xhub' ),
                'google'  	=> esc_html__( 'Google Plus', 'xhub' ),
                'tumblr'    => esc_html__( 'Tumblr', 'xhub' ),
                'reddit'    => esc_html__( 'Reddit', 'xhub' ),
                'vk'     	=> esc_html__( 'VK', 'xhub' ),
            ),
            'priority' => 10,
        ),
        'single_separator2'     => array(
			'type'        => 'custom',
			'label'       => esc_html__( 'Entry Footer', 'xhub' ),
			'section'     => 'single_post',
			'default'     => '<hr>',
			'priority'    => 10,
		),
        'author_box'      => array(
			'type'        => 'checkbox',
			'label'       => esc_attr__( 'Author Info Box', 'xhub' ),
			'section'     => 'single_post',
			'default'     => true,
			'priority'    => 10,
		),
		'post_nav'     	  => array(
			'type'        => 'checkbox',
			'label'       => esc_attr__( 'Post Navigation', 'xhub' ),
			'section'     => 'single_post',
			'default'     => true,
			'priority'    => 10,
		),
		'related_post'    => array(
			'type'        => 'checkbox',
			'label'       => esc_attr__( 'Related Posts', 'xhub' ),
			'section'     => 'single_post',
			'default'     => true,
			'priority'    => 10,
        ),
        /* project settings */
		'portfolio_archive'           => array(
			'type'        => 'select',
			'label'       => esc_html__( 'Portfolio Archive', 'xhub' ),
			'section'     => 'portfolio_page',
			'default'     => 'archive_default',
			'priority'    => 1,
			'description' => esc_html__( 'Select page default for the portfolio archive page.', 'xhub' ),
			'choices'     => array(
				'archive_default' => esc_attr__( 'Archive page default', 'xhub' ),
				'archive_custom' => esc_attr__( 'Archive page custom', 'xhub' ),
			),
		),
		'archive_page_custom'     => array(
			'type'        => 'dropdown-pages',  
	 		'label'       => esc_attr__( 'Select Page', 'xhub' ), 
	 		'description' => esc_attr__( 'Choose a custom page for archive portfolio page.', 'xhub' ), 
	 		'section'     => 'portfolio_page', 
	 		'default'     => '', 
	 		'priority'    => 2,	 		
	 		'active_callback' => array(
				array(
					'setting'  => 'portfolio_archive',
					'operator' => '==',
					'value'    => 'archive_custom',
				),
			),
		),
		'portfolio_column'           => array(
			'type'        => 'select',
			'label'       => esc_html__( 'Portfolio Columns', 'xhub' ),
			'section'     => 'portfolio_page',
			'default'     => '3cl',
			'priority'    => 3,
			'description' => esc_html__( 'Select default column for the portfolio page.', 'xhub' ),
			'choices'     => array(
				'2cl' => esc_attr__( '2 Column', 'xhub' ),
				'3cl' => esc_attr__( '3 Column', 'xhub' ),
				'4cl' => esc_attr__( '4 Column', 'xhub' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'portfolio_archive',
					'operator' => '==',
					'value'    => 'archive_default',
				),
			),
		),
		'portfolio_style'           => array(
			'type'        => 'select',
			'label'       => esc_html__( 'Hover Style', 'xhub' ),
			'section'     => 'portfolio_page',
			'default'     => 'style1',
			'priority'    => 4,
			'description' => esc_html__( 'Select default style for the portfolio page.', 'xhub' ),
			'choices'     => array(
				'style1' => esc_attr__( 'Background Overlay', 'xhub' ),
				'style2' => esc_attr__( 'Background Solid', 'xhub' ),
				'style3' => esc_attr__( 'Hidden', 'xhub' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'portfolio_archive',
					'operator' => '==',
					'value'    => 'archive_default',
				),
			),
		),
		'portfolio_posts_per_page' => array(
			'type'        => 'number',
			'section'     => 'portfolio_page',
			'priority'    => 5,
			'label'       => esc_html__( 'Posts per page', 'xhub' ),			
			'description' => esc_html__( 'Change Posts Per Page for Portfolio Archive, Taxonomy.', 'xhub' ),
			'default'     => '',
			'active_callback' => array(
				array(
					'setting'  => 'portfolio_archive',
					'operator' => '==',
					'value'    => 'archive_default',
				),
			),
		),
		'pf_nav'     	  => array(
			'type'        => 'toggle',
			'label'       => esc_attr__( 'Projects Navigation On/Off', 'xhub' ),
			'section'     => 'portfolio_post',
			'default'     => 1,
			'priority'    => 7,
		),
		'pf_related_switch'     => array(
			'type'        => 'toggle',
			'label'       => esc_attr__( 'Related Projects On/Off', 'xhub' ),
			'section'     => 'portfolio_post',
			'default'     => 1,
			'priority'    => 7,
		),
		'pf_related_text'      => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Related Projects Heading', 'xhub' ),
			'section'         => 'portfolio_post',
			'default'         => esc_html__( 'Related Projects', 'xhub' ),
			'priority'        => 7,
			'active_callback' => array(
				array(
					'setting'  => 'pf_related_switch',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
        /* footer settings */
		'footer_layout'     => array(
			'type'        => 'select',  
	 		'label'       => esc_attr__( 'Select Footer', 'xhub' ), 
	 		'description' => esc_attr__( 'Choose a footer for all site here.', 'xhub' ), 
	 		'section'     => 'footer', 
	 		'default'     => '', 
	 		'priority'    => 1,
	 		'placeholder' => esc_attr__( 'Select a footer', 'xhub' ), 
	 		'choices'     => ( class_exists( 'Kirki_Helper' ) ) ? Kirki_Helper::get_posts( array( 'post_type' => 'xp_footer_builders', 'posts_per_page' => -1 ) ) : array(),
		),
        'footer_fixed'  => array(
            'type'        => 'toggle',
            'label'       => esc_html__( 'Footer Fixed On/Off?', 'xhub' ),
            'section'     => 'footer',
            'default'     => 0,
            'priority'    => 2,
        ),
		'backtotop_separator'     => array(
			'type'        => 'custom',
			'label'       => '',
			'section'     => 'footer',
			'default'     => '<hr>',
			'priority'    => 3,
		),
		'backtotop'  => array(
            'type'        => 'toggle',
            'label'       => esc_html__( 'Back To Top On/Off?', 'xhub' ),
            'section'     => 'footer',
            'default'     => 1,
            'priority'    => 4,
        ),
        'bg_backtotop'    => array(
            'type'     => 'color',
            'label'    => esc_html__( 'Background Color', 'xhub' ),
            'section'  => 'footer',
            'priority' => 5,
            'default'     => '',
            'output'    => array(
                array(
                    'element'  => '#back-to-top',
                    'property' => 'background',
                ),
            ),
            'active_callback' => array(
				array(
					'setting'  => 'backtotop',
					'operator' => '==',
					'value'    => 1,
				),
			),
        ),
        'color_backtotop' => array(
            'type'     => 'color',
            'label'    => esc_html__( 'Color', 'xhub' ),
            'section'  => 'footer',
            'priority' => 6,
            'default'     => '',
            'output'    => array(
                array(
                    'element'  => '#back-to-top > i:before',
                    'property' => 'color',
                )
            ),
            'active_callback' => array(
				array(
					'setting'  => 'backtotop',
					'operator' => '==',
					'value'    => 1,
				),
			),
        ),
        'spacing_backtotop' => array(
            'type'     => 'dimensions',
            'label'    => esc_html__( 'Spacing', 'xhub' ),
            'section'  => 'footer',
            'priority' => 7,
            'default'     => array(
				'bottom'  => '',
				'right' => '',
			),
			'choices'     => array(
				'labels' => array(
					'bottom'  => esc_html__( 'Bottom (Ex: 20px)', 'xhub' ),
					'right'   => esc_html__( 'Right (Ex: 20px)', 'xhub' ),
				),
			),
            'output'    => array(
                array(
                    'choice'      => 'bottom',
                    'element'     => '#back-to-top.show',
                    'property'    => 'bottom',
                ),
                array(
                    'choice'      => 'right',
                    'element'     => '#back-to-top.show',
                    'property'    => 'right',
                ),
            ),
            'active_callback' => array(
				array(
					'setting'  => 'backtotop',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		/* typography */
        'body_typo'    => array(
            'type'     => 'typography',
            'label'    => esc_html__( 'Body Font 1', 'xhub' ),
            'section'  => 'typography',
            'priority' => 10,
            'default'  => array(
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'letter-spacing' => '',
                'text-transform' => '',
            ),
            'output'      => array(
                array(
                    'element' => 'body, p, button, input, select, optgroup, textarea, .font-main, .elementor-element .elementor-widget-text-editor, .elementor-element .elementor-widget-icon-list .elementor-icon-list-item',
                ),
            ),
        ),
        'second_font'    => array(
            'type'     => 'typography',
            'label'    => esc_html__( 'Body Font 2', 'xhub' ),
            'section'  => 'typography',
            'priority' => 10,
            'default'  => array(
                'font-family'  	 => '',
            ),
        ),
        'heading1_typo'                           => array(
            'type'     => 'typography',
            'label'    => esc_html__( 'Heading 1', 'xhub' ),
            'section'  => 'typography',
            'priority' => 10,
            'default'  => array(
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'letter-spacing' => '',
                'text-transform' => '',
            ),
            'output'      => array(
                array(
                    'element' => 'h1, .elementor-widget.elementor-widget-heading h1.elementor-heading-title',
                ),
            ),
        ),
        'heading2_typo'                           => array(
            'type'     => 'typography',
            'label'    => esc_html__( 'Heading 2', 'xhub' ),
            'section'  => 'typography',
            'priority' => 10,
            'default'  => array(
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'letter-spacing' => '',
                'text-transform' => '',
            ),
            'output'      => array(
                array(
                    'element' => 'h2, .elementor-widget.elementor-widget-heading h2.elementor-heading-title',
                ),
            ),
        ),
        'heading3_typo'                           => array(
            'type'     => 'typography',
            'label'    => esc_html__( 'Heading 3', 'xhub' ),
            'section'  => 'typography',
            'priority' => 10,
            'default'  => array(
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'letter-spacing' => '',
                'text-transform' => '',
            ),
            'output'      => array(
                array(
                    'element' => 'h3, .elementor-widget.elementor-widget-heading h3.elementor-heading-title',
                ),
            ),
        ),
        'heading4_typo'                           => array(
            'type'     => 'typography',
            'label'    => esc_html__( 'Heading 4', 'xhub' ),
            'section'  => 'typography',
            'priority' => 10,
            'default'  => array(
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'letter-spacing' => '',
                'text-transform' => '',
            ),
            'output'      => array(
                array(
                    'element' => 'h4, .elementor-widget.elementor-widget-heading h4.elementor-heading-title',
                ),
            ),
        ),
        'heading5_typo'                           => array(
            'type'     => 'typography',
            'label'    => esc_html__( 'Heading 5', 'xhub' ),
            'section'  => 'typography',
            'priority' => 10,
            'default'  => array(
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'letter-spacing' => '',
                'text-transform' => '',
            ),
            'output'      => array(
                array(
                    'element' => 'h5, .elementor-widget.elementor-widget-heading h5.elementor-heading-title',
                ),
            ),
        ),
        'heading6_typo'                           => array(
            'type'     => 'typography',
            'label'    => esc_html__( 'Heading 6', 'xhub' ),
            'section'  => 'typography',
            'priority' => 10,
            'default'  => array(
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'letter-spacing' => '',
                'text-transform' => '',
            ),
            'output'      => array(
                array(
                    'element' => 'h6, .elementor-widget.elementor-widget-heading h6.elementor-heading-title',
                ),
            ),
        ),

		/* 404 */
		'page_404'   	  => array(
			'type'        => 'dropdown-pages',  
	 		'label'       => esc_attr__( 'Select Page', 'xhub' ), 
	 		'description' => esc_attr__( 'Choose a custom page for page 404.', 'xhub' ),
	 		'placeholder' => esc_attr__( 'Select a page 404', 'xhub' ), 
	 		'section'     => 'error_404', 
	 		'default'     => '', 
			'priority'    => 3,
		),

		/*color scheme*/
        'bg_body'      => array(
            'type'     => 'color',
            'label'    => esc_html__( 'Background Body', 'xhub' ),
            'section'  => 'color_scheme',
            'default'  => '',
            'priority' => 10,
            'output'   => array(
                array(
                    'element'  => 'body, .site-content',
                    'property' => 'background-color',
                ),
            ),
        ),
        'main_color'   => array(
            'type'     => 'color',
            'label'    => esc_html__( 'Primary Color', 'xhub' ),
            'section'  => 'color_scheme',
            'default'  => '#C19977',
            'priority' => 10,
        ),
        'heading_color'   => array(
            'type'     => 'color',
            'label'    => esc_html__( 'Heading Color', 'xhub' ),
            'section'  => 'color_scheme',
            'default'  => '#191717',
            'priority' => 10,
        ),
        'btn_hover_dark'   => array(
            'type'     => 'color',
            'label'    => esc_html__( 'Button Hover & Dark', 'xhub' ),
            'section'  => 'color_scheme',
            'default'  => '#191717',
            'priority' => 10,
        ),

        /*google atlantic*/
        'js_code'  => array(
            'type'        => 'code',
            'label'       => esc_html__( 'Code', 'xhub' ),
            'section'     => 'script_code',
            'choices'     => [
				'language' => 'js',
			],
            'priority'    => 3,
        ),
		
	);
	$settings['panels']   = apply_filters( 'xhub_customize_panels', $panels );
	$settings['sections'] = apply_filters( 'xhub_customize_sections', $sections );
	$settings['fields']   = apply_filters( 'xhub_customize_fields', $fields );

	return $settings;
}

$xhub_customize = new Xhub_Customize( xhub_customize_settings() );